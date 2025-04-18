<?php

namespace App\Kernel\Config;

use App\Kernel\Config\ConfigInterface;

class Config implements ConfigInterface
{
    public function get(string $key, $default = null): mixed
    {
        $parts = explode('.', $key);

        if (count($parts) !== 2) {

            return $default;
        }

        [$file, $key] = $parts;

        $configPath = APP_PATH . "config/$file.php";

        if (!file_exists($configPath)) {
            return $default;
        }

        $config = require $configPath;


        return $config[$key] ?? $default;
    }
}
