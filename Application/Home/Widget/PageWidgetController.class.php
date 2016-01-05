<?php
    namespace Home\Widget;
    use Think\Controller;
    class PageWidget extends Controller {
		public function menu(){
			$system_info=M("System_info");
			$array=$system_info->find();
			$this->assign("array",$array);
		}
    }
?>