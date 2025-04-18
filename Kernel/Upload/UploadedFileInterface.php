<?php

namespace App\Kernel\Upload;

interface UploadedFileInterface
{
    public function move(string $path, $filename= null): string|false;

    public function getExtension(): string;

}