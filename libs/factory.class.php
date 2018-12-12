<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: 工厂模式
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */


namespace libs;

class Factory{


	public static function getDatabase($type){

        $key = 'database_'.$type;
        $config = new Config(APP_ROOT.'/conf');

        if ($type == 'slave'){
            $slaves = $config['database']['slave'];
            $db_conf = $slaves[array_rand($slaves)];
        }else{
            $db_conf = $config['database'][$type];
        }

        $db = Register::_get($key);
        if (!$db) {
            $db = Mysqli::getInstance();
            $db->connect($db_conf['host'], $db_conf['user'], $db_conf['password'], $db_conf['dbname']);
            Register::_set($key, $db);
        }
        return $db;
    }


    public static function getMemcached(){

        $key = 'memcached';
        $memcached = Register::_get($key);
        if (!$memcached) {
            $memcached = Memcached::getInstance();
            $memcached->connect($db_conf['host'], $db_conf['user'], $db_conf['password'], $db_conf['dbname']);
            Register::_set($key, $db);
        }
        return $memcached;        
    }

}