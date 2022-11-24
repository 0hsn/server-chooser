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
            $posX = strpos($serverInf['HDD'], 'x');
            $posGB = strpos($serverInf['HDD'], 'GB');
            $posTB = strpos($serverInf['HDD'], 'TB');

            if ($posGB) {
                $gb = substr($serverInf['HDD'], ($posX + 1), ($posGB - 2));
                $serverInf['StorageInTB'] = intval($gb) / 1000;
            } else if ($posTB) {
                $serverInf['StorageInTB'] = substr($serverInf['HDD'], ($posX + 1), ($posTB - 2));
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