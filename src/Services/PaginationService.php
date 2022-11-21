<?php

namespace App\Services;

use AshleyDawson\SimplePagination\Pagination;
use AshleyDawson\SimplePagination\Paginator;

class PaginationService
{
    /**
     * @param array $data
     * @param int $page
     * @return Pagination
     */
    public static function fromData(array $data, int $page, int $perPage=15) : Pagination
    {
        $paginator = new Paginator();

        $paginator->setItemsPerPage($perPage);

        $paginator->setItemTotalCallback(function () use ($data) {
            return count($data);
        });

        $paginator->setSliceCallback(function ($offset, $length) use ($data) {
            return array_slice($data, $offset, $length);
        });

        return $paginator->paginate($page);
    }

}