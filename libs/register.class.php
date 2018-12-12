<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: 注册器模式
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */


namespace libs;


class Register{

	protected static $objects;

	public static function _set($alias,$objects){
		self::$objects[$alias] = $objects;
	}

	public static function _get($alias){
		return self::$objects[$alias];
	}

	public static function _unset($alias){
		unset(self::$objects[$alias]);
	}

}