<?php

namespace App\Controller;

use App\Service\CostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    private CostService $costService;

    public function __construct(CostService $costService)
    {
        $this->costService = $costService;
    }

    #[Route('/api/cost/trip', name: 'app_api')]
    public function costTrip(Request $request): JsonResponse
    {
        $data = $request->toArray(); 

        $cost = $this->costService->calculateCost($data);

        return $this->json([
            'cost' => $cost,
            'message' => 'Cost calculated successfully!',
        ]);
    }
}
