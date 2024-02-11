<?php

function getSumFromFiles(string $dir, $fileName): float
{
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    $sum = 0;
    foreach ($files as $file) {

        if ($file->isFile()
            && preg_match('/^' . preg_quote($fileName, '/') . '\..+$/', $file->getFilename())) {
            $content = file_get_contents($file->getRealPath());

            if (is_string($content)) {
                $sum += countSumInCurrentFile($content);
            }
        }
    }

    return $sum;
}

function countSumInCurrentFile(string $content): int
{
    preg_match_all('/\d+/', $content, $numbers);

    return array_sum(array_map('intval', $numbers[0]));
}


$directoryPath = __DIR__;
$fileName = "count";

echo "Sum of numbers in count files: " . getSumFromFiles($directoryPath, $fileName);
