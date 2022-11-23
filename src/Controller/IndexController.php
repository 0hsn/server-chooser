<?php

namespace App\Controller;

use App\DTO\SearchFilter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'storage_slider_values' => SearchFilter::STORAGES,
            'ram_sizes' => SearchFilter::RAM_SIZE,
            'locations' => SearchFilter::LOCATIONS,
            'hdd_type' => SearchFilter::HDD_TYPE,
        ]);
    }
}
