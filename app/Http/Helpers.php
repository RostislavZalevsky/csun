<?php

if (! function_exists('isNullOrEmpty')) {
    function isNullOrEmpty($input) {
        return (!isset($input) || trim($input) === '');
    }
}

if (! function_exists('convertTimeTo12Hours')) {
    function convertTimeTo12Hours($time) {
        $time = str_replace('h', '', $time);

        return date('g:i A', strtotime($time));
    }
}
