<?php

if (! function_exists('current_user')) {
    function current_user()
    {
        return auth()->user();
    }
}

if (! function_exists('generate_key')) {
    function generate_key()
    {
        return md5(time());
    }
}

if (! function_exists('time_s_now')) {
    function time_s_now()
    {
        $fecha = new DateTime();
        return $fecha->getTimestamp();
    }
}

if (! function_exists('uploads_folder')) {
    function uploads_folder()
    {
        return 'C:\testfile'. DIRECTORY_SEPARATOR ;
    }
}