<?php

namespace App\Services;

use Doctrine\Common\Collections\ArrayCollection;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ExcelLoader
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Read an Excel file and return an array of values;
     *
     * @param string $filePath
     * @return array
     * @throws Exception
     */
    public function getArrFromExl(string $filePath): array
    {
        // Check if file
        if (is_file($filePath)) {
            $reader = new Xlsx();
            $reader->setReadDataOnly(true);

            // load the file and return data
            $worksheet = $reader->load($filePath);
            $data = $worksheet->getActiveSheet()->toArray();

            // remove anything after 5th column
            $arrColl = new ArrayCollection($data);

            $arrColl = $arrColl->map(function ($item) {
                return array_slice($item, 0, 5);
            });

            $title = $arrColl->first();

            $t_arr = $arrColl->slice(1);
            array_shift($t_arr);

            $arrColl = new ArrayCollection($t_arr);

            // combine title with values
            $arrColl = $arrColl->map(function ($item) use ($title) {
                $temp = [];

                foreach ($title as $index => $key) {
                    $temp[$key] = $item[$index];
                }

                return $temp;
            });

            return $arrColl->toArray();
        }

        return [];
    }
}