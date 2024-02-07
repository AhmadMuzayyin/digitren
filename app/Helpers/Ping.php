<?php

class Ping
{
    public static function to()
    {
        $condition = false;
        exec('ping -c 3 google.com', $output, $result);
        if ($result == 0) {
            $condition = true;
        } else {
            $condition = false;
        }

        return $condition;
    }
}
