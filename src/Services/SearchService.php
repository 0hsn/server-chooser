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
     * @var string project root dir
     */
    protected string $projectRoot = '';

    public function __construct(string $projectRoot)
    {
        $this->projectRoot = $projectRoot;
    }

    /**
     * Load binary data file that stores processed data
     *
     * @return array
     */
    public function loadBinData() : array
    {
        $inFile = $this->projectRoot."/var/uploads/data.bin";

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
                "System is unable to respond at this moment.",
                500,
            );
        }

        if ($filter->isAllEmpty()) {
            return array_values($data);
        }

        $servers = new ArrayCollection($data);
        $criteria = new Criteria();

        if (! empty($filter->ramSize)) {
            foreach ($filter->ramSize as $rs) {
                $criteria->orWhere(new Comparison('RamSize', Comparison::EQ, $rs));
            }
        }

        if (! empty($filter->hddType)) {
            $criteria->where(
                new Comparison('HddType', '=', $filter->hddType)
            );
        }

        if (! empty($filter->storage)) {
            $storageRange = $filter->getStorageRange();

            foreach ($storageRange as $storage) {
                $criteria->orWhere(new Comparison('Storage', Comparison::EQ, $storage));
            }
        }

        $matchingServers = $servers->matching($criteria);
        return array_values($matchingServers->toArray());
    }
}