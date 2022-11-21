<?php

namespace App\Services;

use Symfony\Component\Translation\Exception\NotFoundResourceException;

class SearchService
{
    /**
     * Load binary data file that stores processed data
     *
     * @return array
     */
    public function loadBinData() : array
    {
        $inFile = getcwd()."/var/uploads/data.bin";

        if (file_exists($inFile) && is_file($inFile)) {
            $serialized = file_get_contents($inFile);
            return unserialize($serialized);
        }

        throw new NotFoundResourceException("Data backend not found. Please run app:load-excel to generate.");
    }
}