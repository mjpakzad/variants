<?php
if(!function_exists('config')) {
    /**
     * Returns array inside the file if file exists, otherwise return empty array.
     *
     * @param $file
     *
     * @return array
     */
    function config($file): array
    {
        $path = __DIR__ . '\..\configs\\' . $file . '.php';
        return file_exists($path) ? require $path : [];
    }
}