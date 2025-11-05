<?php
    if (!function_exists('preview')) {
        function preview($data)
        {
            echo "<pre>";
            print_r ($data);
            exit;
        }
    }

    if (!function_exists('ParamValidation')) {
        function ParamValidation($paramarray,$data)
        {
            $NovalueParam = array();
            foreach($paramarray as $val)
            {
                if(!isset($data[$val]) || $data[$val] == '')
                {
                    $NovalueParam[] = $val;
                }
            }
            $returnArr = array();
            if(is_array($NovalueParam) && count($NovalueParam)>0)
            {
                $returnArr[config('constants.RESPONSE_STATUS')] = config('constants.RESPONSE_FLAG_FAIL');
                $returnArr[config('constants.RESPONSE_MESSAGE')] = 'Sorry, You missed '.implode(',',$NovalueParam).' parameters';
            } else {
                $returnArr[config('constants.RESPONSE_STATUS')] = config('constants.RESPONSE_FLAG_SUCCESS');
            }
            return $returnArr;
        }
    }

    if (!function_exists('generate_otp')) {
        function generate_otp()
        {
            $otp = 1234;
            return $otp;
        }
    }