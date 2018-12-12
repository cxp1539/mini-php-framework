<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: 验证码函数
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace classes;

class Vcode {
	private $code;//验证码
	private $codelen = 4;//验证码长度
	private $width = 125;//宽度
	private $height = 30;//高度
	private $img;//图形资源句柄
	private $fontsize = 21;//指定字体大小
	private $fontcolor;//指定字体颜色


	//构造方法初始化
	public function __construct($width=125, $height=30, $codelen=4,$fontsize = 21) {
	 	$this->width = $width;
	 	$this->height = $height;
	 	$this->codelen = $codelen;
	 	$this->fontsize = $fontsize;
	}

	//生成随机码
	private function createCode() {
		$charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';//随机因子
		$_len = strlen($charset)-1;
		for ($i=0;$i<$this->codelen;$i++) {
			$this->code .= $charset[mt_rand(0,$_len)];
		}
	}

	//生成背景
	private function createBg() {
		$this->img = imagecreatetruecolor($this->width, $this->height);
		$color = imagecolorallocate($this->img, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
		imagefilledrectangle($this->img,0,$this->height,$this->width,0,$color);
	}

	//生成文字
	private function createFont() {
		$_x = $this->width / $this->codelen;
		for ($i=0;$i<$this->codelen;$i++) {
			$this->fontcolor = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
			imagestring ( $this->img , $this->fontsize , $_x*$i+mt_rand(1,5)+10,$this->height/5 , $this->code[$i],$this->fontcolor);
		}
	}

	//生成线条、雪花
	private function createLine() {
		//线条
		for ($i=0;$i<6;$i++) {
			$color = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
			imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
		}
		//雪花
		for ($i=0;$i<100;$i++) {
			$color = imagecolorallocate($this->img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
			imagestring($this->img,mt_rand(1,5),mt_rand(0,$this->width),mt_rand(0,$this->height),'*',$color);
		}
	}

	//输出
	private function outPut() {
		header('Content-type:image/png');
		imagepng($this->img);
	}
 
	public function __toString(){
		$_SESSION['vcode'] = strtolower($this->code);
		$this->createBg();
		$this->createCode();
		$this->createLine();
		$this->createFont();
		$this->outPut();
	}

	public function __destruct(){
		imagedestroy($this->img);
	}
}