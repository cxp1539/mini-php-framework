<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: Debug调试
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace libs;

class Debug{


	private static $info = array();
	private static $includefile = array();
	private static $sqls = array();	


	/**
	 * 添加debug信息
	 * @param  [type]  $msg  [description]
	 * @param  integer $type [description]
	 * @return [type]        [description]
	 */
	public static function addMsg($msg,$type=0) {
		switch($type){
			case 0:
				self::$info[]=$msg;
				break;
			case 1:
				self::$includefile[]=$msg;
				break;
			case 2:
				self::$sqls[]=$msg;
				break;
		}
	}

	/**
	 * 输出调试消息
	 * @return [type] [description]
	 */
	public static function showMsg(){
		echo '<div style="clear:both;text-align:left;color:#888;width:96%;margin:1%;padding:10px;background:#F5F5F5;border:1px dotted #778855;z-index:100">';
		echo '<ul style="margin:0px;padding:0 10px 0 10px;list-style:none">';
		if(count(self::$includefile) > 0){
			echo '［自动包含］';
			foreach(self::$includefile as $file){
				echo '<li>&nbsp;&nbsp;&nbsp;&nbsp;'.$file.'</li>';
			}		
		}
		if(count(self::$info) > 0 ){
			echo '<br>［系统信息］';
			foreach(self::$info as $info){
				echo '<li>&nbsp;&nbsp;&nbsp;&nbsp;'.$info.'</li>';
			}
		}

		if(count(self::$sqls) > 0) {
			echo '<br>［SQL语句］';
			foreach(self::$sqls as $sql){
				echo '<li>&nbsp;&nbsp;&nbsp;&nbsp;'.$sql.'</li>';
			}
		}
		echo '</ul>';
		echo '</div>';	
	}


}
