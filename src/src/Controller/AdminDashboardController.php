<?php

namespace App\Controller;

use App\Service\Stats;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index(Stats $stats)
    {
        $statistics = $stats->getStats();
        
        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => $statistics
        ]);
    }
}
