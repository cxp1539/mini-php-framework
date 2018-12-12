<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: 
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */


namespace libs;

class globalF{

    /**
     * @desc 获取客户端真实的ip   
     **/
	static function getClientRealIp(){

	    if (getenv("HTTP_CLIENT_IP"))
	         $ip = getenv("HTTP_CLIENT_IP");
	    else if(getenv("HTTP_X_FORWARDED_FOR"))
	        $ip = getenv("HTTP_X_FORWARDED_FOR");
	    else if(getenv("REMOTE_ADDR"))
	        $ip = getenv("REMOTE_ADDR");
	    else $ip = "Unknow";
	    if($ip=='::1')
	        $ip='127.0.0.1';
	    return $ip;
	}
	/**
	 * @desc 解析ip取得国家,省市等信息   
	 **/
	static function GetIpLookup($ip){
	    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);  
	    if(empty($res)){ return false; }  
	    $jsonMatches = array();  
	    preg_match('#\{.+?\}#', $res, $jsonMatches);  
	    if(!isset($jsonMatches[0])){ return false; }  
	    $json = json_decode($jsonMatches[0], true);  
	    if(isset($json['ret']) && $json['ret'] == 1){  
	        $json['ip'] = $ip;  
	        unset($json['ret']);  
	    }else{  
	        return false;  
	    }  
	    return $json;  
	}


	/**
	 * 返回相对于当前时间的友善短时间串，比如3秒前,10分钟前
	 *
	 * @param int $time 时间戳
	 * @param int $level
	 * @return unknown
	 */
	static function str_short_time($time,$level=10){
		global $timestamp;
		$diff=$timestamp-$time;
		if($diff<0){
			$result='';
		}elseif($diff>=0 and $diff<60){//1级
			$result=$diff.'秒前';
		}elseif ($diff>=60 and $diff<1800){//2级
			$result = $level>1? intval($diff/60).'分钟前' : date('m-d H:i',$time);
		}elseif ($diff>=1800 and $diff<3600){//3级
			$result = $level>2? '半小时前' : date('m-d H:i',$time);
		}elseif ($diff>=3600 and $diff<86400){//4级
			$result = $level>3? intval($diff/3600).'小时前' : date('m-d H:i',$time);
		}elseif ($diff>=86400 and $diff<604800){//5级
			$result = $level>4? intval($diff/86400).'天前' : date('m-d H:i',$time);
		}elseif ($diff>=604800 and $diff<2592000){//6级
			$result = $level>5? intval($diff/604800).'周前' : date('m-d H:i',$time);
		}elseif ($diff>=2592000 and $diff<31536000){//7级
			$result = $level>6? intval($diff/2592000).'月前' : date('m-d H:i',$time);
		}elseif ($diff>=31536000 and $diff<94608000){//8级
			$result = $level>7? intval($diff/31536000).'年前' :date('y-m-d H:i',$time);
		}else{//9级
			$result = $level>8? '无更新' : date('y-m-d H:i',$time);
		}
		return $result;
	}

	/**
	 * 根据生日中的年份来计算所属生肖
	 * @param int $birthday
	 * @return string
	 */
	static function get_animal($birthday) {
		$birth_year = date ( 'Y', $birthday );
		$arr=array ( 1950 => -627120000, 1951 => -596534400, 1952 => -565862400, 1953 => -532684800, 1954 => -502099200, 1955 => -471427200, 1956 => -438249600, 1957 => -407664000, 1958 => -374572800, 1959 => -343900800, 1960 => -313315200, 1961 => -280137600, 1962 => -249465600, 1963 => -218880000, 1964 => -185702400, 1965 => -155030400, 1966 => -124531200, 1967 => -91353600, 1968 => -60681600, 1969 => -27504000, 1970 => 3081600, 1971 => 33753600, 1972 => 66931200, 1973 => 97516800, 1974 => 128102400, 1975 => 161280000, 1976 => 191865600, 1977 => 225043200, 1978 => 255628800, 1979 => 286300800, 1980 => 319478400, 1981 => 350150400, 1982 => 380736000, 1983 => 413913600, 1984 => 444499200, 1985 => 477676800, 1986 => 508262400, 1987 => 538848000, 1988 => 572025600, 1989 => 602697600, 1990 => 633369600, 1991 => 666547200, 1992 => 697132800, 1993 => 727718400, 1994 => 760809600, 1995 => 791481600, 1996 => 824659200, 1997 => 855244800, 1998 => 885916800, 1999 => 919094400, 2000 => 949680000, 2001 => 980265600, 2002 => 1013443200, 2003 => 1044028800, 2004 => 1074700800, 2005 => 1107878400, 2006 => 1138464000, 2007 => 1171728000, 2008 => 1202313600, 2009 => 1232899200, 2010 => 1266076800, 2011 => 1296662400, 2012 => 1327248000, 2013 => 1360425600, 2014 => 1391097600, 2015 => 1424275200, 2016 => 1454860800, 2017 => 1485532800, 2018 => 1518710400, 2019 => 1549296000);
		if(isset($arr[$birth_year])){
			$birth_year=$arr[$birth_year]>$birthday?$birth_year-=1:$birth_year;
		}
		//1900年是子鼠年 子鼠丑牛、寅虎卯兔、辰龙巳蛇、午马未羊、申猴酉鸡、戌狗亥猪
		$animal = array ('子鼠', '丑牛', '寅虎', '卯兔', '辰龙', '巳蛇', '午马', '未羊', '申猴', '酉鸡', '戌狗', '亥猪' );
		$my_animal = ($birth_year - 1900) % 12;
		return $animal [$my_animal];
	}
	/**
	 * 根据生日来计算年龄
	 * 用Unix时间戳计算是最准确的，但不太好处理1970年之前出生的情况,而且还要考虑闰年的问题，所以就暂时放弃这种方式的开发，保留思想
	 * @param date $birthday
	 * @return int
	 */
	static function get_age($birthday) {
		$birth_year = substr($birthday,2,1);
		$now_age=$birth_year."0后";
		return $now_age;
	}

	/**
	 * 根据生日中的月份和日期来计算所属星座
	 * @param date $birthday 格式 1985-02-28
	 * @return string
	 */
	static function get_constellation($birthday) {
		$birth_month = date ( 'm', $birthday );
		$birth_date = date ( 'd', $birthday );
		$constellation_list = array(
			array('name'=>'水瓶座','min'=>20,'max'=>18),
			array('name'=>'双鱼座','min'=>19,'max'=>20),
			array('name'=>'白羊座','min'=>21,'max'=>19),
			array('name'=>'金牛座','min'=>20,'max'=>20),
			array('name'=>'双子座','min'=>21,'max'=>21),
			array('name'=>'巨蟹座','min'=>22,'max'=>22),
			array('name'=>'狮子座','min'=>23,'max'=>22),
			array('name'=>'处女座','min'=>23,'max'=>22),
			array('name'=>'天枰座','min'=>23,'max'=>23),
			array('name'=>'天蝎座','min'=>24,'max'=>22),
			array('name'=>'射手座','min'=>23,'max'=>21),
			array('name'=>'摩羯座','min'=>22,'max'=>19)
		);
		$constellation = $constellation_list[$birth_month-1];
		if($constellation['min']>$birth_date){
			if('01'==$birth_month){
				$constellation = $constellation_list[11];
			}else{
				$constellation = $constellation_list[$birth_month-2];
			}

		}
		return $constellation['name'];
	}

	/**
	 * 获取int秒数的字符串形式，如128秒则输出 00:02:08
	 *
	 * @param $time int 要转换的时间
	 * @return stirng
	 */
	static function timestr($time) {
		$time = intval ( $time );
		$h = intval ( $time / 3600 );
		$m = intval ( ($time - $h * 3600) / 60 );
		$s = $time - $h * 3600 - $m * 60;
		return str_pad ( $h, 2, "0", STR_PAD_LEFT ) . ':' . str_pad ( $m, 2, "0", STR_PAD_LEFT ) . ':' . str_pad ( $s, 2, "0", STR_PAD_LEFT );
	}


	/*
	 * 过滤html特殊字符
	*/
	static function dhtmlspecialchars($string) {
		if (is_array ( $string )) {
			foreach ( $string as $key => $val ) {
				$string [$key] = dhtmlspecialchars ( $val );
			}
		} else {
			$string = preg_replace ( '/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', //$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
			str_replace ( array ('&', '"', '<', '>' ), array ('&amp;', '&quot;', '&lt;', '&gt;' ), $string ) );
		}
		return $string;
	}

	/*
	 * 文字过长截取部分长度用符号替换
	 */
	static function cut_str($sourcestr,$cutlength,$dot='...',$left=false) {
		$returnstr='';
		$n=$i=0;
		$str_length=strlen($sourcestr);//字符串的字节数
		while (($n<$cutlength) and ($i<=$str_length)) {
		   $temp_str=substr($sourcestr,$i,1);
		   $ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码
		   if ($ascnum>=224){ //如果ASCII位高与224，
		      $returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
		      $i=$i+3;          //实际Byte计为3
		      $n=$n+2;          //字串长度计1
		   }elseif ($ascnum>=192){ //如果ASCII位高与192，
		      $returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
		      $i=$i+2;          //实际Byte计为2
		      $n=$n+2;          //字串长度计1
		   }elseif ($ascnum>=65 && $ascnum<=90){  //如果是大写字母，
		      $returnstr=$returnstr.substr($sourcestr,$i,1);
		      $i=$i+1;          //实际的Byte数仍计1个
		      $n++;          //但考虑整体美观，大写字母计成一个高位字符
		   }else{             //其他情况下，包括小写字母和半角标点符号，
		      $returnstr=$returnstr.substr($sourcestr,$i,1);
		      $i=$i+1;          //实际的Byte数计1个
		      $n=$n+1;        //小写字母和半角标点等与半个高位字符宽...
		   }
		}
		if($sourcestr!=$returnstr){
			$returnstr = $returnstr . $dot;//被截取后在尾处加上省略号
		}
		if($left){
			$returnstr=substr($sourcestr,$i);
		}
		return $returnstr;
	}


	public static function htmls($str){
		return htmlspecialchars($str,ENT_QUOTES|ENT_SUBSTITUTE);
	}


	/**
	 * 将大小将字节转为各种单位大小
	 * @return [type] [description]
	 */
	public static function toSize($bytes){

		if ($bytes >= pow(2,40)) {      		     //如果提供的字节数大于等于2的40次方，则条件成立
			$return = round($bytes / pow(1024,4), 2);    //将字节大小转换为同等的T大小
			$suffix = "TB";                        	     //单位为TB
		} elseif ($bytes >= pow(2,30)) {  		     //如果提供的字节数大于等于2的30次方，则条件成立
			$return = round($bytes / pow(1024,3), 2);    //将字节大小转换为同等的G大小
			$suffix = "GB";                              //单位为GB
		} elseif ($bytes >= pow(2,20)) {  		     //如果提供的字节数大于等于2的20次方，则条件成立
			$return = round($bytes / pow(1024,2), 2);    //将字节大小转换为同等的M大小
			$suffix = "MB";                              //单位为MB
		} elseif ($bytes >= pow(2,10)) {  		     //如果提供的字节数大于等于2的10次方，则条件成立
			$return = round($bytes / pow(1024,1), 2);    //将字节大小转换为同等的K大小
			$suffix = "KB";                              //单位为KB
		} else {                     			     //否则提供的字节数小于2的10次方，则条件成立
			$return = $bytes;                            //字节大小单位不变
			$suffix = "Byte";                            //单位为Byte
		}

		return $return ." " . $suffix;               //返回合适的文件大小和单位
	}

}

