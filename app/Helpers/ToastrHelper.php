<?php

class Toastr
{
    public static function success($message)
    {
        flash($message, 'success');
    }

    public static function info($message)
    {
        flash($message, 'info');
    }

    public static function warning($message)
    {
        flash($message, 'warning');
    }

    public static function error($message)
    {
        flash($message, 'error');
    }
}
