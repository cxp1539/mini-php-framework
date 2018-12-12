<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: 图像处理类
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace classes;

class Image {

	protected $path;   //图片所在的路径

	/**
	 * 创建图像对象时传递图像的一个路径，默认值是框架的文件上传目录
	 * @param	string	$path	可以指定处理图片的路径
	 */
	function __construct($path=""){
		if($path==""){
			$path=APP_ROOT."statics/uploads";
		}
		$this->path=$path;
	}
	/**
	 * 对指定的图像进行缩放
	 * @param	string	$name	是需要处理的图片名称
	 * @param	int	$width	缩放后的宽度
	 * @param	int	$height	缩放后的高度
	 * @param	string	$qz	是新图片的前缀
	 * @return	mixed		是缩放后的图片名称,失败返回false;
	 */
	function thumb($name, $width, $height,$qz="th_"){
		$imgInfo=$this->getInfo($name);                                 //获取图片信息
		$srcImg=$this->getImg($name, $imgInfo);                          //获取图片资源         
		$size=$this->getNewSize($name,$width, $height,$imgInfo);       //获取新图片尺寸
		$newImg=$this->kidOfImage($srcImg, $size,$imgInfo);   //获取新的图片资源
		return $this->createNewImage($newImg, $qz.$name,$imgInfo);    //返回新生成的缩略图的名称，以"th_"为前缀
	}
	/** 
	* 为图片添加水印
	* @param	string	$groundName	背景图片，即需要加水印的图片，暂只支持GIF,JPG,PNG格式； 
	* @param	string	$waterName	图片水印，即作为水印的图片，暂只支持GIF,JPG,PNG格式; 
	* @param	int	$waterPos	水印位置，有10种状态，0为随机位置； 
	* 					1为顶端居左，2为顶端居中，3为顶端居右； 
	* 					4为中部居左，5为中部居中，6为中部居右； 
	*					7为底端居左，8为底端居中，9为底端居右； 
	* @param	string	$qz		加水印后的图片的文件名在原文件名前面加上这个前缀，。
	* @return	mixed			是生成水印后的图片名称,失败返回false;
	*/ 
	function waterMark($groundName, $waterName, $waterPos=0, $qz="wa_"){
		$this->path=rtrim($this->path,"/")."/";
		if(file_exists($this->path.$groundName) && file_exists($this->path.$waterName)){
			$groundInfo=$this->getInfo($groundName);               //获取背景信息
			$waterInfo=$this->getInfo($waterName);                 //获取水印图片信息

			if(!$pos=$this->position($groundInfo, $waterInfo, $waterPos)){
				Debug::addmsg("<font color='red'>水印不应该比背景图片小！</font>");
				return false;
			}

			$groundImg=$this->getImg($groundName, $groundInfo);    //获取背景图像资源
			$waterImg=$this->getImg($waterName, $waterInfo);       //获取水印图片资源	

			$groundImg=$this->copyImage($groundImg, $waterImg, $pos, $waterInfo);  //拷贝图像

			return $this->createNewImage($groundImg, $qz.$groundName, $groundInfo);
			
		}else{
			Debug::addmsg("<font color='red'>图片或水印图片不存在！</font>");
			return false;
		}
	}

	private function position($groundInfo, $waterInfo, $waterPos){
		//需要加水印的图片的长度或宽度比水印还小，无法生成水印！
		if( ($groundInfo["width"]<$waterInfo["width"]) || ($groundInfo["height"]<$waterInfo["height"]) ) { 
			return false; 
		} 
		switch($waterPos) { 
			case 1://1为顶端居左 
				$posX = 0; 
				$posY = 0; 
				break; 
			case 2://2为顶端居中 
				$posX = ($groundInfo["width"] - $waterInfo["width"]) / 2; 
				$posY = 0; 
				break; 
			case 3://3为顶端居右 
				$posX = $groundInfo["width"] - $waterInfo["width"]; 
				$posY = 0; 
				break; 
			case 4://4为中部居左 
				$posX = 0; 
				$posY = ($groundInfo["height"] - $waterInfo["height"]) / 2; 
				break; 
			case 5://5为中部居中 
				$posX = ($groundInfo["width"] - $waterInfo["width"]) / 2; 
				$posY = ($groundInfo["height"] - $waterInfo["height"]) / 2; 
				break; 
			case 6://6为中部居右 
				$posX = $groundInfo["width"] - $waterInfo["width"]; 
				$posY = ($groundInfo["height"] - $waterInfo["height"]) / 2; 
				break; 
			case 7://7为底端居左 
				$posX = 0; 
				$posY = $groundInfo["height"] - $waterInfo["height"]; 
				break; 
			case 8://8为底端居中 
				$posX = ($groundInfo["width"] - $waterInfo["width"]) / 2; 
				$posY = $groundInfo["height"] - $waterInfo["height"]; 
				break; 
			case 9://9为底端居右 
				$posX = $groundInfo["width"] - $waterInfo["width"]; 
				$posY = $groundInfo["height"] - $waterInfo["height"]; 
				break; 
			case 0:
			default://随机 
				$posX = rand(0,($groundInfo["width"] - $waterInfo["width"])); 
				$posY = rand(0,($groundInfo["height"] - $waterInfo["height"])); 
				break; 
		} 

		return array("posX"=>$posX, "posY"=>$posY);
	}

	
	// 获取图片的信息
	private function getInfo($name) {
		$this->path=rtrim($this->path,"/")."/";
		$data	= getimagesize($this->path.$name);
		$imgInfo["width"]	= $data[0];
		$imgInfo["height"]    = $data[1];
		$imgInfo["type"]	= $data[2];

		return $imgInfo;		
	}

	// 创建图像资源 
	private function getImg($name, $imgInfo){
		$this->path=rtrim($this->path,"/")."/";
		$srcPic=$this->path.$name;
		
		switch ($imgInfo["type"]) {
			case 1:	//gif
				$img = imagecreatefromgif($srcPic);
				break;
			case 2:	//jpg
				$img = imagecreatefromjpeg($srcPic);
				break;
			case 3:	//png
				$img = imagecreatefrompng($srcPic);
				break;
			default:
				return false;
				break;
		}
		return $img;
	}
	
	//返回等比例缩放的图片宽度和高度，如果原图比缩放后的还小保持不变
	private function getNewSize($name, $width, $height,$imgInfo){	
		$size["width"]=$imgInfo["width"];          //将原图片的宽度给数组中的$size["width"]
		$size["height"]=$imgInfo["height"];        //将原图片的高度给数组中的$size["height"]
		
		if($width < $imgInfo["width"]){
			$size["width"]=$width;             //缩放的宽度如果比原图小才重新设置宽度
		}

		if($height < $imgInfo["height"]){
			$size["height"]=$height;            //缩放的高度如果比原图小才重新设置高度
		}

		if($imgInfo["width"]*$size["width"] > $imgInfo["height"] * $size["height"]){
			$size["height"]=round($imgInfo["height"]*$size["width"]/$imgInfo["width"]);
		}else{
			$size["width"]=round($imgInfo["width"]*$size["height"]/$imgInfo["height"]);
		}

		return $size;
	}	



	private function createNewImage($newImg, $newName, $imgInfo){
		$this->path=rtrim($this->path,"/")."/";
		switch ($imgInfo["type"]) {
	   		case 1:	//gif
				$result=imageGIF($newImg, $this->path.$newName);
				break;
			case 2:	//jpg
				$result=imageJPEG($newImg,$this->path.$newName);  
				break;
			case 3:	//png
				$result=imagePng($newImg, $this->path.$newName);  
				break;
		}
		imagedestroy($newImg);
		return $newName;
	}

	private function copyImage($groundImg, $waterImg, $pos, $waterInfo){
		imagecopy($groundImg, $waterImg, $pos["posX"], $pos["posY"], 0, 0, $waterInfo["width"],$waterInfo["height"]);
		imagedestroy($waterImg);
		return $groundImg;
	}

	private function kidOfImage($srcImg,$size, $imgInfo){
		$newImg = imagecreatetruecolor($size["width"], $size["height"]);		
		$otsc = imagecolortransparent($srcImg); //将某个颜色定义为透明色
		if( $otsc >= 0 && $otsc < imagecolorstotal($srcImg)) {  //取得一幅图像的调色板中颜色的数目
	  		 $transparentcolor = imagecolorsforindex( $srcImg, $otsc ); //取得某索引的颜色
	 		 $newtransparentcolor = imagecolorallocate(
		   		 $newImg,
		  		 $transparentcolor['red'],
		   	         $transparentcolor['green'],
		   		 $transparentcolor['blue']
	  		 );

	  		 imagefill( $newImg, 0, 0, $newtransparentcolor );
	  		 imagecolortransparent( $newImg, $newtransparentcolor );
		}
		imagecopyresized( $newImg, $srcImg, 0, 0, 0, 0, $size["width"], $size["height"], $imgInfo["width"], $imgInfo["height"] );
		imagedestroy($srcImg);
		return $newImg;
	}

}
