<?php

namespace App\Command;

use App\Services\ExcelLoader;
use App\Services\ServerCategoryTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-excel',
    description: 'Load excel file, process, and save as parsed data',
)]
class LoadExcelCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'Excel file to prepare.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $file = $input->getArgument('file');

        // if an actual file passed
        if (file_exists($file) && is_file($file)) {
            $io->note(sprintf('Processing file: %s', $file));
            $excelLoader = new ExcelLoader;

            try {
                $excelData = $excelLoader->getArrFromExl($file);
            } catch (Exception $ex) {
                $io->error($ex->getMessage());
                return Command::FAILURE;
            }

            $sctService = new ServerCategoryTransformer;
            $excelData = $sctService->addStorageInfo($excelData);
            $excelData = $sctService->addHddTypeInfo($excelData);
            $excelData = $sctService->addRamSizeInfo($excelData);

            $serialized = serialize($excelData);
            unset($excelData);

            $outFile = getcwd()."/var/uploads/data.bin";

            if (file_exists($outFile)) {
                unlink($outFile); // delete file
            }

            file_put_contents($outFile, $serialized); // write file

            $io->info(sprintf('Processed file [SUCCESS]: %s', $outFile));

            return Command::SUCCESS;
        }

        // otherwise
        $io->error(sprintf('Processing file [FAILED]: %s', $file));
        return Command::FAILURE;
    }
}
