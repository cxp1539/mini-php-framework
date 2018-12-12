<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: 核心入口文件
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */


	//定义字符集
	header("Content-Type:text/html;charset=utf-8");

	//设置时区
	date_default_timezone_set("PRC");

	//开启session
	//session_start();

	//定义主目录和静态资源目录
	define("APP_ROOT", __DIR__.'/');
	define("STATIC_ROOT",APP_ROOT.'static');

	define("DEBUG_PROFILER_CONFIG",TRUE);

	//加入autoLoader
	require APP_ROOT.'libs/autoloader.class.php';
	spl_autoload_register('libs\\AutoLoader::load');

	$logob = new classes\LogObServer();
	libs\ObException::addObserver($logob);

	//url获取要调用控制器和模块
	libs\Url::__DoUrl();

	//debug(上线需要关闭)
	if(DEBUG_PROFILER_CONFIG){
		libs\Profiler::start();
	}
	//初始化接收的控制器和方法处理action请求(反射机制)
	libs\Action::init(); 

	//debug(上线需要关闭)
	if(DEBUG_PROFILER_CONFIG){
		libs\Profiler::stop();
		libs\Debug::showMsg();
	}

	//phpinfo();
