<?php


namespace classes;


class initialization
{
    private static $init;
    protected static $info;

    private function __construct()
    {
        // TODO: Implement __clone() method.
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    private function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

    public static function getInit($arrToDump)
    {
        if(self::$init===null){
            self::$init=new self();
        }

        return self::$init;
    }

    public static function parseArr($value){
        return self::$info= $value;
    }


}