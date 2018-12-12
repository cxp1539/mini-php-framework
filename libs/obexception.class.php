<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: 自定义异常类
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace libs;

class ObException extends \Exception{


	private static $observer = array();

	/**
	 * 重写Exception构造方法
	 * @param [type]  $message [description]
	 * @param integer $code    [description]
	 */
	public function __construct($message = null,$code = 0){
		parent::__construct($message,$code);
		$this->notify($this);
	}


	/**
	 * addObServer
	 * @param addObServer $ob [description]
	 */
	public static function addObServer(\interf\ObServer $ob){
		if(is_object($ob)){
			self::$observer[] = $ob;
		}else{
			throw new Exception("no object", 0);
		}
	}


	/**
	 * 通知每个观察者对象
	 * @return [type] [description]
	 */
	public function notify($ob){

		foreach (self::$observer as $ob) {
			$ob->trigger($this);	
		}

	}

}