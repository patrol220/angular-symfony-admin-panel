<?php

namespace App\Controller;

use App\Service\DashboardService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("api/dashboard/statistics", name="get_statistics", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function getStatistics(DashboardService $dashboardService)
    {
        return new JsonResponse(
            $dashboardService->getStatistics()
        );
    }
}
