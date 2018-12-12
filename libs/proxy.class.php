<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: 代理数据库连接
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace libs;

class Proxy{

	public static function query($sql){

		if(substr($sql,0,6) == 'select'){
			return Factory::getDatabase('slave')->query($sql);
		}else{
			return Factory::getDatabase('master')->query($sql);
		}

	}

}