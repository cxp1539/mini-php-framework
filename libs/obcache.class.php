<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: obcache
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace libs;


/**
 *  使用方法
 *	ObCache::page_init();//页面缓存初始化
 *	ob_start();//开启缓存
 *	echo 1111;
 *	ObCache::page_cache(60);
 */
class ObCache{

	private static $page_file = '';

	public static function page_init(){

		$url = $_SERVER['REQUEST_URI'];//子url，该参数一般是唯一的
		$pageid = md5($url);
		$dir = str_replace('/','_',substr($_SERVER['SCRIPT_NAME'],1,-4));

		self::$page_file = APP_ROOT.'cache/'.$dir.DIRECTORY_SEPARATOR.$pageid.'.html';

		$path = dirname(self::$page_file);

		if(!file_exists($path)){
			@mkdir($path) or die("目录创建失败");
		}

		if(file_exists(self::$page_file)){
			$contents = file_get_contents(self::$page_file);//读出
			if( $contents && substr($contents, 13, 10) > time() ){
				echo substr($contents, 27);
				exit(0);
			}
		}
		return true;
	}


	public static function page_cache($ttl = 0){
		$contents = ob_get_contents();//从缓存中获取内容
		$contents = "<!--page_ttl:".(time() + $ttl)."-->\n".$contents;
		//加上自定义头部：过期时间=生成时间+缓存时间
		file_put_contents(self::$page_file, $contents);//写入缓存文件中
		ob_end_flush();//释放缓存
	} 

}

 