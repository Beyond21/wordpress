<?php

function getbrowser()
{
    static $agent = null;

    if ( empty($agent) ) {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        if ( stripos($agent, 'Firefox') !== false ) {
            $agent = 'firefox';
        } elseif ( stripos($agent, 'MSIE') !== false ) {
            $agent = 'ie';
        } elseif ( stripos($agent, 'iPad') !== false ) {
            $agent = 'ipad';
        } elseif ( stripos($agent, 'Android') !== false ) {
            $agent = 'android';
        } elseif ( stripos($agent, 'Chrome') !== false ) {
            $agent = 'chrome';
        } elseif ( stripos($agent, 'Safari') !== false ) {
            $agent = 'safari';
        } elseif ( stripos($agent, 'AIR') !== false ) {
            $agent = 'air';
        } elseif ( stripos($agent, 'Fluid') !== false ) {
            $agent = 'fluid';
        }

    }

    return $agent;
}
// var_dump(getbrowser());

?>