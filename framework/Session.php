<?php

namespace Framework;


class Session
{
    public static function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return $_SESSION[$key];
    }

    public static function has($key): bool
    {
        if (isset($_SESSION[$key]) && !empty($_SESSION[$key])) {
            return true;
        }
        return false;
    }

    public static function destroy($key)
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function flash($key, $value = "")
    {
        if (self::has($key)) {
            $session = self::get($key);
            self::destroy($key);
            return $session;
        }
        self::set($key, $value);
//        return $value;
    }

}