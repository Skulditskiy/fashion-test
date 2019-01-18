<?php

namespace Skulditskiy\FashionTest\Infrastructure\Persistence\Csv;

class FileReader
{
    public function readFromData(string $filePath)
    {
        $productsRawData = [];
        $fileHandler = fopen($filePath, 'r');
        if ($fileHandler === false) {
            throw new \Exception('Unable to open file');
        }

        while ($singleRowData = fgetcsv($fileHandler, 0, ',')) {
            $productsRawData[] = $singleRowData;
        }
        fclose($fileHandler);

        return $productsRawData;
    }
}
