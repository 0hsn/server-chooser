<?php

namespace App\Tests\Unit\Services;

use App\DTO\SearchFilter;
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

        $serv = new SearchService(getcwd());
        $data = $serv->loadBinData();

        $this->assertIsArray($data);
    }

    public function testSearchPassWhenOnlyRamSize(): void
    {
        self::bootKernel();

        $serv = new SearchService(getcwd());

        $filter = new SearchFilter;
        $filter->setRamSize('32GB');

        $data = $serv->search($filter);

        if (! empty($data)) {
            $this->assertEquals('32GB', $data[0]['RamSize']);
        } else {
            $this->markTestSkipped();
        }
    }

    public function testSearchPassWhenOnlyHDDType(): void
    {
        self::bootKernel();

        $serv = new SearchService(getcwd());

        $filter = new SearchFilter;
        $filter->setHDDType('SATA');

        $data = $serv->search($filter);

        if (! empty($data)) {
            $this->assertEquals('SATA', $data[0]['HddType']);
        } else {
            $this->markTestSkipped();
        }
    }

    public function testSearchPassWhenOnlyStorage(): void
    {
        self::bootKernel();

        $serv = new SearchService(getcwd());

        $filter = new SearchFilter;
        $filter->setStorage('500GB');

        $data = $serv->search($filter);

        if (! empty($data)) {
            $this->assertEquals('500GB', $data[0]['Storage']);
        } else {
            $this->markTestSkipped();
        }
    }

    public function testSearchPassWhenMultiFilter(): void
    {
        self::bootKernel();

        $serv = new SearchService(getcwd());

        $filter = new SearchFilter;
        $filter->setStorage('500GB');
        $filter->setHDDType('SATA');

        $data = $serv->search($filter);

        if (! empty($data)) {
            $this->assertEquals('500GB', $data[0]['Storage']);
        } else {
            $this->markTestSkipped();
        }
    }

    public function testSearchPassWhenNoFilter(): void
    {
        self::bootKernel();

        $serv = new SearchService(getcwd());
        $filter = new SearchFilter;

        $data = $serv->search($filter);
        $this->assertIsArray($data);
    }
}
