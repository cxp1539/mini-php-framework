<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: index控制器
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace controls;
use \libs\Controller;
use libs\Proxy;
use libs\Memcached;

class Index extends Controller{

	public function index(){

		ObCache::page_init();//页面缓存初始化
		ob_start();//开启缓存
		echo "111<br/>";
		ObCache::page_cache(60);

		$index_model =  new \models\Index();

		echo $index_model->index();

		//memcached使用
		// $key = 'cxp';
		// $data = Memcached::getInstance()->get($key);
		// if($data == false){
		// 	$abc = Memcached::getInstance()->set($key, 123, 300);
		// 	Memcached::getInstance()->set($key, $data, 300);
		// }
		// Memcached::getInstance()->delete($key);
		// Memcached::getInstance()->increment($key,1,1,300);
		
		//图片处理类使用
		//$image = new \classes\Image();
		//$image->thumb('cxp.jpg',30,30);
		//$image->waterMark('cxp.jpg','th_cxp.jpg',9);

		//验证码使用
		//echo new \classes\Vcode();

		//使用数据库分配模版
		// $result = Proxy::query('select * from user');
		// while ($row = $result->fetch_assoc()) {
		// 	$users[] = $row;
		// }	
		// $result->free();
		// $this->assign('users',$users);
		// $this->display();

	}

}