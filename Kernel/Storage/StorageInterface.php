<?php

namespace App\Kernel\Storage;

interface StorageInterface
{
    public function url($path): string;
    public function get(string $path): string;

}