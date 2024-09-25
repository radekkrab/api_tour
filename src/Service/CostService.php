<?php

namespace App\Service;

class CostService
{
    public function calculateCost(array $data): int
    {
        $price = $data['price'];
        $startDate = new \DateTime($data['startDate']);
        $birthDate = new \DateTime($data['birthDate']);
        $payDate = new \DateTime($data['payDate']);

        // Расчёт детской скидки
        $age = $startDate->diff($birthDate)->y;
        $childDiscount = 0;

        // Определение детской скидки
        if ($age >= 3 && $age < 6) {
            $childDiscount = 0.80; // 80% скидка
        } elseif ($age >= 6 && $age < 12) {
            $childDiscount = 0.30; // 30% скидка, не более 4500 ₽
        } elseif ($age >= 12) {
            $childDiscount = 0.10; // 10% скидка
        }

        // Расчёт скидки за раннее бронирование
        $earlyBookingDiscount = 0;

        if ($startDate >= new \DateTime('2025-04-01') && $startDate <= new \DateTime('2025-09-30')) {
            if ($payDate <= new \DateTime('2024-11-30')) {
                $earlyBookingDiscount = 0.07; // 7%
            } elseif ($payDate <= new \DateTime('2024-12-31')) {
                $earlyBookingDiscount = 0.05; // 5%
            } elseif ($payDate <= new \DateTime('2025-01-31')) {
                $earlyBookingDiscount = 0.03; // 3%
            }
        } elseif ($startDate >= new \DateTime('2024-10-01') && $startDate <= new \DateTime('2025-01-14')) {
            if ($payDate <= new \DateTime('2024-03-31')) {
                $earlyBookingDiscount = 0.07; // 7%
            } elseif ($payDate <= new \DateTime('2024-04-30')) {
                $earlyBookingDiscount = 0.05; // 5%
            } elseif ($payDate <= new \DateTime('2024-05-31')) {
                $earlyBookingDiscount = 0.03; // 3%
            }
        } elseif ($startDate >= new \DateTime('2025-01-15')) {
            if ($payDate <= new \DateTime('2024-08-31')) {
                $earlyBookingDiscount = 0.07; // 7%
            } elseif ($payDate <= new \DateTime('2024-09-30')) {
                $earlyBookingDiscount = 0.05; // 5%
            } elseif ($payDate <= new \DateTime('2024-10-31')) {
                $earlyBookingDiscount = 0.03; // 3%
            }
        }

        if ($childDiscount > 0) {
            $childDiscount = ceil($price * (1 - $childDiscount));
            if ($age >= 6 && $age < 12) $childDiscount = $price - (min($childDiscount, 4500));
        }

        if ($earlyBookingDiscount > 0) {
            $earlyBookingDiscount = ceil($price * (1 - $earlyBookingDiscount));
            $earlyBookingDiscount = min($earlyBookingDiscount, 1500);
        }

        $finalPrice = $childDiscount > $earlyBookingDiscount ? $childDiscount : $earlyBookingDiscount;

        return $finalPrice;
    }
}
