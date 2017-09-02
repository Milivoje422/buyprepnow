<?php

class ICEPAY_Helper {

    private static $version = '2.0.1';

    public static function getVersion()
    {
        return self::$version;
    }

    public static function isIcepayPage()
    {
        return ($_GET['page'] == 'icepay-configuration');
    }

}