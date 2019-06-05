<?php

namespace Framework;


class Config
{
    public static function get($path): string
    {
        $config = $GLOBALS['config'];
        $path = explode('.', $path);

        foreach ($path as $bit) {
            if (isset($config[$bit])) {
                $config = $config[$bit];
            }
        }

        return $config;
    }

}