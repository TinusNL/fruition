<?php


class Router
{

    private static $urlPrefix = 'fruition';
    private static $pages;

    public static function addPages(string $source): bool
    {
        $dirs = glob($source, GLOB_ONLYDIR);

        foreach ($dirs as $dir) {
            if (file_exists($dir . '/index.php')) {
                self::$pages[str_replace('pages/', '', $dir)] = $dir . '/index.php';
            }
        }

        return true;
    }

    public static function getPageByUrl(string $url)
    {
        $url = explode('?', $url)[0];
        $url = strstr($url, '/');
        $url = trim(str_replace(Router::$urlPrefix, '', $url), '/');

        if (array_key_exists($url, Router::$pages)) {
            return include Router::$pages[$url];
        } else if ($url == '') {
            return include Router::$pages['home'];
        } else {
            return include Router::$pages['404'];
        }
    }
}
