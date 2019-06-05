<?php

namespace App\Helper;


use App\Constant\UserConstant;
use Framework\Session;

class UserHelper
{

    public static function getUserId()
    {
        return Session::get(UserConstant::USER_ID_SESSION_KEY);
    }

    public static function isUserLoggedIn()
    {
        return Session::get(UserConstant::IS_USER_LOGGED_IN_SESSION_KEY);
    }


}