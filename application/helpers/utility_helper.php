<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * generate array index as key value as object
 * @param type $result_set
 * @param type $index_field
 * @return type
 */
function generate_array_for_id_object($result_set, $index_field) {
    $main_array = array();
    foreach ($result_set as $record) {
        $main_array[intval(trim($record[$index_field]))] = $record;
    }
    return $main_array;
}

function generate_array_for_id_objects($temp_data, $id) {
    $all_data = array();
    foreach ($temp_data as $temp_op) {
        if (!isset($all_data[$temp_op[$id]])) {
            $all_data[$temp_op[$id]] = array();
        }
        array_push($all_data[$temp_op[$id]], $temp_op);
    }
    return $all_data;
}

function crypto_rand_secure($min, $max) {
    $range = $max - $min;
    if ($range < 1)
        return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

/**
 * Generate Random Token.
 * @param type $length
 * @param type $is_special_character_allow
 * @return string
 */
function generate_token($length = 20, $is_special_character_allow = FALSE) {
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    if ($is_special_character_allow) {
        $codeAlphabet .= "!#$%-_+<>=";
    }
    $max = strlen($codeAlphabet); // edited

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
    }

    return $token;
}

function convert_to_mysql_date_format($dt) {
    $date_time_object = new DateTime($dt);
    return $date_time_object->format('Y-m-d');
}

function convert_to_new_date_format($dt, $separator = '') {
    $separator = $separator != '' ? $separator : '-';
    $date_time_object = new DateTime($dt);
    return $date_time_object->format("d" . $separator . "m" . $separator . "Y");
}

function convert_to_fdy_date_format($dt) {
    $date_time_object = new DateTime($dt);
    return $date_time_object->format("F d, Y");
}

function encrypt($message) {
    $iv = random_bytes(16);
    $key = getKey(ENCRYPTION_KEY);
    $result = sign(openssl_encrypt($message, 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv), $key);
    return bin2hex($iv) . bin2hex($result);
}

function decrypt($hash) {
    $iv = hex2bin(substr($hash, 0, 32));
    $data = hex2bin(substr($hash, 32));
    $key = getKey(ENCRYPTION_KEY);
    if (!verify($data, $key)) {
        return null;
    }
    return openssl_decrypt(mb_substr($data, 64, null, '8bit'), 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv);
}

function sign($message, $key) {
    return hash_hmac('sha256', $message, $key) . $message;
}

function verify($bundle, $key) {
    return hash_equals(
            hash_hmac('sha256', mb_substr($bundle, 64, null, '8bit'), $key), mb_substr($bundle, 0, 64, '8bit')
    );
}

function getKey($password, $keysize = 16) {
    return hash_pbkdf2('sha256', $password, 'some_token', 100000, $keysize, true);
}

function generate_app_no($code, $id) {
    return $code . sprintf("%05d", $id);
}

function get_financial_year() {
    $date = date_create(date('Y-m-d'));
    if (date_format($date, "m") >= 4) {
        $financial_year = (date_format($date, "Y")) . '-' . (date_format($date, "y") + 1);
    } else {
        $financial_year = (date_format($date, "Y") - 1) . '-' . date_format($date, "y");
    }
    return $financial_year;
}

function atob_decode($encrypted_string) {
    return base64_decode(base64_decode(base64_decode(base64_decode($encrypted_string))));
}

/**
     * EOF: ./application/helpers/request_helper.php
     */
    