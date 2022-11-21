<?php

namespace App\Services;

use App\DTO\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class SearchService
{
    /**
     * Load binary data file that stores processed data
     *
     * @return array
     */
    public function loadBinData() : array
    {
        $inFile = getcwd()."/var/uploads/data.bin";

        if (file_exists($inFile) && is_file($inFile)) {
            $serialized = file_get_contents($inFile);
            return unserialize($serialized);
        }

        throw new NotFoundResourceException(
            "Data backend not found. Please run app:load-excel to generate."
        );
    }

    /**
     * @param SearchFilter $filter
     * @return array
     */
    public function search(SearchFilter $filter): array
    {
        try {
            $data = $this->loadBinData();
        } catch (\Throwable $throwable) {
            throw new NotFoundResourceException(
                "System is unable to respond at this moment."
            );
        }

        $servers = new ArrayCollection($data);
        $criteria = new Criteria();

        if (! empty($filter->ramSize)) {
            $criteria->where(
                new Comparison('RamSize', '=', $filter->ramSize)
            );
        }

        if (! empty($filter->hddType)) {
            $criteria->where(
                new Comparison('HddType', '=', $filter->hddType)
            );
        }

        if (! empty($filter->storage)) {
            $criteria->where(
                new Comparison('Storage', '=', $filter->storage)
            );
        }

        $matchingServers = $servers->matching($criteria);
        return array_values($matchingServers->toArray());
    }
}