<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: memcached
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */


namespace libs;

class Memcached extends \Memcached{

	private static $_instance;

	static public function getInstance() {
		if (!self::$_instance) {
			$obj = new self();
			$obj->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
			$obj->setOption(\Memcached::OPT_BINARY_PROTOCOL, true);
			$servers = $obj->getServerList();
			if (empty($servers)) {
				$memcache_config = new Config(APP_ROOT.'/conf');
				$obj->addServers($memcache_config['memcache']);
			}

			self::$_instance = $obj;
		}

		return self::$_instance;
	}

}