<?php

use Valet\Drivers\ValetDriver;

class LocalValetDriver extends ValetDriver
{
    public function serves(string $sitePath, string $siteName, string $uri): bool
    {
        return true;
    }

    public function isStaticFile(string $sitePath, string $siteName, string $uri)
    {
        if ($uri !== '/' && file_exists($staticFilePath = $sitePath . $uri) && !is_dir($staticFilePath)) {
            return $staticFilePath;
        }

        if ($uri !== '/' && file_exists($staticFilePath = $sitePath . '/public' . $uri) && !is_dir($staticFilePath)) {
            return $staticFilePath;
        }

        return false;
    }

    public function frontControllerPath(string $sitePath, string $siteName, string $uri): ?string
    {
        return $sitePath . '/index.php';
    }
}
