<?php
/*
 *	+----------------------------------------------------------------------
 *	| $Desc: 分页类
 *	+----------------------------------------------------------------------
 *	| $Author: 柴新鹏 <chaixinpeng@u17.com>
 *	+----------------------------------------------------------------------
 *	| $Date: 
 *	+----------------------------------------------------------------------
 *
 */

namespace classes;

class Page{

	protected $count = 0;
	private $pageCount = 0;
	private $page = 1;
	private $url = '';
	public $other_params = array();

	//分页的class样式
	private $pageClass = array(
		'div' => '\'height: 30px;border:1px solid #ccc;overflow: hidden;display: block;clear: both;text-align: center;\'',
		'ul' => '\'float: left;position: relative;left: 50%;margin:0;list-style: none;\'',
		'li' => '\'position: relative;right: 50%;height: 30px;line-height: 30px;float: left;margin-left:12px;\''
	);

	function __construct($count,$pageNum = 10){
		$this->count = $count;
		$this->pageNum = $pageNum;
		$this->pageCount = ceil($count/$pageNum);		
		$this->page = isset($_GET['page']) ? $_GET['page'] : $this->page;
		
	}


	/**
	 * 在外部接收用户传入的设置url参数的集合
	 * @param array $arr [description]
	 */
	public function setUrlOtherParams(array $arr){
		$this->other_params = $arr;
	}

	/**
	 * 组合url参数
	 * @return [type] [description]
	 */
	private function getUrl(){
		$params = array('page' => $this->page); 
		if($this->other_params){
			$params = array_merge($this->other_params,$params);
		}
		$this->url = '?'.http_build_query($params);

	}

	/**
	 * 上一页
	 * @return [type] [description]
	 */
	private function prevPage(){
		if($this->page > 1){
			$this->page = $this->page - 1;
			$this->getUrl($this->page);
			return "<li style={$this->pageClass['li']}><a href={$this->url}>上一页</a></li>";
		}
	}

	/**
	 * 下一页
	 * @return [type] [description]
	 */
	private function nextPage(){
		if ($this->page < $this->pageCount){
			$this->page = $this->page + 1;
			$this->getUrl($this->page);
			return "<li style={$this->pageClass['li']}><a href={$this->url}>下一页</a></li>";
		}
	}

	/**
	 * 第一页
	 * @return [type] [description]
	 */
	private function firstPage(){
		$this->page = 1;
		$this->getUrl($this->page);
		return "<li style={$this->pageClass['li']}><a href={$this->url}>首页</a></li>";
	}

	/**
	 * 最后一页
	 * @return [type] [description]
	 */
	private function lastPage(){
		$this->page = $this->pageCount;
		$this->getUrl($this->page);
		return "<li style={$this->pageClass['li']}><a href={$this->url}>尾页</a></li>";
	}

	/**
	 * 输出中间的分页列表
	 * @return [type] [description]
	 */
	private function pageList(){

		$pageList = '';
		for ($i=2; $i < $this->pageCount; $i++) {
			$this->page = $i;
			$this->getUrl($this->page);
			$pageList .= "<li style={$this->pageClass['li']}><a href={$this->url}>{$this->page}</a></li>";
		}

		return $pageList;
	}

	/**
	 * [showPage 输入分页类]
	 * @return [type] [description]
	 */
	function showPage(){

		$show[1] = "<li style={$this->pageClass['li']}><a href='javascript:;'>共{$this->count}条</a></li>";
		$show[2] = "<li style={$this->pageClass['li']}><a href='javascript:;'>共{$this->pageCount}条</a></li>";
		$show[3] = $this->firstPage();
		$show[4] = $this->prevPage();
		$show[5] = $this->pageList();
		$show[6] = $this->nextPage();
		$show[7] = $this->lastPage();						
		
		//从外部接受参数达到用户自定义输入格式
		$config = func_get_args() ? func_get_args() : array(1,2,3,4,5,6,7);

		echo "<div style={$this->pageClass['div']}>";
		echo "<ul style={$this->pageClass['ul']}>";
		foreach ($config as $key => $value) {
			echo $show[$value];
		}
		echo "</ul>";
		echo "</div>";

	}

}