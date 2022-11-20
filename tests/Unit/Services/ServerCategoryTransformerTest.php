<?php

namespace App\Tests\Unit\Services;

use App\Services\ServerCategoryTransformer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServerCategoryTransformerTest extends KernelTestCase
{
    public function testAddStorageInfo(): void
    {
        $data = [
            [
              "Model" => "HP DL180G62x Intel Xeon E5620",
              "RAM" => "32GBDDR3",
              "HDD" => "8x2TBSATA2",
              "Location" => "AmsterdamAMS-01",
              "Price" => "€119.00",
            ], [
              "Model" => "HP DL380eG82x Intel Xeon E5-2420",
              "RAM" => "32GBDDR3",
              "HDD" => "8x2TBSATA2",
              "Location" => "AmsterdamAMS-01",
              "Price" => "€131.99",
            ],
        ];

        $expected = [
            [
                "Model" => "HP DL180G62x Intel Xeon E5620",
                "RAM" => "32GBDDR3",
                "HDD" => "8x2TBSATA2",
                "Location" => "AmsterdamAMS-01",
                "Price" => "€119.00",
                "Storage" => "2TB",
            ], [
                "Model" => "HP DL380eG82x Intel Xeon E5-2420",
                "RAM" => "32GBDDR3",
                "HDD" => "8x2TBSATA2",
                "Location" => "AmsterdamAMS-01",
                "Price" => "€131.99",
                "Storage" => "2TB",
            ],
        ];

        self::bootKernel();

        $sct = new ServerCategoryTransformer;
        $actual = $sct->addStorageInfo($data);

        $this->assertEqualsCanonicalizing($expected, $actual);
    }


    public function testAddRamSizeInfo(): void
    {
        $data = [
            [
              "Model" => "HP DL180G62x Intel Xeon E5620",
              "RAM" => "2GBDDR3",
              "HDD" => "8x2TBSATA2",
              "Location" => "AmsterdamAMS-01",
              "Price" => "€119.00",
            ], [
              "Model" => "HP DL380eG82x Intel Xeon E5-2420",
              "RAM" => "32GBDDR3",
              "HDD" => "8x2TBSATA2",
              "Location" => "AmsterdamAMS-01",
              "Price" => "€131.99",
            ],
        ];

        $expected = [
            [
                "Model" => "HP DL180G62x Intel Xeon E5620",
                "RAM" => "2GBDDR3",
                "HDD" => "8x2TBSATA2",
                "Location" => "AmsterdamAMS-01",
                "Price" => "€119.00",
                "RamSize" => "2GB",
            ], [
                "Model" => "HP DL380eG82x Intel Xeon E5-2420",
                "RAM" => "32GBDDR3",
                "HDD" => "8x2TBSATA2",
                "Location" => "AmsterdamAMS-01",
                "Price" => "€131.99",
                "RamSize" => "32GB",
            ],
        ];

        self::bootKernel();

        $sct = new ServerCategoryTransformer;
        $actual = $sct->addRamSizeInfo($data);

        $this->assertEqualsCanonicalizing($expected, $actual);
    }
}
