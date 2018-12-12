<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: 性能分析
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace libs;

class Profiler{

	private static $startTime = 0;
	private static $stopTime = 0;
	private static $startMemory = 0;
	private static $stopMemory = 0;


	public static function start(){                       
		self::$startTime = microtime(true);
		self::$startMemory = memory_get_usage();
	}


	public static function stop(){
		self::$stopTime= microtime(true);
		self::$stopMemory = memory_get_usage();
		Debug::addMsg("脚本一共执行".round((self::$stopTime - self::$startTime) , 4)."秒");
		Debug::addMsg("共使用".globalF::toSize(self::$stopMemory-self::$startMemory));

	}

}