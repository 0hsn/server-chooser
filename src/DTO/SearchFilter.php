<?php

namespace App\DTO;

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
}