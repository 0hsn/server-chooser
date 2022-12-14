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
                "StorageInTB" => "2",
            ], [
                "Model" => "HP DL380eG82x Intel Xeon E5-2420",
                "RAM" => "32GBDDR3",
                "HDD" => "8x2TBSATA2",
                "Location" => "AmsterdamAMS-01",
                "Price" => "€131.99",
                "StorageInTB" => "2",
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

    public function testAddHddTypeInfo(): void
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
              "HDD" => "2x120GBSSD",
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
              "HddType" => "SATA",
            ], [
              "Model" => "HP DL380eG82x Intel Xeon E5-2420",
              "RAM" => "32GBDDR3",
              "HDD" => "2x120GBSSD",
              "Location" => "AmsterdamAMS-01",
              "Price" => "€131.99",
              "HddType" => "SSD",
            ],
        ];

        self::bootKernel();

        $sct = new ServerCategoryTransformer;
        $actual = $sct->addHddTypeInfo($data);

        $this->assertEqualsCanonicalizing($expected, $actual);
    }

    public function testAddLocationInfo(): void
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
              "HDD" => "2x120GBSSD",
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
              "LocationID" => "AMS-01",
            ], [
              "Model" => "HP DL380eG82x Intel Xeon E5-2420",
              "RAM" => "32GBDDR3",
              "HDD" => "2x120GBSSD",
              "Location" => "AmsterdamAMS-01",
              "Price" => "€131.99",
              "LocationID" => "AMS-01",
            ],
        ];

        self::bootKernel();

        $sct = new ServerCategoryTransformer;
        $actual = $sct->addLocationInfo($data);

        $this->assertEqualsCanonicalizing($expected, $actual);
    }
}
