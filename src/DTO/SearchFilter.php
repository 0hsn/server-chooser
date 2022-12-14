<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;

class SearchFilter
{
    const STORAGES = [
        '250GB', '500GB', '1TB', '2TB',
        '3TB', '4TB', '8TB', '12TB',
        '24TB', '48TB', '72TB',
    ];

    const RAM_SIZE = [
        '2GB', '4GB', '8GB', '12GB',
        '16GB', '24GB', '32GB', '48GB',
        '64GB', '96GB',
    ];

    const HDD_TYPE = [
        'SAS', 'SATA', 'SSD',
    ];

    const LOCATIONS = [
        'AMS-01' => 'Amsterdam',
        'WDC-01' => 'Washington D.C.',
        'SFO-12' => 'San Francisco',
        'SIN-11' => 'Singapore',
        'DAL-10' => 'Dallas',
        'FRA-10' => 'Frankfurt',
        'HKG-10' => 'Hong Kong',
    ];

    public string $storage = "";
    public array $ramSize = [];
    public string $hddType = "";
    public string $location = "";

    /**
     * Set storage after validation
     *
     * @param string $storage
     * @return void
     */
    public function setStorage(string $storage): void
    {
        $this->storage = in_array($storage, static::STORAGES) ? $storage : '';
    }

    /**
     * Set ram size after validation
     *
     * @param string $ramSize
     * @return void
     */
    public function setRamSize(string $ramSize): void
    {
        foreach(explode(',', $ramSize) as $rs) {
            if (in_array($rs, static::RAM_SIZE)) {
                $this->ramSize[] = $rs;
            }
        }
    }

    /**
     * Set hdd type after validation
     *
     * @param string $hddType
     * @return void
     */
    public function setHDDType(string $hddType): void
    {
        $this->hddType = in_array($hddType, static::HDD_TYPE) ? $hddType : '';
    }

    /**
     * Set location after validation
     *
     * @param string $location
     * @return void
     */
    public function setLocation(string $location): void
    {
        $this->location = in_array($location, array_keys(static::LOCATIONS)) ? $location : '';
    }

    /**
     * Check is all filter data empty
     *
     * @return bool
     */
    public function isAllEmpty() : bool
    {
        return empty($this->storage) &&
            empty($this->ramSize) &&
            empty($this->hddType) &&
            empty($this->location);
    }

    /**
     * @param Request $request
     * @return SearchFilter
     */
    public static function fromRequest(Request $request): static
    {
        $filter = new SearchFilter;

        $filter->setStorage($request->query->get('storage_under', ''));
        $filter->setHDDType($request->query->get('hdd_type', ''));
        $filter->setRamSize($request->query->get('ram_size', ''));
        $filter->setLocation($request->query->get('location', ''));

        return $filter;
    }
}