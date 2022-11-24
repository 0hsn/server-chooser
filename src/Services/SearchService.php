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
                $criteria->orWhere(
                    new Comparison('RamSize', Comparison::EQ, $rs)
                );
            }
        }

        if (! empty($filter->hddType)) {
            $criteria->andWhere(
                new Comparison('HddType', Comparison::EQ, $filter->hddType)
            );
        }

        if (! empty($filter->storage)) {
            $pos = strpos($filter->storage, 'TB');
            $inTB = true;

            if (false === $pos) {
                $pos = strpos($filter->storage, 'GB');
                $inTB = false;
            }

            $storage = substr($filter->storage, 0, $pos);
            if (! $inTB) {
                $storage = $storage / 1000;
            }

            $criteria->andWhere(
                new Comparison('StorageInTB', Comparison::LTE, $storage)
            );
        }

        if (! empty($filter->location)) {
            $criteria->andWhere(
                new Comparison('LocationID', Comparison::EQ, $filter->location)
            );
        }

        $matchingServers = $servers->matching($criteria);
        return array_values($matchingServers->toArray());
    }
}