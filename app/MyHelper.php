<?php

use App\Models\Subject;
use Illuminate\Support\Facades\DB;

if (!function_exists('null_handle_srt')) {
    function null_handle_srt($str)
    {
        $data = '';

        if (isset($str) && $str != null) {
            $data = $str;
            //dd($data);
        } else {
            $data = '';
        }


        print_r($data);
    }
}
