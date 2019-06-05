<?php


namespace App\Controller\Auth;

use App\Constant\UserConstant;
use Framework\Redirect;
use Framework\Session;

class LogoutController
{
    /**
     * Make user logout the system
     */
    public function logout()
    {
        Session::set(UserConstant::IS_USER_LOGGED_IN_SESSION_KEY, false);
        Redirect::to("/");
    }

}