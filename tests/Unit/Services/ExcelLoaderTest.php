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

        $container = static::getContainer();
        $logger = $container->get('logger');

        $el = new ExcelLoader($logger);
        $data = $el->getArrFromExl(
            getcwd()."/var/uploads/LeaseWeb_servers_filters_assignment.xlsx"
        );

        dump($data[0]);
        dump($data[1]);

        $this->assertIsArray($data);
    }
}
