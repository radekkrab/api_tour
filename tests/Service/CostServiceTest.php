<?php

namespace App\Tests\Service;

use App\Service\CostService;
use PHPUnit\Framework\TestCase;

class CostServiceTest extends TestCase
{
    private CostService $costService;

    protected function setUp(): void
    {
        $this->costService = new CostService();
    }

    public function testCalculateCostWithChildDiscountUnder3()
    {
        $data = [
            'price' => 10000,
            'startDate' => '2025-06-15',
            'birthDate' => '2022-05-01', 
            'payDate' => '2024-11-15',
        ];

        $result = $this->costService->calculateCost($data);
        $this->assertEquals(2000, $result); 
    }

    public function testCalculateCostWithChildDiscount3To6()
    {
        $data = [
            'price' => 10000,
            'startDate' => '2024-12-15',
            'birthDate' => '2020-01-01', 
            'payDate' => '2024-11-15',
        ];

        $result = $this->costService->calculateCost($data);
        $this->assertEquals(2000, $result); 
    }

    public function testCalculateCostWithChildDiscount6To12()
    {
        $data = [
            'price' => 10000,
            'startDate' => '2025-06-15',
            'birthDate' => '2015-05-01', 
            'payDate' => '2024-11-15',
        ];

        $result = $this->costService->calculateCost($data);
        $this->assertEquals(5500, $result); 
    }

    public function testCalculateCostWithChildDiscountAbove12()
    {
        $data = [
            'price' => 10000,
            'startDate' => '2025-06-15',
            'birthDate' => '2000-05-01', 
            'payDate' => '2024-11-15',
        ];

        $result = $this->costService->calculateCost($data);
        $this->assertEquals(9000, $result); 
    }

    public function testCalculateCostWithEarlyBookingDiscount()
    {
        $data = [
            'price' => 10000,
            'startDate' => '2025-06-15',
            'birthDate' => '2010-05-01', 
            'payDate' => '2024-11-15',
        ];

        $result = $this->costService->calculateCost($data);
        $this->assertEquals(9000, $result); 
    }

    public function testCalculateCostWithMaxEarlyBookingDiscount()
    {
        $data = [
            'price' => 10000,
            'startDate' => '2025-06-15',
            'birthDate' => '2010-05-01', 
            'payDate' => '2024-11-15',
        ];

        $result = $this->costService->calculateCost($data);
        $this->assertEquals(9000, $result); 
    }

    public function testCalculateCostWithNoDiscount()
    {
        $data = [
            'price' => 10000,
            'startDate' => '2025-06-15',
            'birthDate' => '1990-05-01', 
            'payDate' => '2024-11-15',
        ];

        $result = $this->costService->calculateCost($data);
        $this->assertEquals(9000, $result); 
    }

    public function testCalculateCostWithEarlyBookingDiscountLimit()
    {
        $data = [
            'price' => 10000,
            'startDate' => '2025-06-15',
            'birthDate' => '2010-05-01', 
            'payDate' => '2024-08-15', 
        ];

        $result = $this->costService->calculateCost($data);
        $this->assertEquals(9000, $result); 
    }
}
