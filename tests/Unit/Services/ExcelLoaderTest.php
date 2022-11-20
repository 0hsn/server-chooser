<?php

namespace App\Tests\Unit\Services;

use App\Services\ExcelLoader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class ExcelLoaderTest extends KernelTestCase
{
    /**
     * @throws \Exception
     */
    public function testSaveCsvFromExcel(): void
    {
        self::bootKernel();

        $el = new ExcelLoader;
        $data = $el->getArrFromExl(
            getcwd()."/var/uploads/LeaseWeb_servers_filters_assignment.xlsx"
        );

        $this->assertIsArray($data);
    }
}
