<?php
/**
 *	+----------------------------------------------------------------------
 *	| $Desc: mysqli
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@vip.qq.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */


namespace libs;

class Mysqli implements \interf\Db{

	use Singleton;

	protected $conn;

	public function connect($host,$user,$password,$dbname){
		return $this->conn = mysqli_connect($host,$user,$password,$dbname);
	}
	

	public function query($sql){
		return mysqli_query($this->conn,$sql);
	}


	public function close(){
		mysqli_close($this->conn);
	}


}