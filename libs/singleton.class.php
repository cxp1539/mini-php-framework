<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: 单例模式特性
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace libs;

trait Singleton {

    protected static $_instance;

    final public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new static();
        }

        return self::$_instance;
    }

}