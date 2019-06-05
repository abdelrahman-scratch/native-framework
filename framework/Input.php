<?php

namespace Framework;


class Input
{

    public static function getAll(): array
    {
//        if (isset($_GET)) {
//            return $_GET;
//        }
        //@todo loop and use escape method
//        return $_POST;
    }


    public static function get(string $param): string
    {
        $result = '';
        if (isset($_POST[$param])) {
            $result = $_POST[$param];
        } else if (isset($_GET[$param])) {
            $result = $_GET[$param];
        }

        return self::escape($result);
    }

    /**
     * Convert all applicable characters to HTML entities
     *
     * @param string $string
     * @return string
     */
    public static function escape(string $string): string
    {
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }

}