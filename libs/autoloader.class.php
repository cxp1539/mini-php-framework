<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: autoLoader
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace libs;

class AutoLoader{

	public static function load($class){

		include APP_ROOT.strtolower(str_replace('\\','/',$class)).".class.php";

	}

}

