<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: 调用控制器和方法
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace libs;

class Action{

	public static function init(){

		$className=APP_ROOT."controls/".strtolower($_GET["control"]).".class.php";

		if(!file_exists($className)){
			header("HTTP/1.0 404 Not Found");
			return;	
		}

		$controls = ucfirst($_GET["control"]);

		$method = ucfirst($_GET["method"]);

		$con = "\controls\\$controls";

		$controler = new $con($controls,$method);

		//反射
		$reflect = new \ReflectionClass($controler);
		if (!$reflect->hasMethod($method)){
            header("HTTP/1.0 404 Not Found");
			return;
		}

		$controler->$method();

	}

}