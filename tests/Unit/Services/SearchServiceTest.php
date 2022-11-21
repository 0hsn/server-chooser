<?php

namespace App\Tests\Unit\Services;

use App\Services\ExcelLoader;
use App\Services\SearchService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class SearchServiceTest extends KernelTestCase
{
    /**
     * @throws \Exception
     */
    public function testLoadBinData(): void
    {
        self::bootKernel();

        $serv = new SearchService();
        $data = $serv->loadBinData();

        $this->assertIsArray($data);
    }
}
