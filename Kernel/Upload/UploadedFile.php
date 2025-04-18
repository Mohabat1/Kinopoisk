<?php

namespace App\Kernel\Upload;

use App\Kernel\Upload\UploadedFileInterface;

class UploadedFile implements UploadedFileInterface
{
public function __construct(
    public readonly string $name,
    public readonly string $type,
    public readonly string $tmp_name,
    public readonly int $size,
    public readonly string $error
){

}

    public function move(string $path, $filename = null): string|false
    {
        $storagePath = APP_PATH . "/storage/$path";

        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
        $filename = $filename ?? $this->randomFilename();

        $filePath = "$storagePath/$filename";

        if (move_uploaded_file($this->tmp_name, $filePath)) {
            return "$path/$filename";
        }
        return false;
    }
    private function randomFilename()
    {
        return md5(uniqid(rand(), true)) . '.' . $this->getExtension();
    }

    public function getExtension(): string
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }
}