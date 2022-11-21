<?php

namespace App\Controller\Api;

use App\DTO\SearchFilter;
use App\Services\PaginationService;
use App\Services\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServerController extends AbstractController
{
    #[Route('/api/servers', name: 'app_api_servers', methods: ['GET'])]
    public function index(Request $request, SearchService $searchService): Response
    {
        $filter = SearchFilter::fromRequest($request);
        $perPage = $request->query->getInt('per_page', 15);
        $page = $request->query->getInt('page', 1);

        try {
            $servers = $searchService->search($filter);
        } catch (\Throwable $throwable) {
            return $this->json([
                'error' => [
                    'code' => $throwable->getCode(),
                    'message' => $throwable->getMessage(),
                ]
            ], $throwable->getCode());
        }

        $pagination = PaginationService::fromData($servers, $page, $perPage);

        return $this->json([
            'data' => $pagination->getItems(),
            'meta' => [
                'total' => $pagination->getTotalNumberOfItems(),
                'per_pages' => $pagination->count(),
                'current_page' => $pagination->getCurrentPageNumber(),
                'last_page' => $pagination->getLastPageNumber(),
                'prev_page' => $pagination->getPreviousPageNumber(),
                'next_page' => $pagination->getNextPageNumber(),
            ],
        ]);
    }
}
