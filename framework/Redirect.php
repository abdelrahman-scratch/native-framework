<?php

namespace Framework;

class Redirect
{
    public static function to(string $to)
    {
        header('Location: ' . $to);
        exit();
    }

    public static function back()
    {
        Redirect::to($_SERVER['HTTP_REFERER']);
    }

    public static function backWithErrors(array $errors)
    {
        Session::flash("errors", $errors);
        Redirect::back();
    }

}