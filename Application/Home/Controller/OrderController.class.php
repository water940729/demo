<?php
	namespace Home\Controller;
	use Think\Controller;
	class OrderController extends Controller{

		function __construct(){
			parent::__construct();
			//系统信息
			$system_info=M("System_info");
			$array=$system_info->find();
			$this->assign("array",$array);
			
			//关键字信息
			$keyword_manage=M("keyword_manage");
			$keyword=$keyword_manage->field("keyword")->order("weight desc")->select();
			$this->assign("keyword",$keyword);		
			
		}			
        /*
         *用来渲染订单列表，该数据方法不再试用，迁移到TabChangeController中
         *目前只用来显示上边和左边
         */
		public function order(){
			$username=session("username");
			$id=session("id");
			if(empty($username)){
				session("redirectURL","../order/order");
				$this->redirect("user/login");
			}
           /* 
            else{
				$orderlist=M("orderlist");
				$result=$orderlist->field("id,ordid,productid,mall_id,mall_name,productname,productimage,ordtime,ordfee,ordstatus")->where("userid=$id and UNIX_TIMESTAMP(ordtime)>UNIX_TIMESTAMP(DATE_SUB(CURDATE(),INTERVAL 3 MONTH))")->select();
				$this->assign("data",$result);
				$id=$orderlist->field("ordid")->group("ordid")->order("ordtime desc")->where("UNIX_TIMESTAMP(ordtime)>UNIX_TIMESTAMP(DATE_SUB(CURDATE(),INTERVAL 3 MONTH))")->select();
				$this->assign("orderid",$id);
				$this->display();
				//dump($result);
				//dump($id);
			}
            */
				$this->display();
		}

		public function addcart(){
			$type=$_POST["type"];
			$id=$_POST["id"];
			$cart=M("cart");
			$username=session("username");
			if(empty($username)){
				//用户没有登录的情况，添加到购物车就保存到cookie中
				$goods_info=json_decode(cookie("cart_info"));
				if(isset($goods_info)){
					$i=count($goods_info);
					$goods_info[$i]=array("id"=>$_POST["id"],"type"=>$_POST["type"],"num"=>$_POST["num"]);
					cookie("cart_info",json_encode($goods_info));
					echo 1;
				}else{
					$goods_info[0]=array("id"=>$_POST["id"],"type"=>$_POST["type"],"num"=>$_POST["num"]);
					cookie("cart_info",json_encode($goods_info));
					echo 1;
				}
				$num=cookie("num");
				$num=$num+$_POST["num"];
				cookie("num",$num);
			}else{
				$goods=M("goods");
				$result=$goods->where("id=$id")->select();
				//$this->assign("result",$result);
				$num=$_POST["num"];
				
				//插入字段
				$data["photo"]=$result[0]["image_url"];
				$data["user_id"]=session("id");
				$data["shop_id"]=$result[0]["shop_id"];
				$data["shop_name"]=$result[0]["shop_name"];
				$data["mall_id"]=$result[0]["mall_id"];
				$data["mall_name"]=$result[0]["mall_name"];
				$data["good_id"]=$result[0]["id"];
				$data["good_name"]=$result[0]["name"];
				$data["good_info"]=$type;
				$data["price"]=$result[0]["price"];
				$data["num"]=$num;
				$data["freight"]=$result[0]["freight"];
				//$data["send"]=$_POST["send"];
				$data["time"]=time();

				//购物车中是否有同类商品
				$last=$cart->where("user_id=$data[user_id] and good_id=$id and good_info='".$type."'")->select();
				//echo "good_id=$id and good_info=$type";
				if($last){
					$update["num"]=$num+$last[0]["num"];
					$update["time"]=$data["time"];
					if($cart->where("user_id=$data[user_id] and good_id=$id and good_info='{$data[good_info]}'")->save($update)){
						echo 1;
					}else{
						echo "数据库异常请稍后再试";
					}
				}
				else if($cart->add($data)){
					$num=$cart->field("sum(num) as total")->where("user_id=$data[user_id]")->select();
					cookie("num",$num[0]["total"]);
					echo 1;
				}else{
					echo "数据库异常请稍后再试";
				}			
			}
		}
		public function clearcart(){
			$id=session("id");
			if(isset($id)){
				$cart=M("cart");
				if(isset($_POST["id"])){
					$temp=explode(",",$_POST["id"]);
					$filter="(";
					foreach($temp as $vo){
						if(!empty($vo))
						$filter.=$vo.",";
					}
					$filter=substr($filter,0,-1);
					$filter.=")";
					$cart->where("user_id=$id and id in $filter")->delete();
				}else{
					$cart->where("user_id=$id")->delete();					
				}
				echo 1;
			}else{
				$this->redirect("index/index");
			}
		}
		public function cart(){
			$username=session("username");
			$id=session("id");
			if(empty($username)){
				session("redirectURL","order/cart");
				$this->redirect("user/login");
			}else{
				$cart=M("cart");
				//获取购物车信息
				$result=$cart->where("user_id=$id")->select();
				$this->assign("result",$result);
				$shopname=$cart->field("shop_name")->group("shop_name")->where("user_id=$id")->select();
				$this->assign("shopname",$shopname);
				//print_r($result);
				$footprint=D("FootGoodsRelation");
				$footdata=$footprint->relation(true)->field("good_id")->order("time desc")->where("user_id=$id")->limit(10)->select();
				$this->assign("footdata",$footdata);
				$this->display();
				//dump($result);
				//dump($id);
			}
		}
		public function modifycart(){
			//print_r($_POST);
			//Array([id] => 11 [value] => 11)
			$cart=M("cart");
			$data["num"]=$_POST["value"];
			if($cart->where("id=$_POST[id]")->save($data)){
				echo 1;
			}
		}
		public function address_info(){
			//地址部分
			$user_id=session("id");
			$user=M("User_manage");
			$userinfo=$user->where("user_id=$user_id")->find();				
			$address=M("address");
			$adddata=$address->where("user_id=$userinfo[user_id] and address_id!=$userinfo[default_address]")->select();
			$this->assign("adddata",$adddata);
			$default=$address->where("user_id=$userinfo[user_id] and address_id=$userinfo[default_address]")->find();
			$this->assign("default",$default);
			$this->display();
		}			
		public function order_info(){
			$ordid=$_GET["ordid"];
			$orderlist=M("orderlist");
			$result=$orderlist->where("ordid=$ordid")->select();
			$this->assign("result",$result);
			$data=$orderlist->where("ordid=$ordid")->find();
			$this->assign("data",$data);
			$total=$orderlist->query("select sum(ordfee) as sum from orderlist where ordid=$ordid");
			$this->assign("total",$total);
			$this->assign("ordid",$ordid);
			$this->display();
		}
		public function confirm_order(){
			//订单相关的信息
			$user_id=session("id");
			if(!empty($user_id)){
				if(isset($_POST["id"])){
					$cart=M("cart");
					$map["id"]=array("in",$_POST["id"]);
					$result=$cart->where($map)->select();
					$shopname=$cart->where($map)->distinct(true)->field("shop_name")->select();
					$this->assign("shopname",$shopname);
					$this->assign("result",$result);
					$user=M("User_manage");
					$userinfo=$user->where("user_id=$user_id")->find();
					//print_r($userinfo);
					
					//地址部分
					$address=M("address");
					$adddata=$address->where("user_id=$userinfo[user_id] and address_id!=$userinfo[default_address]")->select();
					$this->assign("adddata",$adddata);
					$default=$address->where("user_id=$userinfo[user_id] and address_id=$userinfo[default_address]")->find();
					$this->assign("default",$default);
					
					$this->display();
				}else{
					$this->redirect("order/cart");
				}
			}else{
				$this->redirect("index/index");
			}
		}
		public function buy(){
			//立刻购买
			$user_id=session("id");
			if(isset($_POST["id"])&&isset($user_id)){
				$good=M("goods");
				$result=$good->where("id=$_POST[id]")->find();
				$this->assign("result",$result);
				$this->assign("type",$_POST["type"]);
				$this->assign("num",$_POST["num"]);
				
				//地址部分
				$user=M("User_manage");
				$userinfo=$user->where("user_id=$user_id")->find();				
				$address=M("address");
				$adddata=$address->where("user_id=$userinfo[user_id] and address_id!=$userinfo[default_address]")->select();
				$this->assign("adddata",$adddata);
				$default=$address->where("user_id=$userinfo[user_id] and address_id=$userinfo[default_address]")->find();
				$this->assign("default",$default);
				$this->display();
			}else{
				session("redirectURL","good/index/id/$_POST[id]");
				$this->redirect("user/login");
			}
		}

        //买秒杀商品
		public function sec_buy(){
			//立刻购买
			$user_id=session("id");
			if(isset($_POST["id"])&&isset($user_id)){
				$good=M("seckill_goods");
				$result=$good->where("id=$_POST[id]")->find();
				$this->assign("result",$result);
				$this->assign("type",$_POST["type"]);
				$this->assign("num",$_POST["num"]);
				
				//地址部分
				$user=M("User_manage");
				$userinfo=$user->where("user_id=$user_id")->find();				
				$address=M("address");
				$adddata=$address->where("user_id=$userinfo[user_id] and address_id!=$userinfo[default_address]")->select();
				$this->assign("adddata",$adddata);
				$default=$address->where("user_id=$userinfo[user_id] and address_id=$userinfo[default_address]")->find();
				$this->assign("default",$default);
				$this->display("Order/sec_buy");
			}else{
				$this->redirect("user/login");
			}
		}

        //买团购商品
		public function team_buy(){
			//立刻购买
			$user_id=session("id");
			if(isset($_POST["id"])&&isset($user_id)){
				$good=M("teambuy_goods");
				$result=$good->where("id=$_POST[id]")->find();
				$this->assign("result",$result);
				$this->assign("type",$_POST["type"]);
				$this->assign("num",$_POST["num"]);
				
				//地址部分
				$user=M("User_manage");
				$userinfo=$user->where("user_id=$user_id")->find();				
				$address=M("address");
				$adddata=$address->where("user_id=$userinfo[user_id] and address_id!=$userinfo[default_address]")->select();
				$this->assign("adddata",$adddata);
				$default=$address->where("user_id=$userinfo[user_id] and address_id=$userinfo[default_address]")->find();
				$this->assign("default",$default);
				$this->display("Order/team_buy");
			}else{
				$this->redirect("user/login");
			}
		}

        //买试用商品
		public function trial_buy(){
			//立刻购买
			$user_id=session("id");
			if(isset($_POST["id"])&&isset($user_id)){
				$good=M("trial_goods");
				$result=$good->where("id=$_POST[id]")->find();
				$this->assign("result",$result);
				$this->assign("type",$_POST["type"]);
				$this->assign("num",$_POST["num"]);
				
				//地址部分
				$user=M("User_manage");
				$userinfo=$user->where("user_id=$user_id")->find();				
				$address=M("address");
				$adddata=$address->where("user_id=$userinfo[user_id] and address_id!=$userinfo[default_address]")->select();
				$this->assign("adddata",$adddata);
				$default=$address->where("user_id=$userinfo[user_id] and address_id=$userinfo[default_address]")->find();
				$this->assign("default",$default);
				$this->display("Order/trial_buy");
			}else{
				$this->redirect("user/login");
			}
		}
        //买预售商品
		public function book_buy(){
			//立刻购买
			$user_id=session("id");
			if(isset($_POST["id"])&&isset($user_id)){
				$good=M("book_goods");
				$result=$good->where("id=$_POST[id]")->find();
				$this->assign("result",$result);
				$this->assign("type",$_POST["type"]);
				$this->assign("num",$_POST["num"]);
				
				//地址部分
				$user=M("User_manage");
				$userinfo=$user->where("user_id=$user_id")->find();				
				$address=M("address");
				$adddata=$address->where("user_id=$userinfo[user_id] and address_id!=$userinfo[default_address]")->select();
				$this->assign("adddata",$adddata);
				$default=$address->where("user_id=$userinfo[user_id] and address_id=$userinfo[default_address]")->find();
				$this->assign("default",$default);
				$this->display("Order/book_buy");
			}else{
				$this->redirect("user/login");
			}
		}

		public function buy_confirm(){
			//立即购买的确认
			$user_id=session("id");
			if(isset($_POST["address_id"])&&isset($user_id)){
				$cart_item=json_decode($_POST["cart_item"]);
				$address_id=$_POST["address_id"];
				$message=json_decode($_POST["message"]);
				$goodstype=json_decode($_POST["goodstype"]);
				$num=$_POST["num"];
                $address=M("address"); 
			    $address_result = $address->where("address_id=$address_id")->find();	
				//订单编号
				$r1=rand(0,9);
				$r2=rand(0,9);
				$now=time();
				$ordid="0".$r1.$r2.$now.session("id");
				$dataitem["ordid"]=$ordid;
				$dataitem["ordtime"]=time();
				$dataitem["message"]=$message[$i];
				
				$dataitem["recname"]=$address_result["username"];
				$dataitem["recaddress"]=$address_result["address"];
				$dataitem["recphone"]=$address_result["phone"];
				
				$goods=M("goods");
				$temp=$goods->where("id=$cart_item")->find();
				$dataitem["productimage"]=$temp["image_url"];
				$dataitem["userid"]=$user_id;
				$dataitem["username"]=session("username");
				$dataitem["productid"]=$cart_item;
				$dataitem["mall_id"]=$temp["mall_id"];
				$dataitem["mall_name"]=$temp["mall_name"];
				$dataitem["productname"]=$temp["name"];
				$dataitem["shop_id"]=$temp["shop_id"];
				$dataitem["ordfee"]=$temp["price"]*$num;
				$dataitem["ordbuynum"]=$num;
				$dataitem["ordprice"]=$temp["price"];
				$dataitem["ordstatus"]=0;
				$dataitem["producttype"]=$goodstype;
				$orderlist=M("orderlist");
				$orderlist->add($dataitem);//添加到订单表中	
				$this->assign("trade_no",$ordid);
				$this->assign("ordsubject","葵花商城商品");
				$this->assign("ordtotal_fee",$dataitem["ordfee"]);
				$this->display();
			}else{
				$this->redirect("index/index");
			}
		}
        
        //购买秒杀商品
		public function sec_buy_confirm(){
			//立即购买的确认
			$user_id=session("id");
			if(isset($_POST["address_id"])&&isset($user_id)){
				$cart_item=json_decode($_POST["cart_item"]);
				$address_id=$_POST["address_id"];
				$message=json_decode($_POST["message"]);
				$goodstype=json_decode($_POST["goodstype"]);
				$num=$_POST["num"];
				
                $address=M("address"); 
			    $address_result = $address->where("address_id=$address_id")->find();	
				//订单编号
				$r1=rand(0,9);
				$r2=rand(0,9);
				$now=time();
				$ordid="2".$r1.$r2.$now.session("id");
				$dataitem["ordid"]=$ordid;
				$dataitem["ordtime"]=time();
				$dataitem["message"]=$message;
				
				$dataitem["recname"]=$address_result["username"];
				$dataitem["recaddress"]=$address_result["address"];
				$dataitem["recphone"]=$address_result["phone"];

				$goods=M("seckill_goods");
				$temp=$goods->where("id=$cart_item")->find();
                //print_r($temp);
				$dataitem["productimage"]=$temp["img_url"];
				$dataitem["userid"]=$user_id;
				$dataitem["username"]=session("username");
				$dataitem["productid"]=$cart_item;
				$dataitem["mall_id"]=$temp["mall"];
				$dataitem["productname"]=$temp["goodsname"];
				$dataitem["shop_id"]=$temp["shop"];
				$dataitem["ordfee"]=$temp["price"]*$num;
				$dataitem["ordbuynum"]=$num;
				$dataitem["ordprice"]=$temp["price"];
				$dataitem["ordstatus"]=0;
				$dataitem["producttype"]=$goodstype;
				$orderlist=M("seckill_orderlist");
				$orderlist->add($dataitem);//添加到订单表中	
                $this->assign("trade_no", $ordid);
                $this->assign("ordsubject", "葵花商城商品");
                $this->assign("ordtotal_fee", $dataitem["ordfee"]);
				$this->display("Order:buy_confirm");
			}else{
				$this->redirect("index/index");
			}
		}
        
        //购买团购商品
		public function team_buy_confirm(){
			//立即购买的确认
			$user_id=session("id");
			if(isset($_POST["address_id"])&&isset($user_id)){
				$cart_item=json_decode($_POST["cart_item"]);
				$address_id=$_POST["address_id"];
				$message=json_decode($_POST["message"]);
				$goodstype=json_decode($_POST["goodstype"]);
				$num=$_POST["num"];
				
                $address=M("address"); 
			    $address_result = $address->where("address_id=$address_id")->find();	
				//订单编号
				$r1=rand(0,9);
				$r2=rand(0,9);
				$now=time();
				$ordid="3".$r1.$r2.$now.session("id");
				$dataitem["ordid"]=$ordid;
				$dataitem["ordtime"]=time();
				$dataitem["message"]=$message;
				
				$dataitem["recname"]=$address_result["username"];
				$dataitem["recaddress"]=$address_result["address"];
				$dataitem["recphone"]=$address_result["phone"];

				$goods=M("teambuy_goods");
				$temp=$goods->where("id=$cart_item")->find();
				$dataitem["productimage"]=$temp["img_url"];
				$dataitem["userid"]=$user_id;
				$dataitem["username"]=session("username");
				$dataitem["productid"]=$cart_item;
				$dataitem["mall_id"]=$temp["mall"];
				$dataitem["productname"]=$temp["goodsname"];
				$dataitem["shop_id"]=$temp["shop"];
				$dataitem["ordfee"]=$temp["price"]*$num;
				$dataitem["ordbuynum"]=$num;
				$dataitem["ordprice"]=$temp["price"];
				$dataitem["ordstatus"]=0;
				$dataitem["producttype"]=$goodstype;
				$orderlist=M("teambuy_orderlist");
				$orderlist->add($dataitem);//添加到订单表中					
                $this->assign("trade_no", $ordid);
                $this->assign("ordsubject", "葵花商城商品");
                $this->assign("ordtotal_fee", $dataitem["ordfee"]);
				$this->display("Order:buy_confirm");				
			}else{
				$this->redirect("index/index");
			}
		}

        //购买试用商品
		public function trial_buy_confirm(){
			//立即购买的确认
			$user_id=session("id");
			if(isset($_POST["address_id"])&&isset($user_id)){
				$cart_item=json_decode($_POST["cart_item"]);
				$address_id=$_POST["address_id"];
				$message=json_decode($_POST["message"]);
				$goodstype=json_decode($_POST["goodstype"]);
				$num=$_POST["num"];
				
                $address=M("address"); 
			    $address_result = $address->where("address_id=$address_id")->find();	
				//订单编号
				$r1=rand(0,9);
				$r2=rand(0,9);
				$now=time();
				$ordid="4".$r1.$r2.$now.session("id");
				$dataitem["ordid"]=$ordid;
				$dataitem["ordtime"]=time();
				$dataitem["message"]=$message;
				
				$dataitem["recname"]=$address_result["username"];
				$dataitem["recaddress"]=$address_result["address"];
				$dataitem["recphone"]=$address_result["phone"];
				$goods=M("trial_goods");
				$temp=$goods->where("id=$cart_item")->find();
				$dataitem["productimage"]=$temp["img_url"];
				$dataitem["userid"]=$user_id;
				$dataitem["username"]=session("username");
				$dataitem["productid"]=$cart_item;
				$dataitem["mall_id"]=$temp["mall"];
				$dataitem["productname"]=$temp["goodsname"];
				$dataitem["shop_id"]=$temp["shop"];
				$dataitem["ordfee"]=$temp["price"]*$num;
				$dataitem["ordbuynum"]=$num;
				$dataitem["ordprice"]=$temp["price"];
				$dataitem["ordstatus"]=0;
				$dataitem["producttype"]=$goodstype;
				$orderlist=M("trial_orderlist");
				$orderlist->add($dataitem);//添加到订单表中					
                $this->assign("trade_no", $ordid);
                $this->assign("ordsubject", "葵花商城商品");
                $this->assign("ordtotal_fee", $dataitem["ordfee"]);
				$this->display("Order:buy_confirm");				
		    }else{
				$this->redirect("index/index");
			}
		}

        //购买预售商品
		public function book_buy_confirm(){
			//立即购买的确认
			$user_id=session("id");
			if(isset($_POST["address_id"])&&isset($user_id)){
				$cart_item=json_decode($_POST["cart_item"]);
				$address_id=$_POST["address_id"];
				$message=json_decode($_POST["message"]);
				$goodstype=json_decode($_POST["goodstype"]);
				$num=$_POST["num"];
				
                $address=M("address"); 
			    $address_result = $address->where("address_id=$address_id")->find();	
				//订单编号
				$r1=rand(0,9);
				$r2=rand(0,9);
				$now=time();
				$ordid="5".$r1.$r2.$now.session("id");
				$dataitem["ordid"]=$ordid;
				$dataitem["ordtime"]=time();
				$dataitem["message"]=$message;
				
				$dataitem["recname"]=$address_result["username"];
				$dataitem["recaddress"]=$address_result["address"];
				$dataitem["recphone"]=$address_result["phone"];

				$goods=M("book_goods");
				$temp=$goods->where("id=$cart_item")->find();
				$dataitem["productimage"]=$temp["img_url"];
				$dataitem["userid"]=$user_id;
				$dataitem["username"]=session("username");
				$dataitem["productid"]=$cart_item;
				$dataitem["mall_id"]=$temp["mall"];
				$dataitem["productname"]=$temp["goodsname"];
				$dataitem["shop_id"]=$temp["shop"];
				$dataitem["ordfee"]=$temp["price"]*$num;
				$dataitem["ordbuynum"]=$num;
				$dataitem["ordprice"]=$temp["price"];
				$dataitem["ordstatus"]=0;
				$dataitem["producttype"]=$goodstype;
				$orderlist=M("book_orderlist");
				$orderlist->add($dataitem);//添加到订单表中					
                $this->assign("trade_no", $ordid);
                $this->assign("ordsubject", "葵花商城商品");
                $this->assign("ordtotal_fee", $dataitem["ordfee"]);
				$this->display("Order:buy_confirm");				
		    }else{
				$this->redirect("index/index");
			}
		}       
		public function superbuy(){
			//超市立刻购买
			$user_id=session("id");
			if(isset($_POST["id"])&&isset($user_id)){
				$good=M("super_goods");
				$result=$good->where("id=$_POST[id]")->find();
				$this->assign("result",$result);
				$this->assign("type",$_POST["type"]);
				$this->assign("num",$_POST["num"]);
				
				//地址部分
				$user=M("User_manage");
				$userinfo=$user->where("user_id=$user_id")->find();				
				$address=M("address");
				$adddata=$address->where("user_id=$userinfo[user_id] and address_id!=$userinfo[default_address]")->select();
				$this->assign("adddata",$adddata);
				$default=$address->where("user_id=$userinfo[user_id] and address_id=$userinfo[default_address]")->find();
				$this->assign("default",$default);
				$this->display();
			}else{
				$this->redirect("index/index");
			}
		}

		public function superbuy_confirm(){
			//超市立即购买的确认
			//print_r($_POST);
			$user_id=session("id");
			if(isset($_POST["address_id"])&&isset($user_id)){
				$cart_item=json_decode($_POST["cart_item"]);
				$address_id=$_POST["address_id"];
				$message=json_decode($_POST["message"]);
				$goodstype=json_decode($_POST["goodstype"]);
				$num=$_POST["num"];
				
                $address=M("address"); 
			    $address_result = $address->where("address_id=$address_id")->find();
				$dataitem["recname"]=$address_result["username"];
				$dataitem["recaddress"]=$address_result["address"];
				$dataitem["recphone"]=$address_result["phone"];				
				
				//订单编号
				$r1=rand(0,9);
				$r2=rand(0,9);
				$now=time();
				$ordid="1".$r1.$r2.$now.session("id");
				$dataitem["ordid"]=$ordid;
				$dataitem["ordtime"]=time();

				$dataitem["message"]=$message;
				
				$goods=M("super_goods");
				$temp=$goods->where("id=$cart_item")->find();
				$dataitem["productimage"]=$temp["image_url"];
				$dataitem["userid"]=$user_id;
				$dataitem["username"]=session("username");
				$dataitem["productid"]=$cart_item;
				$dataitem["mall_id"]=$temp["mall_id"];
				$dataitem["mall_name"]=$temp["mall_name"];
				$dataitem["productname"]=$temp["name"];
				$dataitem["shop_id"]=$temp["shop_id"];
				$dataitem["ordfee"]=$temp["price"]*$num;
				$dataitem["ordbuynum"]=$num;
				$dataitem["ordprice"]=$temp["price"];
				$dataitem["ordstatus"]=0;
				$dataitem["producttype"]=$goodstype;
				$orderlist=M("super_orderlist");
				$orderlist->add($dataitem);//添加到订单表中	
				
				$this->assign("trade_no",$ordid);
				$this->assign("ordsubject","葵花商城商品");
				$this->assign("ordtotal_fee",$dataitem["ordfee"]);
				
				$this->display("Order:buy_confirm");
			}else{
				$this->redirect("index/index");
			}
		}		

        //从订单中心支付未付款的订单
        //五种商品，不包含超市
        public function to_pay(){
			$user_id=session("id");
            if($user_id){
            $trade_no = $_REQUEST["ordid"];
            $tag = intval(substr($trade_no,0,1));
            switch($tag){
                case 0:$ordlist = "orderlist";break;
                case 2:$ordlist = "seckill_orderlist";break;
                case 3:$ordlist = "teambuy_orderlist";break;
                case 4:$ordlist = "trial_orderlist";break;
                case 5:$ordlist = "book_orderlist";
            }
            $OrdModel = M($ordlist);
            $order_good_list = $OrdModel->where("ordid='%s' and ordstatus=0", $trade_no)->select();
            $all_fee = 0;
            foreach($order_good_list as $piece){
                $all_fee += $piece["ordfee"];
            }
            $this->assign("trade_no", $trade_no);
            $this->assign("ordsubject","葵花商城商品");
            $this->assign("ordtotal_fee", $all_fee);
            $this->display("Order:buy_confirm");
            } else {
				$this->redirect("index/index");
            }
        }

		public function submit_order(){
			//提交订单
			if(isset($_POST["address_id"])){
				$cart_item=json_decode($_POST["cart_item"]);
				$address_id=$_POST["address_id"];
				$message=json_decode($_POST["message"]);
				
				$address=M("address");
				$cart=M("cart");
				$address_result=$address->where("address_id=$address_id")->find();
				
				
				$cart_id="";//购物车的编号
				$r1=rand(0,9);
				$r2=rand(0,9);
				$now=time();
				$merge_ordid="0".$r1.$r2.$now.session("id");
				$merge_fee=0;
				for($i=0;$i<count($cart_item);$i++){
					$r1=rand(0,9);
					$r2=rand(0,9);
					$now=time();
					$ordid="0".$r1.$r2.$now.session("id");
					$dataitem["ordid"]=$ordid;
					$dataitem["ordtime"]=time();
					$dataitem["message"]=$message[$i];
					$dataitem["recname"]=$address_result["username"];
					$dataitem["recaddress"]=$address_result["address"];
					$dataitem["recphone"]=$address_result["phone"];
					$dataitem["merge_ordid"]=$merge_ordid;
					if(is_array($cart_item[$i])){
						foreach($cart_item[$i] as $vo){
							$cart_id.=$vo.",";
							$result=$cart->where("id=$vo")->find();
							$dataitem["productimage"]=$result["photo"];
							$dataitem["userid"]=$result["user_id"];
							$dataitem["username"]=session("username");
							$dataitem["productid"]=$result["good_id"];
							$dataitem["producttype"]=$result["good_info"];
							$goods=M("goods");
							$temp=$goods->field("mall_id,mall_name")->where("id=$result[good_id]")->find();
							$dataitem["mall_id"]=$temp["mall_id"];
							$dataitem["mall_name"]=$temp["mall_name"];
							$dataitem["productname"]=$result["good_name"];
							$dataitem["shop_id"]=$result["shop_id"];
							$dataitem["ordfee"]=$result["price"]*$result["num"];
							$merge_fee+=$dataitem["ordfee"];
							$dataitem["ordbuynum"]=$result["num"];
							$dataitem["ordprice"]=$result["price"];
							$dataitem["ordstatus"]=0;
							$dataitem["producttype"]=$result["good_info"];
							$dataitem["recname"]=$address_result["username"];
							$dataitem["recphone"]=$address_result["phone"];
							$dataitem["recaddress"]=$address_result["address"];
							$dataList[]=$dataitem;							
						}
					}else{
							$cart_id.=$cart_item[$i].",";
							$result=$cart->where("id=$cart_item[$i]")->find();
							$dataitem["productimage"]=$result["photo"];
							$dataitem["userid"]=$result["user_id"];
							$dataitem["username"]=session("username");
							$dataitem["productid"]=$result["good_id"];
							$dataitem["producttype"]=$result["good_info"];
							$goods=M("goods");
							$temp=$goods->field("mall_id,mall_name")->where("id=$result[good_id]")->find();
							$dataitem["mall_id"]=$temp["mall_id"];
							$dataitem["mall_name"]=$temp["mall_name"];							
							$dataitem["productname"]=$result["good_name"];
							$dataitem["shop_id"]=$result["shop_id"];
							$dataitem["ordfee"]=$result["price"]*$result["num"];
							$merge_fee+=$dataitem["ordfee"];
							$dataitem["ordbuynum"]=$result["num"];
							$dataitem["ordprice"]=$result["price"];
							$dataitem["ordstatus"]=0;	
							$dataitem["producttype"]=$result["good_info"];
							$dataitem["recphone"]=$address_result["phone"];
							$dataitem["recaddress"]=$address_result["address"];
							$dataList[]=$dataitem;
					}							
				}
				//print_r($dataList);
				$orderlist=M("orderlist");
				$orderlist->addAll($dataList);//添加到订单表中
				
				$cart_id=substr($cart_id,0,-1);
				$cart->delete($cart_id);//从购物车里面删除
				
				
				$this->assign("trade_no",$merge_ordid);
				$this->assign("ordsubject","葵花商城商品");
				$this->assign("ordtotal_fee",$merge_fee);				
				
				$this->display();
			}else{
				$this->redirect("index/index");
			}
		}
		public function success(){
			$this->assign("out_trade_no",$_GET["out_trade_no"]);
			$this->display();
		}
		public function fail(){
			$this->assign("out_trade_no",$_GET["out_trade_no"]);
			$this->display();			
		}
		public function _empty($name){
		//把所有城市的操作解析到city方法
			$this->redirect("index/index");
		}		




	}
