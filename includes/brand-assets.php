<?php
if (!function_exists('brandLogoSrc')) {
    function brandLogoSrc(string $filename): string
    {
        static $assetsRoot = null;

        if ($assetsRoot === null) {
            $assetsRoot = dirname(__DIR__) . '/assets';
        }

        $path = $assetsRoot . '/' . $filename;
        $version = is_file($path) ? (string) filemtime($path) : (string) time();

        return 'assets/' . $filename . '?v=' . $version;
    }
}
