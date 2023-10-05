<?php


class Router
{

    private static $pages;

    public static function addPages(string $pagesDir): bool
    {
        $dirs = Router::recursiveGrub($pagesDir);

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
        $url = trim(str_replace(URL_PREFIX, '', $url), '/');

        if (array_key_exists($url, Router::$pages)) {
            return include Router::$pages[$url];
        } else if ($url == '') {
            return include Router::$pages['home'];
        } else {
            return include Router::$pages['404'];
        }
    }

    private static function recursiveGrub(string $path): array
    {
        $dirs = glob($path . '/*', GLOB_ONLYDIR);

        foreach ($dirs as $dir) {
            $dirs = array_merge($dirs, self::recursiveGrub($dir));
        }

        return $dirs;
    }
}
