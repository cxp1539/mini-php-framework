<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: url获取要调用控制器和模块
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace libs;

class Url{

	/**
	 * 获取control,method和参数
	 * @return [type] [description]
	 */
	public static function __DoUrl(){

		if(isset($_SERVER['PATH_INFO'])){

			$pathinfo = explode('/',trim($_SERVER['PATH_INFO'],"/"));
			$_GET['control'] = empty($pathinfo[0]) ? 'index' : $pathinfo[0];
			$_GET['method'] = empty($pathinfo[1]) ? 'index' : $pathinfo[1];
			array_shift($pathinfo);
			array_shift($pathinfo);

			//获取参数数组
			for ($i=0; $i < count($pathinfo); $i+=2) { 
				$_GET['params'][$pathinfo[$i]] = $pathinfo[$i+1];
			}

		}else{
			$_GET['control'] = 'index';
			$_GET['method'] = 'index';
			$_GET['params'] = array();
		}

	}

}