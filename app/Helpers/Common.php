<?php
    if (!function_exists('preview')) {
        function preview($data)
        {
            echo "<pre>";
            print_r ($data);
            exit;
        }
    }

    if (!function_exists('generate_otp')) {
        function generate_otp()
        {
            $otp = 1234;
            return $otp;
        }
    }