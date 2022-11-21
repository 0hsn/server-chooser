<?php

namespace App\Services;


use App\DTO\SearchFilter;

class ServerCategoryTransformer
{
    /**
     * Add storage category to data
     *
     * @param array $dataIn
     * @return array
     */
    public function addStorageInfo(array $dataIn): array
    {
        $data = $dataIn;

        foreach ($data as &$serverInf) {
            if (str_contains($serverInf['HDD'], 'x250GB')) {
                $serverInf['Storage'] = '250GB';
            } else if (str_contains($serverInf['HDD'], 'x500GB')) {
                $serverInf['Storage'] = '500GB';
            } else if (str_contains($serverInf['HDD'], 'x1TB')) {
                $serverInf['Storage'] = '1TB';
            } else if (str_contains($serverInf['HDD'], 'x2TB')) {
                $serverInf['Storage'] = '2TB';
            } else if (str_contains($serverInf['HDD'], 'x3TB')) {
                $serverInf['Storage'] = '3TB';
            } else if (str_contains($serverInf['HDD'], 'x4TB')) {
                $serverInf['Storage'] = '4TB';
            } else if (str_contains($serverInf['HDD'], 'x8TB')) {
                $serverInf['Storage'] = '8TB';
            } else if (str_contains($serverInf['HDD'], 'x12TB')) {
                $serverInf['Storage'] = '12TB';
            } else if (str_contains($serverInf['HDD'], 'x24TB')) {
                $serverInf['Storage'] = '24TB';
            } else if (str_contains($serverInf['HDD'], 'x48TB')) {
                $serverInf['Storage'] = '48TB';
            } else if (str_contains($serverInf['HDD'], 'x72TB')) {
                $serverInf['Storage'] = '72TB';
            } else {
                $serverInf['Storage'] = '';
            }
        }

        return $data;
    }

    /**
     * Add ram size category to data
     *
     * @param array $dataIn
     * @return array
     */
    public function addRamSizeInfo(array $dataIn): array
    {
        $data = $dataIn;

        foreach ($data as &$serverInf) {
            $ram = $serverInf['RAM'];
            $serverInf['RamSize'] = substr($ram, 0, strpos($ram, 'DDR'));

            if (!in_array($serverInf['RamSize'], SearchFilter::RAM_SIZE)) {
                $serverInf['RamSize'] = '';
            }
        }

        return $data;
    }

    /**
     * Add hdd type to data
     *
     * @param array $dataIn
     * @return array
     */
    public function addHddTypeInfo(array $dataIn): array
    {
        $data = $dataIn;

        foreach ($data as &$serverInf) {
            if (str_contains($serverInf['HDD'], 'SAS')) {
                $serverInf['HddType'] = 'SAS';
            } else if (str_contains($serverInf['HDD'], 'SATA')) {
                $serverInf['HddType'] = 'SATA';
            } else if (str_contains($serverInf['HDD'], 'SSD')) {
                $serverInf['HddType'] = 'SSD';
            } else {
                $serverInf['HddType'] = '';
            }
        }

        return $data;
    }
}