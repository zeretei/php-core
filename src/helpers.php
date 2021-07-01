<?php

/**
 *  application helper
 */
if (!function_exists('app')) {
    function app(string $key = null)
    {
        $app =  \Zeretei\PHPCore\Application::getInstance();

        if (is_null($key)) {
            return $app;
        }

        return $app->get($key);
    }
}

/**
 *  View
 */
if (!function_exists('view')) {
    function view(string $path, $params = [])
    {
        // convert user.settings to user/settings
        $realSubPath = str_replace('.', '/', e($path));
        // trim excess forward slash
        $realPath = '/' . trim($realSubPath, '/');

        $path = app('path.views') . "/{$realPath}.view.php";
        $exists = file_exists($path);

        if (!$exists) {
            throw new \Exception(sprintf(
                'File: "%s" does not exists on Views folder.',
                $path,
            ));
        }

        extract($params);
        return require $path;
    }
}

if (!function_exists('includes')) {
    function includes($path)
    {
        $path = app('path.views') . "/includes/{$path}.view.php";
        return require_once $path;
    }
}

/**
 *  Request instance
 */
if (!function_exists('request')) {
    function request(string $key = null)
    {
        if (is_null($key)) {
            return app('request');
        }

        return app('request')->$key;
    }
}

/**
 *  Redirect
 */
if (!function_exists('redirect')) {
    function redirect(string $path = null, int $status = 302)
    {
        if (is_null($path)) {
            return app('router');
        }

        if (headers_sent() === false) {
            // convert user.settings to user/settings
            $realSubPath = str_replace('.', '/', e($path));
            // trim excess forward slash
            $realPath = '/' . trim($realSubPath, '/');
            // redirect
            header("location:{$realPath}", true, $status);
            exit;
        }

        return false;
    }
}

/**
 *  encode
 */
if (!function_exists('e')) {
    function e(string $str)
    {
        return htmlspecialchars($str, ENT_QUOTES);
    }
}

/**
 *  Die and Dump
 */
if (!function_exists('dd')) {
    function dd(...$data)
    {
        die(var_dump(...$data));
    }
}

/**
 *  Die, Dump and debug - better format
 */
if (!function_exists('ddd')) {
    function ddd(...$data)
    {
        echo "<pre>";
        var_dump(...$data);
        echo "</pre>";
        exit;
    }
}
