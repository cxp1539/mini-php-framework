<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: 观察者log对象
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace classes;

class LogObserver implements \interf\ObServer{


	public function __construct(){

	}

	/**
	 * 观察者需要调用的方法
	 * @return [type] [description]
	 */
	public function trigger(\libs\ObException $oe){

		$message = "\r\n-----------------------------------------------------\r\n";
		$message .= "错误内容 :{$oe->getMessage()}\n";
		$message .= "错误号 :{$oe->getCode()}\n";	
		$message .= "错误文件 :{$oe->getFile()}\n";
		$message .= "错误行号 :{$oe->getLine()}\n";			
		$message .= "错误堆栈信息 :{$oe->getTraceAsString()}\r\n";
		$message .= "-----------------------------------------------------\n";

		error_log($message);

	}

}