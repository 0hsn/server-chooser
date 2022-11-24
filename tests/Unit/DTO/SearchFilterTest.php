<?php

namespace App\Tests\Unit\DTO;

use App\DTO\SearchFilter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class SearchFilterTest extends KernelTestCase
{
    /**
     * @throws \Exception
     */
    public function testSetStorageFails(): void
    {
        self::bootKernel();

        $filter = new SearchFilter;
        $filter->setStorage("Random");

        $this->assertEquals('', $filter->storage);
    }

    public function testSetStoragePasses(): void
    {
        self::bootKernel();

        $filter = new SearchFilter;
        $filter->setStorage("500GB");

        $this->assertEquals('500GB', $filter->storage);
    }

    public function testSetRamSizeFails(): void
    {
        self::bootKernel();

        $filter = new SearchFilter;
        $filter->setRamSize("Random");

        $this->assertEquals([], $filter->ramSize);
    }

    public function testSetRamSizePasses(): void
    {
        self::bootKernel();

        $filter = new SearchFilter;
        $filter->setRamSize("32GB");

        $this->assertEquals(['32GB'], $filter->ramSize);
    }

    public function testSetHDDTypeFails(): void
    {
        self::bootKernel();

        $filter = new SearchFilter;
        $filter->setHDDType("Random");

        $this->assertEquals('', $filter->hddType);
    }

    public function testSetHDDTypePasses(): void
    {
        self::bootKernel();

        $filter = new SearchFilter;
        $filter->setHDDType("SATA");

        $this->assertEquals('SATA', $filter->hddType);
    }

    public function testSetLocationFails(): void
    {
        self::bootKernel();

        $filter = new SearchFilter;
        $filter->setLocation("Random");

        $this->assertEquals('', $filter->location);
    }

    public function testSetLocationPasses(): void
    {
        self::bootKernel();

        $filter = new SearchFilter;
        $filter->setLocation('SFO-12');

        $this->assertEquals('SFO-12', $filter->location);
    }
}
