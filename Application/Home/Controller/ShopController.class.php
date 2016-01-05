<?php
	namespace Home\Controller;
	use Think\Controller;
	class ShopController extends Controller{
		function __construct(){
			parent::__construct();
			$id=session("id");
			if(isset($id)){
				//求购物车总和
				$cart=M("cart");
				$id=session("id");
				$num=$cart->field("sum(num) as total")->where("user_id=$id")->find();
				cookie("num",$num["total"]);
			}
			$system_info=M("System_info");
			$array=$system_info->find();
			$this->assign("array",$array);
			
			//关键字信息
			$keyword_manage=M("keyword_manage");
			$keyword=$keyword_manage->field("keyword")->order("weight desc")->where("role=0")->select();
			$this->assign("keyword",$keyword);					
		}

		public function index(){
			$id=$_REQUEST["id"];
            $page=$_REQUEST["page"];
            if(!$page){
                $page = 1;
            }
            $pageSize = 20;
            //查询店铺的基本信息
            $ShopModel = new \Home\Model\ShopModel();
            $shop_info = $ShopModel->get_shop_info($id);
			//$shop=M("shop");
			//$data=$shop->field("")
            $this->assign("shop_info", $shop_info);
            //渲染样式表
            if($shop_info["shop_display"] == 2){
                $this->assign("shop_display", "shop2.css");
            } else {
                $this->assign("shop_display", "shop1.css");
            }
			//
			$mall=M("mall");
			$mall_info=$mall->where("id=$shop_info[mall_id]")->find();
			$this->assign("mall_info",$mall_info);
		    	
            //查询店铺的图片
            /*$ShopPicModel = new \Home\Model\ShopPicModel();
            $this->assign("pic", $ShopPicModel->get_shop_pic($id)); 
			*/
			
			$shophomeFocus=D("ShopHomeFocus");
			$pic=$shophomeFocus->where("role=$id")->select();
			$this->assign("pic",$pic);
			
            //查询店铺的特价商品
            $GoodModel = new \Home\Model\GoodModel();
            $this->assign("dis_count", $GoodModel->get_shop_discount_good($id));
            //查询店铺的所有商品
            $this->assign("all_good", $GoodModel->get_shop_all_good($id, $page, $pageSize));
            $all_good_num = $GoodModel->get_shop_good_num($id);
            $page_num = ceil($all_good_num / $pageSize);
            $this->assign("page_num", $page_num);
            $page_element = array();
            
            while($page_num-- > 0){
                array_push($page_element, "<span>".($page_num+1)."</span>");         
            }
            $this->assign("page_element", array_reverse($page_element));
			$this->display();
		}

		public function person(){
			$this->display();
		}

		public function alist(){
			$aid=$_GET["id"];
			$articles=M("Articles");
			$result_temp=$articles->where("aid=$aid")->find();
			$this->assign("result_temp",$result_temp);
			$id=$result_temp["belong"];
			
            //查询店铺的基本信息
            $ShopModel = new \Home\Model\ShopModel();
            $shop_info = $ShopModel->get_shop_info($id);
			//$shop=M("shop");
			//$data=$shop->field("")
            $this->assign("shop_info", $shop_info);

			//
			$mall=M("mall");
			$mall_info=$mall->where("id=$shop_info[mall_id]")->find();
			$this->assign("mall_info",$mall_info);
			
            //查询店铺的图片
            /*$ShopPicModel = new \Home\Model\ShopPicModel();
            $this->assign("pic", $ShopPicModel->get_shop_pic($id)); 
			*/
			
			$shophomeFocus=D("ShopHomeFocus");
			$pic=$shophomeFocus->where("role=$id")->select();
			$this->assign("pic",$pic);
			
			$this->display();
		}
		public function _empty($name){
		//把所有城市的操作解析到city方法
			$this->redirect("index/index");
		}		
	}
