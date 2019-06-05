<?php

namespace Framework;


class CSRFToken
{
    public static function generate()
    {
        return Session::set(Constant::CSRF_TOKEN, md5(uniqid()));
    }

    public static function check(string $token): bool
    {

        if (Session::has(Constant::CSRF_TOKEN) && $token === Session::get(Constant::CSRF_TOKEN)) {
            Session::destroy(Constant::CSRF_TOKEN);

            return true;
        }

        return false;
    }

}