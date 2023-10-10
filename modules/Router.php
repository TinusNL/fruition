<?php
class Router
{
    private static array $pages = [];
    public static string $url = '';

    public static function loadPages(string $pagesDir): void
    {
        $dirs = Router::recursiveGrub($pagesDir);

        foreach ($dirs as $dir) {
            if (file_exists($dir . '/index.php')) {
                self::$pages[str_replace('pages/', '', $dir)] = $dir . '/index.php';
            }
        }
    }

    public static function loadUrl(string $url): void
    {
        $url = explode('?', $url)[0];
        $url = strstr($url, '/');
        $url = str_replace(URL_PREFIX, '', $url);
        $url = ltrim($url, '/');

        Router::$url = $url;
    }

    public static function getOffset(): string
    {
        $url = explode('/', Router::$url);

        return str_repeat('../', count($url) - 1);
    }

    public static function getContent()
    {
        $url = trim(Router::$url, '/');

        if (array_key_exists($url, Router::$pages)) {
            return include Router::$pages[$url];
        } else if ($url == '') {
            // return include Router::$pages['home'];
            return include Router::$pages['map'];
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
