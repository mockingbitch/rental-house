<?php

if (! function_exists('convertStringToDate')) :
    function convertStringToDate($y = '', $m = '', $d = '')
    {
        $time = strtotime($m . '/' . $d . '/' . $y);
        $newFormat = date('Y-m-d', $time);

        return $newFormat;
    }
endif;

if (! function_exists('formatDateYm')) {
    function formatDateYm($y = '', $m = '')
    {
        $time = strtotime($y . '/' . $m . '/' . '01');
        $newFormat = date('Y-d-m', $time);

        return $newFormat;
    }
}