<?php

//view_helpers.php


if (!function_exists('checked')) {
    function checked($a, $b = null)
    {
        $test = ((func_num_args() == 1) ? (!!$a) : ($a == $b));
        echo ( $test ? ' checked="checked" ' : '' );
    }
}


if (!function_exists('selected')) {
    function selected($a, $b = null)
    {
        $test = ((func_num_args() == 1) ? (!!$a) : ($a == $b));
        echo ( $test ? ' selected="selected"' : '' );
    }
}
