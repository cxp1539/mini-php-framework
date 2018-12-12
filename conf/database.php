<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: mysql配置信息
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

$config = array(
    'master' => array(
        'host' => 'localhost',
		'port' => 3306,        
        'user' => 'root',
        'password' => 'temptation',
        'dbname' => 'temptation',
    ),
    'slave' => array(
        'slave1' => array(
	        'host' => 'localhost',
			'port' => 3306,        
	        'user' => 'root',
	        'password' => 'temptation',
	        'dbname' => 'temptation',
        ),
        'slave2' => array(
        	'host' => 'localhost',
			'port' => 3306,        
	        'user' => 'root',
	        'password' => 'temptation',
	        'dbname' => 'temptation',
        ),
    ),
);
return $config;



