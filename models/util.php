<?php

class Util extends Model
{

    public static function generateRandomCode($length = 50)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public static function generateRandomCode2($length = 4)
    {
        return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public static function n_format($value)
    {

        return number_format((float)$value, 2, '.', ',');
    }

    public static function d_format($value)
    {

        return date_format(new DateTime($value), 'Y/m/d');
    }

    public static function d_format2($value)
    {

        return date_format(new DateTime($value), 'Y/m/d h:m A');
    }


    public static function date_format($value)
    {

        return date_format(new DateTime($value), 'Y-m-d');
    }


    public static function encrypt_decrypt($action, $string)
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    public static function filter_content($url)
    {
        // FIND ALL OF THE DESIRED DIV
        $htm = $url;
        $str = '<div>';
        $arr = explode($str, $htm);
        $new = $arr[0];
        $len = strlen($new);

        // ACCUMULATE THE OUTPUT STRING HERE
        $out = NULL;

        // WE ARE INSIDE ONE DIV TAG
        $cnt = 1;

        // UNTIL THE END OF STRING OR UNTIL WE ARE OUT OF ALL DIV TAGS
        while ($len) {
            // COPY A CHARACTER
            $chr = substr($new, 0, 1);

            // IF THE DIV NESTING LEVEL INCREASES OR DECREASES
            if (substr($new, 0, 4) == '<div') $cnt++;
            if (substr($new, 0, 5) == '</div') $cnt--;

            // ACTIVATE THIS TO FOLLOW THE COUNT OF NESTING LEVELS
            // echo " $cnt";

            // WHEN THE NESTING LEVEL GOES BACK TO ZERO
            if (!$cnt) break;

            // WHEN THE NESTING LEVEL IS STILL POSITIVE
            $len--;
            $out .= $chr;
            $new = substr($new, 1);
        }

        // RETURN THE WORK PRODUCT
        return $str . $out . '</div>';
    }

}
