<?php

namespace App\Constant;


class UserConstant
{
    public const IS_USER_LOGGED_IN_SESSION_KEY = "is_user_logged_in";
    public const USER_ID_SESSION_KEY = "user_id";
    public const USER_ROLE_NAME_SESSION_KEY = "user_role_name";
    public const EMAIL_ALREADY_EXISTS = "Email already exists";
    public const LOGIN_FAILED = "Invalid email or password";

    public const LOGIN_ERRORS = "login_errors";
    public const REGISTER_ERRORS = "register_errors";

    public const USER_LOGINED_SUCCESSFULLY = "You have Successfully Logged In";
    public const USER_CREATED_SUCCESSFULLY = "User created successfully";
}