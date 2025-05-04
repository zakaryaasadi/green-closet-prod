<?php

namespace App\Traits;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileManagement
{
    /**
     * @throws \Exception
     */
    protected function createFile($content, $fileName = null, $baseDir = '', $storage = null, $orderId = null, $overwrite = false)
    {
        $storage = $storage ?? Storage::disk();
        if (is_null($fileName))
            $fileName = $this->generateFileName($content, $orderId);

        if (is_file($content))
            $content = $content->getContent();

        $isFileExits = $storage->exists($fileName);
        $fullPath = $baseDir . $fileName;

        if ($isFileExits && !$overwrite) {
            throw new \Exception("File $fullPath is already exists");
        }
        $storage->put($baseDir . $fileName, $content);

        return $fileName;
    }

    protected function createOrderFile($content, $fileName = null, $storage = null, $orderId = null, $overwrite = false): string
    {
        $storage = $storage ?? Storage::disk('orders');
        $dateFolder = date('Y-m-d');

        $baseDir = 'images/' . $dateFolder . '/';

        if (is_null($fileName)) {
            $fileName = $this->generateFileName($content, $orderId);
        }

        if (is_file($content)) {
            $content = $content->getContent();
        }

        $fullPath = $baseDir . $fileName;
        $isFileExists = $storage->exists($fullPath);

        if ($isFileExists && !$overwrite) {
            throw new \Exception("File $fullPath already exists");
        }

        if (!$storage->exists($baseDir)) {
            $storage->makeDirectory($baseDir, 0775, true);
        }

        $storage->put($fullPath, $content);

        return $fullPath;
    }

    /**
     * @throws \Exception
     */
    protected function generateFileName($data, $orderId = null): string
    {
        if (empty($data) || !is_file($data))
            throw new \Exception('cannot get name because the file is empty');

        $extension = $data->guessExtension();
        $clientOriginalName = pathinfo($data->getClientOriginalName(), PATHINFO_FILENAME);
        $random = Str::random('10');
        if ($orderId)
            return $clientOriginalName . '_' . date('YmdHisv') . $random . $orderId . '.' . $extension;
        else
            return $clientOriginalName . '_' . date('YmdHisv') . $random . '.' . $extension;
    }
}
