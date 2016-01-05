<?php
    namespace Home\Controller;
    use Think\Controller;
    class EmptyController extends Controller{
		 public function _empty($name){
		//把所有城市的操作解析到city方法
			$this->redirect("index/index");
		}
    }