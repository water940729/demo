<?php

namespace Home\Controller;
use Think\Controller;

class TabChangeController extends Controller{
    
    private $id;

    public function __construct(){
        parent::__construct();
        $id = session("id");    
        if(!$id){
            $this->redirect("login/login");
        }
        $this->id = $id;
    }
    
    /*
     *渲染order/order页面下的order部分
     */
    public function order(){
        $status = $_REQUEST["status"];
        $time_flag = $_REQUEST["time_flag"];
        $search_text = $_REQUEST["search_text"];
        if(!isset($status)){
            $status = 40;
        }
        if(!isset($time_flag)){
            $time_flag = 5;
        }
        $OrderModel = new \Home\Model\OrderModel();
        //取得各个状态的数目
        list($wait_pay, $wait_send, $wait_take, $wait_comment) = $OrderModel->search_status_num($this->id);
        
        $this->assign("wait_pay", $wait_pay);
        $this->assign("wait_send", $wait_send);
        $this->assign("wait_take", $wait_take);
        $this->assign("wait_comment", $wait_comment);
        
        //查询商品详情
        $this->assign("data", $OrderModel->search_order_by_user($this->id,$status,$time_flag, $search_text)); 
            
        $this->assign("orderid", $OrderModel->get_orderid($this->id,$status,$time_flag, $search_text));
        $this->display();
    }

     /*
     *渲染order/order页面下的seckill部分
     */
    public function seckill(){
        $status = $_REQUEST["status"];
        $time_flag = $_REQUEST["time_flag"];
        $search_text = $_REQUEST["search_text"];
        if(!isset($status)){
            $status = 40;
        }
        if(!isset($time_flag)){
            $time_flag = 5;
        }
        $OrderModel = new \Home\Model\SeckillOrderModel();
        //取得各个状态的数目
        list($wait_pay, $wait_send, $wait_take, $wait_comment) = $OrderModel->search_status_num($this->id);
        
        $this->assign("wait_pay", $wait_pay);
        $this->assign("wait_send", $wait_send);
        $this->assign("wait_take", $wait_take);
        $this->assign("wait_comment", $wait_comment);
        
        //查询商品详情
        $this->assign("data", $OrderModel->search_order_by_user($this->id,$status,$time_flag, $search_text)); 
            
        $this->assign("orderid", $OrderModel->get_orderid($this->id,$status,$time_flag, $search_text));
        $this->display();
    }
   
     /*
     *渲染order/order页面下的teambuy部分
     */
    public function teambuy(){
        $status = $_REQUEST["status"];
        $time_flag = $_REQUEST["time_flag"];
        $search_text = $_REQUEST["search_text"];
        if(!isset($status)){
            $status = 40;
        }
        if(!isset($time_flag)){
            $time_flag = 5;
        }
        $OrderModel = new \Home\Model\TeambuyOrderModel();
        //取得各个状态的数目
        list($wait_pay, $wait_send, $wait_take, $wait_comment) = $OrderModel->search_status_num($this->id);
        
        $this->assign("wait_pay", $wait_pay);
        $this->assign("wait_send", $wait_send);
        $this->assign("wait_take", $wait_take);
        $this->assign("wait_comment", $wait_comment);
        
        //查询商品详情
        $this->assign("data", $OrderModel->search_order_by_user($this->id,$status,$time_flag, $search_text)); 
            
        $this->assign("orderid", $OrderModel->get_orderid($this->id,$status,$time_flag, $search_text));
        $this->display();
    }

     /*
     *渲染order/order页面下的Trial部分
     */
    public function trial(){
        $status = $_REQUEST["status"];
        $time_flag = $_REQUEST["time_flag"];
        $search_text = $_REQUEST["search_text"];
        if(!isset($status)){
            $status = 40;
        }
        if(!isset($time_flag)){
            $time_flag = 5;
        }
        $OrderModel = new \Home\Model\TrialOrderModel();
        //取得各个状态的数目
        list($wait_pay, $wait_send, $wait_take, $wait_comment) = $OrderModel->search_status_num($this->id);
        
        $this->assign("wait_pay", $wait_pay);
        $this->assign("wait_send", $wait_send);
        $this->assign("wait_take", $wait_take);
        $this->assign("wait_comment", $wait_comment);
        
        //查询商品详情
        $this->assign("data", $OrderModel->search_order_by_user($this->id,$status,$time_flag, $search_text)); 
            
        $this->assign("orderid", $OrderModel->get_orderid($this->id,$status,$time_flag, $search_text));
        $this->display();
    }

     /*
     *渲染order/order页面下的book部分
     */
    public function book(){
        $status = $_REQUEST["status"];
        $time_flag = $_REQUEST["time_flag"];
        $search_text = $_REQUEST["search_text"];
        if(!isset($status)){
            $status = 40;
        }
        if(!isset($time_flag)){
            $time_flag = 5;
        }
        $OrderModel = new \Home\Model\BookOrderModel();
        //取得各个状态的数目
        list($wait_pay, $wait_send, $wait_take, $wait_comment) = $OrderModel->search_status_num($this->id);
        
        $this->assign("wait_pay", $wait_pay);
        $this->assign("wait_send", $wait_send);
        $this->assign("wait_take", $wait_take);
        $this->assign("wait_comment", $wait_comment);
        
        //查询商品详情
        $this->assign("data", $OrderModel->search_order_by_user($this->id,$status,$time_flag, $search_text)); 
            
        $this->assign("orderid", $OrderModel->get_orderid($this->id,$status,$time_flag, $search_text));
        $this->display();
    }

    //渲染收藏的页面
    public function collect(){
        //根据商品的类型来渲染
        $type = $_REQUEST["type"];         
        if(!isset($type)){
            $type = 40;
        }

        $CollectModel = new \Home\Model\CollectionModel();
        //查找各种商品类型的个数
        list($all, $common, $seckill, $teambuy, $trial, $book) = $CollectModel->get_num($this->id);
        $this->assign("all", $all);
        $this->assign("common", $common);
        $this->assign("seckill", $seckill);
        $this->assign("teambuy", $teambuy);
        $this->assign("trial", $trial);
        $this->assign("book", $book);

        //首先查找所有满足条件的藏品
        //然后根据藏品id找到现在的藏品的信息
        $goods = $CollectModel->get_collect($type, $this->id);

        $GoodModel = new \Home\Model\GoodModel(); 
        $SeckillGoodModel = new \Home\Model\SeckillGoodModel();
        $TeamGoodModel = new \Home\Model\TeamGoodsModel();
        $TrialGoodModel = new \Home\Model\TrialGoodsModel();
        $BookGoodModel = new \Home\Model\BookGoodsModel();

        $result_array = array();
        foreach($goods as $piece){
            $good_id = $piece["collect_id"];                    

            switch($piece["collect_type"]){
                case "1":
                    $good_info = $GoodModel->get_info($good_id);
                    break;
                case "3":
                    $good_info = $SeckillGoodModel->get_info($good_id);
                    break;
                case "4":
                    $good_info = $TeamGoodModel->get_info($good_id);
                    break;
                case "5":
                    $good_info = $TrialGoodModel->get_info($good_id);
                    break;
                case "6":
                    $good_info = $BookGoodModel->get_info($good_id);
                    break;
                default:
                    return false;
            }
            array_push($result_array, array("collect_info"=>$piece,"good_info"=>$good_info));
        }
        $this->assign("result",$result_array);
        $this->display();
    }

    //渲染浏览历史页面
    public function footprint(){
        $id = $this->id;
        $result_array = array();
        $FootprintModel = new \Home\Model\FootprintModel();
        $footprint_info = $FootprintModel->get_user_footprint($id);
        $GoodModel = new \Home\Model\GoodModel();
        foreach($footprint_info as $piece){
            $good_info = $GoodModel->get_info($piece["good_id"]);
            array_push($result_array, array("good_info"=>$good_info, "footprint_info"=>$piece));
        }
        $this->assign("result", $result_array);
        $this->display();
    }


    //渲染店铺收藏页面
        public function shop_collect(){
            $id = $this->id;
            $result_array = array();
            $CollectionModel = new \Home\Model\CollectionModel();
            $ShopModel = new \Home\Model\ShopModel();
            $shop_collect = $CollectionModel->get_shop_collect($id);
            foreach($shop_collect as $piece){
                $shop_info = $ShopModel->get_shop_info($piece["collect_id"]);
                array_push($result_array, array("shop_info"=>$shop_info, "collect_info"=>$piece));    
            }
            $this->assign("result", $result_array);
            $this->display();
        } //end function
		
		
	public function address_manage(){
		$id=$this->id;
		$AddressModel=D("address");
		$UserManage=D("user_manage");
		$defaul_address_id=$UserManage->getDefaultAddressId($id);
		$default_address=$AddressModel->getDefaultAddress($id,$defaul_address_id["default_address"]);
		$info_address=$AddressModel->getAllAddress($id);
		
		$this->assign("default_address",$default_address);
		$this->assign("info_address",$info_address);
		$this->display();
	}
	public function address_info(){
		//load加载
		$id=$this->id;
		$AddressModel=D("address");
		$UserManage=D("user_manage");
		$defaul_address_id=$UserManage->getDefaultAddressId($id);
		$default_address=$AddressModel->getDefaultAddress($id,$defaul_address_id["default_address"]);
		$info_address=$AddressModel->getAllAddress($id);
		
		$this->assign("default_address",$default_address);
		$this->assign("info_address",$info_address);
		$this->display();
	}	


        //渲染评价页面
        public function score(){
            $id = $this->id;
            $result_array = array();
            $result_array_amend = array();
            //查询各个里面的等待评价的单子
            $orderTableArray=array("orderlist", "seckill_orderlist", "teambuy_orderlist", "trial_orderlist", "book_orderlist");
            foreach($orderTableArray as $tablePiece){
                $Model = M($tablePiece);
                $result_array  = array_merge($result_array, $Model->where("ordstatus=3 and userid=$id")->select());
            }
            foreach($result_array as $piece){
                switch($piece["ordertype"]){
                    case '1':$goodPrefix = 'good/index';break;
                    case '2':$goodPrefix = 'good/seckill';break;
                    case '3':$goodPrefix = 'good/teambuy';break;
                    case '4':$goodPreifx = 'good/trial';break;
                    case '5':$goodPrefix = 'good/book';break;
                    default:return false;
                }
                $piece["goodPrefix"] = $goodPrefix; 
                //查询所有的标签
                $CommentTagModel = new \Home\Model\CommentTagModel();
                $tag_array = $CommentTagModel->search_important_tag($piece["productid"], $piece["ordertype"]);
                $piece["tag_array"] = $tag_array;
                array_push($result_array_amend, $piece);
            }
            $this->assign("ordlist_to_score", $result_array_amend); 
            
            //渲染已经评价过的
            $orderTableArray=array("orderlist", "seckill_orderlist", "teambuy_orderlist", "trial_orderlist", "book_orderlist");
            $done_result_array = array();
            $done_array_amend = array();
            foreach($orderTableArray as $tablePiece){
                $Model = M($tablePiece);
                $done_result_array = array_merge($done_result_array, $Model->where("ordstatus=6 and userid=$id")->select());
            }
            $BaskModel = new \Home\Model\BaskModel();
            $CommentModel = new \Home\Model\CommentModel();
            foreach($done_result_array as $piece){
                switch($piece["ordertype"]){
                    case '1':$goodPrefix = 'good/index';break;
                    case '2':$goodPrefix = 'good/seckill';break;
                    case '3':$goodPrefix = 'good/teambuy';break;
                    case '4':$goodPreifx = 'good/trial';break;
                    case '5':$goodPrefix = 'good/book';break;
                    default:return false;
                }
                
                $img_urls = $BaskModel->search_img($piece["userid"], $piece["productid"], $piece["ordertype"], $piece["ordtime"]);

                $comment_info = $CommentModel->search_user_comment($piece["userid"], $piece["productid"], $piece["ordertype"], $piece["ordtime"]);  
                $piece["comment_info"] = $comment_info;
                $piece["img"] = $img_urls;
                $piece["goodPrefix"] = $goodPrefix; 
                array_push($done_array_amend, $piece);

            } 
            $this->assign("done_comment", $done_array_amend);
            $this->display();
        } // end function

		public function _empty($name){
		//把所有城市的操作解析到city方法
			$this->redirect("index/index");
		}		

        //渲染退换货页面
        public function return_good(){
            $id = $this->id;
            if(!$id){
                $this->redirect("user/login");
            }
            $result_array = array();
            $done_result_array = array();

            $result_array_amend = array();
            //查询各个里面的等待评价的单子
            $orderTableArray=array("orderlist", "seckill_orderlist", "teambuy_orderlist", "trial_orderlist", "book_orderlist");
            foreach($orderTableArray as $tablePiece){
                $Model = M($tablePiece);
                $result_array  = array_merge($result_array, $Model->where("ordstatus=9 and userid=$id")->select());
                $done_result_array = array_merge($done_result_array, $Model->where("userid = $id and (ordstatus=4 or ordstatus=5 or ordstatus=6 or ordstatus=7)")->select());    
            }

            foreach($result_array as $piece){
                switch($piece["ordertype"]){
                    case '1':$goodPrefix = 'good/index';break;
                    case '2':$goodPrefix = 'good/seckill';break;
                    case '3':$goodPrefix = 'good/teambuy';break;
                    case '4':$goodPreifx = 'good/trial';break;
                    case '5':$goodPrefix = 'good/book';break;
                    default:return false;
                }
                $piece["goodPrefix"] = $goodPrefix; 
                array_push($result_array_amend, $piece);
            }
            //print_r($result_array_amend);
            $this->assign("ordlist_to_return", $result_array_amend); 
           
            //渲染已经申请退换货的商品
            $done_array_amend = array();
            foreach($done_result_array as $piece){
                switch($piece["ordertype"]){
                    case '1':$goodPrefix = 'good/index';break;
                    case '2':$goodPrefix = 'good/seckill';break;
                    case '3':$goodPrefix = 'good/teambuy';break;
                    case '4':$goodPreifx = 'good/trial';break;
                    case '5':$goodPrefix = 'good/book';break;
                    default:return false;
                }
                $piece["goodPrefix"] = $goodPrefix; 
                array_push($done_array_amend, $piece);
            }
            $this->assign("ordlist_done", $done_array_amend); 
            $this->display();
        } //end function
		
		
		public function recharge_manage(){
			$user_manage=M("user_manage");
			$info=$user_manage->where("username=$_SESSION[username]")->find();
			$this->assign("balance",$info["balance"]);
			$this->display();
		}
		
		public function recharge(){
			$user_manage = M("user_manage");
            $info = $user_manage->where("username=$_SESSION[username]")->find();
            $data['balance'] = $_POST["balance"] + $info['balance'];
			$username = $_SESSION["username"];
			$user_manage->where("username=$username")->save($data);
		}
}
