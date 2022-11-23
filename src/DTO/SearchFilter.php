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
    public string $ramSize = "";
    public string $hddType = "";

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
        $this->ramSize = in_array($ramSize, static::RAM_SIZE) ? $ramSize : '';
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
     * Check is all filter data empty
     *
     * @return bool
     */
    public function isAllEmpty() : bool
    {
        return empty($this->storage) &&
            empty($this->ramSize) &&
            empty($this->hddType);
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

        return $filter;
    }

    /**
     * @return array
     */
    public function getStorageRange(): array
    {
        $index = array_search($this->storage, static::STORAGES, true);
        if ($index < sizeof(static::STORAGES)) {
            $index++;
        }

        return array_slice(static::STORAGES, 0, $index);
    }
}