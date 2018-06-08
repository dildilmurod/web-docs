<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a_niyazov
 * Date: 14.11.13
 * Time: 15:26
 * To change this template use File | Settings | File Templates.
 */
namespace common\helpers;
/**
 * Class DebugHelper
 * @package common\helpers
 */
class DebugHelper
{
    /**
     * @param $object
     * @param bool|false $die
     */
    public static function printSingleObject($object,$die = false, $withPre = true)
    {
        if($withPre) echo '<pre>'; print_r($object); if($withPre) echo '</pre>';
        if($die) die;
    }

    /**
     * @param $object
     * @param bool|false $die
     */
    public static function varDumpSingleObject($object,$die = false, $withPre = true)
    {
        if($withPre) echo '<pre>'; var_dump($object); if($withPre) echo '</pre>';
        if($die) die;
    }

    /**
     * @param $objectsArray
     */
    public static function printObjectsArray($objectsArray, $die = false, $withPre = true)
    {
        if($withPre) echo '<pre>';
        foreach($objectsArray as $object)
        {
            print_r($object);
        }
        if($withPre) echo '</pre>';
        if($die) die;

    }


    public static function printActiveRecordsModel($object, $die = false, $withPre = true)
    {
        if($withPre) echo '<pre>'; print_r($object->getAttributes()); if($withPre) echo '</pre>';
        if($die) die;
    }

    public static function printActiveRecordsArray($objectsArray, $die = false,$withPre = true)
    {
        if($withPre) echo '<pre>';
        foreach($objectsArray as $object)
        {
            print_r($object->getAttributes());
        }
        if($withPre) echo '</pre>';
        if($die) die;
    }


    public static function printToSandBox($text, $die = false)
    {
        if(strpos($_SERVER['HTTP_HOST'], 'dev'))
        {
            echo $text;
        }
        else
        {
            echo '';
        }
        if($die) die;
    }

    public static function  getUserIp(){
        if ( getenv('REMOTE_ADDR') ) $user_ip = getenv('REMOTE_ADDR');
        elseif ( getenv('HTTP_FORWARDED_FOR') ) $user_ip = getenv('HTTP_FORWARDED_FOR');
        elseif ( getenv('HTTP_X_FORWARDED_FOR') ) $user_ip = getenv('HTTP_X_FORWARDED_FOR');
        elseif ( getenv('HTTP_X_COMING_FROM') ) $user_ip = getenv('HTTP_X_COMING_FROM');
        elseif ( getenv('HTTP_VIA') ) $user_ip = getenv('HTTP_VIA');
        elseif ( getenv('HTTP_XROXY_CONNECTION') ) $user_ip = getenv('HTTP_XROXY_CONNECTION');
        elseif ( getenv('HTTP_CLIENT_IP') ) $user_ip = getenv('HTTP_CLIENT_IP');
        $user_ip = trim($user_ip);
        if ( empty($user_ip) ) return false;
        if ( !preg_match("/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/", $user_ip) ) return false;
        return $user_ip;
    }
}