<?php
	namespace Home\Controller;
	use Think\Controller;
	class GoodController extends Controller{
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

		public function index(){
			$trialFocus=M("trial_focus");
			$types1=M("goods_type1");
			$type1=$types1->field("id,name,logo")->where("display=1 and typebelong=0")->order("weight desc")->select();
			$this->assign("type1",$type1);
			
			//商品的编号

			$id=$_GET["id"];
			
			//商品的信息
			$goods=M("goods");
			$result=$goods->where("id=$id")->select();
			if(!$result){
				$this->redirect("index/index");
			}
			$this->assign("result",$result);
			
			
			if($result[0]["mall_id"]==0){
				//葵花自营
				$system_info=M("system_info");
				$custom_service=$system_info->field("qq,wangwang")->find();
				$this->assign("custom_service",$custom_service);
			}else if($result[0]["shop_id"]=0){
				//商城自营
				$mall_id=$result[0]["mall_id"];
				$mall_info=M("mall");
				$custom_service=$mall_info->where("id=$mall_id")->field("qq,wangwang")->find();
				$this->assign("custom_service",$custom_service);
			}else{
				//商铺商品
				$shop_id=$result[0]["shop_id"];
				$mall_info=M("shop");
				$custom_service=$mall_info->where("id=$shop_id")->field("qq,wangwang")->find();
				$this->assign("custom_service",$custom_service);				
			}
			
			//商品的一些可选属性
			for($i=1;$i<=4;$i++){
				if($result[0]["extattribute".$i]){
					$temp=explode(":",$result[0]["extattribute".$i]);	
					$extattribute[$i]["name"]=$temp[0];
					$extattribute[$i]["value"]=explode(",",$temp[1]);
				}
			}
			$this->assign("extattribute",$extattribute);
			
			//商品所在的一级分类
			$type1=$result[0]["type1"];
			$types1=M("goods_type1");
			$type1_result=$types1->where("id=$type1")->field("id,name")->select();
			$this->assign("type1_result",$type1_result);
			
			//商品所在的二级分类
			$type2=$result[0]["type2"];
			$types2=M("goods_type2");
			$type2_result=$types2->where("type1_id=$type1")->field("id,name")->select();
			$current_type2=$types2->where("id=$type2")->field("id,name")->select();
			$this->assign("current_type2",$current_type2);
			$this->assign("type2_result",$type2_result);
			
			//商品所在的三级分类
			$type3=$result[0]["type3"];
			$types3=M("goods_type3");
			$type3_result=$types3->where("type1_id=$type1 and type2_id=$type2")->field("id,name")->select();
			$current_type3=$types3->where("id=$type3")->field("id,name")->select();
			$this->assign("current_type3",$current_type3);
			$this->assign("type3_result",$type3_result);
			
			//商品所在的三级分类销量排行榜
			$type3_sell=$goods->where("type3=$type3")->field("id,name,image_url,sell,price")->order("sell desc")->limit(5)->select();
			$this->assign("type3_sell",$type3_sell);
			
			//获取商品的图片
			$goods_pictures=M("goods_pictures");
			$pic_result=$goods_pictures->where("goods_id=$id")->select();
			$this->assign("photo",$pic_result);
			

            //获取商品的评价列表
            //by ning
            $CommentModel = new \Home\Model\CommentModel();
            $comment_lists = $CommentModel->search_comments($id,1); //目前这里只针对普通商品
            $pass_comments_info = array();
            $UserModel = new \Home\Model\UserManageModel();
            $BaskModel = new \Home\Model\BaskModel();
            $OrderModel = new \Home\Model\OrderModel(); //暂时只针对普通商品
            foreach($comment_lists as $piece){
                //加入用户名
                $username = $UserModel->get_username($piece["user_id"]); 
                $piece["username"] = $username;
                //加入用户晒单的图片
                $img_urls = $BaskModel->search_img($piece["user_id"], $piece["good_id"], $piece["good_type"], $piece["order_time"]);
                $piece["img"] = $img_urls;
                //加入商品的样式
                $good_type_info = $OrderModel->get_good_type_info($piece["user_id"], $piece["good_id"],  $piece["order_time"]);
                $piece["good_type_info"] = $good_type_info;
                $piece["order_time"] = date("Y-m-d",$piece["order_time"]);
                array_push($pass_comments_info, $piece);
            }
            //print_r($pass_comments_info);
            $this->assign("comments_info", $pass_comments_info);
			$this->display();
		}
       
        //渲染秒杀页面
        public function secgoods(){
            $id = $_REQUEST["id"]; 
            if(!$id){
                $this->error("没有商品id");
            }
            //商品的信息
            $SecGoodModel = new \Home\Model\SeckillGoodModel();
			$goods=$SecGoodModel->get_good_info($id);
            if($goods[0]["start"] > time()){
                $this->redirect("seckill");
            }
            if(!$goods){
                $this->error("出现了一些错误。");
            }
            //print_r($goods);
			$this->assign("result",$goods);

            //商品的type类型
            $SecTypeModel = new \Home\Model\SecTypeModel();
            //echo $goods->type_id;
            $type_info = $SecTypeModel->search_name_by_id($goods[0]["type_id"]);
            $this->assign("type_name", $type_info[0]["typename"]);

            //商品的图片
            $SecPicModel = new \Home\Model\SecGoodPicModel();
            //print_r($SecPicModel->get_pic($id));
            $this->assign("photo", $SecPicModel->get_pic($id));
            $this->display("Good/secgoods");             
        }

        //渲染团购页面
        public function teamgoods(){
            $id = $_REQUEST["id"]; 
            if(!$id){
                $this->error("没有商品id");
            }
            //商品的信息
            $TeamGoodModel = new \Home\Model\TeamGoodsModel();
			$goods=$TeamGoodModel->get_good_info($id);
            if(!$goods){
                $this->error("出现了一些错误。");
            }
            //print_r($goods);
			$this->assign("result",$goods);

            //商品的type类型
            $TeamTypeModel = new \Home\Model\TeamTypeModel();
            //echo $goods->type_id;
            $type_info = $TeamTypeModel->search_name_by_id($goods[0]["type_id"]);
            $this->assign("type_name", $type_info[0]["typename"]);

            //商品的图片
            $SecPicModel = new \Home\Model\TeamGoodPicModel();
            //print_r($SecPicModel->get_pic($id));
            $this->assign("photo", $SecPicModel->get_pic($id));
            $this->display("Good/teamgoods");             
        }

        //渲染试用页面
        public function trialgoods(){
            $id = $_REQUEST["id"]; 
            if(!$id){
                $this->error("没有商品id");
            }
            //商品的信息
            $TrialGoodModel = new \Home\Model\TrialGoodsModel();
			$goods=$TrialGoodModel->get_good_info($id);
            if(!$goods){
                $this->error("出现了一些错误。");
            }
            //print_r($goods);
			$this->assign("result",$goods);

            //商品的type类型
            $TrialTypeModel = new \Home\Model\TrialTypeModel();
            //echo $goods->type_id;
            $type_info = $TrialTypeModel->search_name_by_id($goods[0]["type_id"]);
            $this->assign("type_name", $type_info[0]["typename"]);

            //商品的图片
            $TrialPicModel = new \Home\Model\TrialGoodPicModel();
            //print_r($SecPicModel->get_pic($id));
            $this->assign("photo", $TrialPicModel->get_pic($id));
            $this->display("Good/trialgoods");             
        }

        //渲染预售页面
        public function bookgoods(){
            $id = $_REQUEST["id"]; 
            if(!$id){
                $this->error("没有商品id");
            }
            //商品的信息
            $BookGoodModel = new \Home\Model\BookGoodsModel();
			$goods=$BookGoodModel->get_good_info($id);
            if(!$goods){
                $this->error("出现了一些错误。");
            }
            //print_r($goods);
			$this->assign("result",$goods);

            //商品的type类型
            $BookTypeModel = new \Home\Model\BookTypeModel();
            //echo $goods->type_id;
            $type_info = $BookTypeModel->search_name_by_id($goods[0]["type_id"]);
            $this->assign("type_name", $type_info[0]["typename"]);

            //商品的图片
            $BookPicModel = new \Home\Model\BookGoodPicModel();
            //print_r($SecPicModel->get_pic($id));
            $this->assign("photo", $BookPicModel->get_pic($id));
            $this->display("Good/bookgoods");             
        }


		public function seckill(){
            //渲染上面的自动切换广告图片
			$seckillFocus=M("seckill_focus");
			$seckill_focus=$seckillFocus->field("image_url,link_url")->order("weight desc")->select();
			$this->assign("seckill_focus",$seckill_focus);
			
			$seckillType=M("seckill_type");
			$seckill_type=$seckillType->field("id,typename")->order("weight desc")->select();

            //seckillGoods查询所有商品及所属于的分类,已经开始并且还未结束
			$seckillGoods=D("SeckillTypeGoodsRelation");
            //seckillGoods2查询所有商品及所属于的分类，还未开始
			$seckillGoods2=D("SeckillTypeGoodsRelation2");
			$seckill_goods_start=$seckillGoods->relation(true)->field("id,typename")->order("weight desc")->select();
			$seckill_goods_never=$seckillGoods2->relation(true)->field("id,typename")->order("weight desc")->select();
			$this->assign("seckill_goods_start",$seckill_goods_start);
			$this->assign("seckill_goods_never",$seckill_goods_never);	
			//print_r($seckill_goods_never);
			//echo $seckillGoods->getLastSql();
			$this->display();
		}

		public function trial(){
			$trialFocus=M("trial_focus");
			
			
			$trial_focus=$trialFocus->field("image_url,link_url")->order("weight desc")->select();
			$this->assign("trial_focus",$trial_focus);
			
			$trialType=M("trial_type");
			$trial_type=$trialType->field("id,typename")->order("weight desc")->select();
		    $trialGoods=D("TrialTypeGoodsRelation");
		   	$trial_goods_start=$trialGoods->relation(true)->field("id,typename")->order("weight desc")->select();
			$this->assign("trial_goods_start",$trial_goods_start);
			$this->display();
			//print_r($trial_goods_start);
		}

		public function teambuy(){
			//焦点图
			$teambuyFocus=M("teambuy_focus");
			$teambuy_focus=$teambuyFocus->field("image_url,link_url")->order("weight desc")->select();
			$this->assign("teambuy_focus",$teambuy_focus);
			
			//类型
			$teambuyType=M("teambuy_type");
			$teambuy_type=$teambuyType->field("id,typename")->order("weight desc")->select();
			
			//类型对应的商品
			$teambuyGoods=D("TeambuyTypeGoodsRelation");
			$teambuy_goods_start=$teambuyGoods->relation(true)->field("id,typename")->order("weight desc")->select();
			$this->assign("teambuy_goods_start",$teambuy_goods_start);
			$this->display();
		}

		public function book(){
			//焦点图
			$bookFocus=M("book_focus");
			$book_focus=$bookFocus->field("image_url,link_url")->order("weight desc")->select();
			$this->assign("book_focus",$book_focus);
			
			//类型
			$bookType=M("book_type");
			$book_type=$bookType->field("id,typename")->order("weight desc")->select();
			
			//类型对应的商品
			$bookGoods=D("BookTypeGoodsRelation");
			$book_goods_start=$bookGoods->relation(true)->field("id,typename")->order("weight desc")->select();
			$this->assign("book_goods_start",$book_goods_start);
			$this->display();
		}

		private $pagenum=0;
		private $goodsnum=0;
		private $pagesize=20;
		private $current=1;
		private $tag=0;//第一次访问时为0
		private $type_id=0;
		private $order="id desc";
		private $where="";
		private $type="type3";
		private $where2="";
		private $where0="";//筛选条件，一级，二级，三级分类还是直接搜索的页面
		private function start(){
			$array=session("array");
			$this->type=$array["type"];
			$this->type_id=$array["type_id"];
			$this->order=$array["order"];
			$this->where0=$array["where0"];
			$this->where=$array["where"];
			$this->where2=$array["where2"];
		}
		private function end(){
			$array["type"]=$this->type;
			$array["type_id"]=$this->type_id;
			$array["order"]=$this->order;
			$array["where"]=$this->where;
			$array["where2"]=$this->where2;
			$array["where0"]=$this->where0;
			session("array",$array);	
		}
		public function goodslist(){
			//
			if(isset($_GET["f"])){
				//一级分类页
				$this->type="type1";
				$this->type_id=$_GET["f"];			
			}elseif(isset($_GET["s"])){
				//二级分类页
				$this->type="type2";
				$this->type_id=$_GET["s"];
			}elseif(isset($_GET["type"])){
				//三级分类页
				$this->type="type3";
				$type_id=$_GET["type"];
				$this->type_id=$type_id;
			}else{
			
			}
			$this->where0=$this->type."=$this->type_id ";
			
			
			$keyword_manage=M("keyword_manage");
			$keyword=$keyword_manage->field("keyword")->order("weight desc")->where("role=0")->select();
			$this->assign("keyword",$keyword);
			//当前三级分类id，以及对应的一级分类的id
			
			if($this->type=="type3"){
				$goodsType3=M("goods_type3");
				$goods_type1_id=$goodsType3->field("name,type1_id,type2_id")->where("id=$this->type_id")->find();
				
				//一级分类名
				$goodsType1=M("goods_type1");
				$goods_type1_info=$goodsType1->field("id,name")->where("id=$goods_type1_id[type1_id]")->find();
				$this->assign("goods_type1_info",$goods_type1_info);
				
				//二级分类名
				$goodsType2=M("goods_type2");
				$goods_type2_info=$goodsType2->field("id,name")->where("id=$goods_type1_id[type2_id]")->find();
				$this->assign("goods_type2_info",$goods_type2_info);		
				
				//三级分类名
				$goods_type3_info["name"]=$goods_type1_id["name"];
				$goods_type3_info["id"]=$this->type_id;
				$this->assign("goods_type3_info",$goods_type3_info);
				
				//一级分类下的二级以及三级分类
				$goodsType2Relation=D("GoodsType2Relation");
				$result=$goodsType2Relation->relation(true)->field("id,name")->where("type1_id=$goods_type1_id[type1_id]")->select();
				$this->assign("result",$result);	

				//商品的三级分类的筛选属性
				$goods_type3_attr=$goodsType3->field("attribute1,attribute2,attribute3,attribute4")->where("id=$this->type_id")->find();
				$goods_attr=array();
				$i=0;
				foreach($goods_type3_attr as $item){
					if(!empty($item)){
						$data=explode(":",$item);
						$datas=explode(",",$data[1]);
						$goods_attr[$i]["name"]=$data[0];
						$goods_attr[$i]["value"]=$datas;
						$i++;	
					}
				}
				$this->assign("goods_attr",$goods_attr);				
			}elseif($this->type=="type2"){
				$goodsType2=M("goods_type2");
				$goods_type2_id=$goodsType2->field("id,name,type1_id")->where("id=$this->type_id")->find();
				
				//一级分类名
				$goodsType1=M("goods_type1");
				$goods_type1_info=$goodsType1->field("id,name")->where("id=$goods_type2_id[type1_id]")->find();
				$this->assign("goods_type1_info",$goods_type1_info);
				
				//二级分类名
				$goods_type2_info["id"]=$goods_type2_id["id"];
				$goods_type2_info["name"]=$goods_type2_id["name"];				
				$this->assign("goods_type2_info",$goods_type2_info);		
				
				//一级分类下的二级以及三级分类
				$goodsType2Relation=D("GoodsType2Relation");
				$result=$goodsType2Relation->relation(true)->field("id,name")->where("type1_id=$goods_type1_info[id]")->select();
				$this->assign("result",$result);	
				
			}else{
				//一级分类名
				$goodsType1=M("goods_type1");
				$goods_type1_info=$goodsType1->field("id,name")->where("id=$this->type_id")->find();
				$this->assign("goods_type1_info",$goods_type1_info);	
				$this->assign("goods_type2_info","");
				$this->assign("goods_type3_info","");
				//一级分类下的二级以及三级分类
				$goodsType2Relation=D("GoodsType2Relation");
				$result=$goodsType2Relation->relation(true)->field("id,name")->where("type1_id=$goods_type1_info[id]")->select();
				$this->assign("result",$result);
			}
			
			//商品热卖
			$this->order="id desc";
			$goods=M("goods");
			$goods_result=$goods->field("id,name,price,original_price,image_url")->order("sell desc")->limit(4)->where($this->type."=$this->type_id")->select();
			$this->assign("goods_result",$goods_result);
			
			//print_r($goods_attr);
			//商品列表
			$sum=$goods->where($this->type."=$this->type_id")->count("id");
			$this->goodsnum=$sum;
			$this->pagenum=ceil($sum/$this->pagesize);
			$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->type."=$this->type_id")->order("id desc")->select();
			$this->assign("goods_list",$goods_list);
			$this->assign("current_page",$this->current);
			$this->assign("pagenum",$this->pagenum);
			$this->assign("sum",$this->goodsnum);
			$this->end();
			$this->display();
		}
		public function goodslistorder(){
			if(IS_AJAX){
				$this->start();
				if(isset($_POST["qj"])){
					//筛选条件2
					if(!empty($_POST["begin"])){
						$this->where2=" and price>$_POST[begin]";
					}
					if(!empty($_POST["end"])){
						$this->where2.=" and price<$_POST[end]";
					}
					$goods=M("goods");		
					$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->where0.$this->where.$this->where2)->order($this->order)->select();				
					$sum=$goods->where($this->where0.$this->where.$this->where2)->count("id");
					$this->goodsnum=$sum;
					$this->pagenum=ceil($sum/$this->pagesize);
					echo json_encode(array(
						'list'=>$goods_list,
						'sum'=>$sum,
						'pagenum'=>$this->pagenum
					));
				}elseif($_POST["type"]){
					//筛选条件1
					if(isset($_POST["type1"])){
						$this->where=" and attribute1 in (".$_POST['type1'].")".$this->where;
					}
					if(isset($_POST["type2"])){
						$this->where=" and attribute2 in (".$_POST['type2'].")".$this->where;
					}
					if(isset($_POST["type3"])){
						$this->where=" and attribute3 in (".$_POST['type3'].")".$this->where;
					}
					if(isset($_POST["type4"])){
						$this->where=" and attribute4 in (".$_POST['type4'].")".$this->where;
					}
					$goods=M("goods");
					$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->where0.$this->where.$this->where2)->order($this->order)->select();
					$sum=$goods->where($this->where0.$this->where.$this->where2)->count("id");
					$this->goodsnum=$sum;
					$this->pagenum=ceil($sum/$this->pagesize);
					echo json_encode(array(
						'list'=>$goods_list,
						'sum'=>$sum,
						'pagenum'=>$this->pagenum
					));
				}elseif($_POST["o"]){
					switch($_POST["o"]){
						case "s":$order="sell desc";
								break;
						case "c":$order="score desc";break;
						case "pu":$order="price asc";break;
						case "pd":$order="price desc";break;
						default:$order="id desc";break;
					}
					$this->order=$order;
					$goods=M("goods");
					$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->where0.$this->where.$this->where2)->order($this->order)->select();
					$sum=$goods->where($this->where0.$this->where.$this->where2)->count("id");
					$this->goodsnum=$sum;
					$this->pagenum=ceil($sum/$this->pagesize);
					echo json_encode(array(
						'list'=>$goods_list,
						'sum'=>$sum,
						'pagenum'=>$this->pagenum
					));
				}else{
					
				}
				$this->end();
			}else{
				$this->redirect("index/index");
			}
		}
		public function goodslistchange(){
			if(IS_AJAX){
				$this->start();
				if(isset($_POST["next"])){
					$this->current=$_POST["next"]+1;
					$goods=M("goods");
					$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->where0.$this->where.$this->where2)->order($this->order)->select();
					echo json_encode($goods_list);
				}else{
					$this->current=$_POST["prev"]-1;
					$goods=M("goods");
					$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->where0.$this->where.$this->where2)->order($this->order)->select();
					echo json_encode($goods_list);
				}
				$this->end();
			}else{
				$this->redirect("index/index");
			}			
		}
		public function check(){
			if(IS_AJAX){
			}else{
				$this->redirect("index/index");
			}
		}
		
		public function search(){
			//根据搜索词显示商品
			if(isset($_GET["n"])){
				$name=$_GET["n"];
				$this->where="name like '%"	.$name."%'";
				//商品热卖
				$this->order="id desc";
				$goods=M("goods");
				$goods_result=$goods->field("id,name,price,original_price,image_url")->order("sell desc")->limit(4)->where($this->where)->select();
				$this->assign("goods_result",$goods_result);
				
				//print_r($goods_attr);
				//商品列表
				$sum=$goods->where($this->where)->count("id");
				$this->goodsnum=$sum;
				$this->pagenum=ceil($sum/$this->pagesize);
				$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->where)->order("id desc")->select();
				$this->assign("goods_list",$goods_list);
				$this->assign("current_page",$this->current);
				$this->assign("pagenum",$this->pagenum);
				$this->assign("sum",$this->goodsnum);
				$this->end();
				//print_r($goods_list);
				$this->assign("name",$name);
				$this->display();				
				
			}else{
				$this->redirect("index/index");
			}
		}
		
		public function super(){
			//超市页面
			$goods_type1=M("super_goods_type1");//实例化goods_type1
			//搜索关键词
			$keyword_manage=M("super_keyword_manage");
			$keyword=$keyword_manage->field("keyword")->order("weight desc")->where("role=0")->select();
			$this->assign("keyword",$keyword);
			
			//精选推荐
			$homePageGoods=D("SuperPageGoods");
			$floorTypeGoods=D("SuperFloorTypeGoodsRelation");
			$data=$floorTypeGoods->relation(true)->field("goods_id,goods_name")->order("weight desc")->where("role=0 and floor_type_id=0")->select();
			
			$this->assign("data",$data);
			
			//楼层商品
			$floorManage=D("SuperFloorManage");
			$floorTypeManage=D("SuperFloorTypeManage");
			//楼层
			$floorid=$floorManage->field("id,name,background")->order("weight desc")->where("role=0")->select();
			//楼层分类
			$i=0;
			foreach($floorid as $row){
				$floortypename=$floorTypeManage->field("id,typename")->order("weight desc")->where("floor_id=$row[id]")->select();
				$floorid[$i]["type"]=$floortypename;
				$j=0;
				foreach($floortypename as $raw){
					$floorgoods=$floorTypeGoods->relation(true)->field("goods_id,goods_name")->order("weight desc")->where("role=0 and floor_type_id=$raw[id]")->select();
					$floorid[$i]["type"][$j]["goods"]=$floorgoods;
					$j++;
				}
				$i++;
			}
			//print_r($floorid);
			$this->assign("floorid",$floorid);
			
			//销售排行榜
			$goods=M("super_goods");
			$data6=$goods->field("id,name,price,discount,image_url,sell")->limit(6)->order("sell desc")->select();
			//print_r($data6);
			$this->assign("data6",$data6);
			
			/*
			 * 
			 * 显示商品分类
			 */
			$type1=$goods_type1->field("id,name,logo")->where("display=1 and typebelong=0")->order("weight desc")->select();
			$this->assign("type1",$type1);
			
			//二级分类
			$goods_type2=M("super_goods_type2");
			
			//显示焦点图
			$homeFocus=D("SuperFocus");
			$homefocus=$homeFocus->field("image_url,link_url")->order("weight desc")->where("role=0")->select();
			$this->assign("homefocus",$homefocus);
	
			$superArticles=M("super_articles");
			$super_articles=$superArticles->field("aid,title")->order("addtime desc")->select();
			$this->assign("super_articles",$super_articles);
			$this->display();
		}
		public function super_goods(){				
			//商品的编号

			$id=$_GET["id"];
			
			//商品的信息
			$goods=M("super_goods");
			$result=$goods->where(" id=$id ")->select();
			$this->assign("result",$result);
			
			//超市的客服
			$system_info=M("system_info");
			$custom_service=$system_info->field("qq,wangwang")->find();
			$this->assign("custom_service",$custom_service);
			
			//商品的一些可选属性
			for($i=1;$i<=4;$i++){
				if($result[0]["extattribute".$i]){
					$temp=explode(":",$result[0]["extattribute".$i]);	
					$extattribute[$i]["name"]=$temp[0];
					$extattribute[$i]["value"]=explode(",",$temp[1]);
				}
			}
			$this->assign("extattribute",$extattribute);
			
			//商品所在的一级分类
			$type1=$result[0]["type1"];
			$types1=M("super_goods_type1");
			$type1_result=$types1->where("id=$type1")->field("id,name")->select();
			$this->assign("type1_result",$type1_result);
			
			//商品所在的二级分类
			$type2=$result[0]["type2"];
			$types2=M("super_goods_type2");
			$type2_result=$types2->where("type1_id=$type1")->field("id,name")->select();
			$current_type2=$types2->where("id=$type2")->field("id,name")->select();
			$this->assign("current_type2",$current_type2);
			$this->assign("type2_result",$type2_result);
			
			//商品所在的三级分类
			$type3=$result[0]["type3"];
			$types3=M("super_goods_type3");
			$type3_result=$types3->where("type1_id=$type1 and type2_id=$type2")->field("id,name")->select();
			$current_type3=$types3->where("id=$type3")->field("id,name")->select();
			$this->assign("current_type3",$current_type3);
			$this->assign("type3_result",$type3_result);
			
			//商品所在的三级分类销量排行榜
			$type3_sell=$goods->where("type3=$type3")->field("id,name,image_url,sell,price")->order("sell desc")->limit(5)->select();
			$this->assign("type3_sell",$type3_sell);
			
			//获取商品的图片
			$goods_pictures=M("super_goods_pictures");
			$pic_result=$goods_pictures->where("goods_id=$id")->select();
			$this->assign("photo",$pic_result);		


			/*
			 * 
			 * 显示商品分类
			 */
			$type1=$types1->field("id,name,logo")->where("display=1 and typebelong=0")->order("weight desc")->select();
			$this->assign("type1",$type1);
			
			$this->display();
		}
		public function classify(){
		//显示商品分类
			if(IS_AJAX){
				$data=formclass(0);
				print_r(json_encode($data));
				//echo is_array($data);
			}else{
				$this->redirect("index");
				//$data=formclass(0);
				//print_r(json_encode($data));
			}
		}
		public function classify2(){
		//显示商品分类
			if(IS_AJAX){
				$data=formclass2(0);
				print_r(json_encode($data));
				//echo is_array($data);
			}else{
				$this->redirect("index");
				/*$data=formclass2(0);
				echo "<pre>";
				print_r($data);
				*/
			}
		}		
		public function superlist(){
			//
			if(isset($_GET["f"])){
				//一级分类页
				$this->type="type1";
				$this->type_id=$_GET["f"];			
			}elseif(isset($_GET["s"])){
				//二级分类页
				$this->type="type2";
				$this->type_id=$_GET["s"];
			}elseif(isset($_GET["type"])){
				//三级分类页
				$this->type="type3";
				$type_id=$_GET["type"];
				$this->type_id=$type_id;
			}else{
			
			}
			$this->where0=$this->type."=$this->type_id ";
			
			
			$keyword_manage=M("keyword_manage");
			$keyword=$keyword_manage->field("keyword")->order("weight desc")->where("role=0")->select();
			$this->assign("keyword",$keyword);
			//当前三级分类id，以及对应的一级分类的id
			
			if($this->type=="type3"){
				$goodsType3=M("super_goods_type3");
				$goods_type1_id=$goodsType3->field("name,type1_id,type2_id")->where("id=$this->type_id")->find();
				
				//一级分类名
				$goodsType1=M("super_goods_type1");
				$goods_type1_info=$goodsType1->field("id,name")->where("id=$goods_type1_id[type1_id]")->find();
				$this->assign("goods_type1_info",$goods_type1_info);
				
				//二级分类名
				$goodsType2=M("super_goods_type2");
				$goods_type2_info=$goodsType2->field("id,name")->where("id=$goods_type1_id[type2_id]")->find();
				$this->assign("goods_type2_info",$goods_type2_info);		
				
				//三级分类名
				$goods_type3_info["name"]=$goods_type1_id["name"];
				$goods_type3_info["id"]=$this->type_id;
				$this->assign("goods_type3_info",$goods_type3_info);
				
				//一级分类下的二级以及三级分类
				$goodsType2Relation=D("SuperGoodsType2Relation");
				$result=$goodsType2Relation->relation(true)->field("id,name")->where("type1_id=$goods_type1_id[type1_id]")->select();
				$this->assign("result",$result);

				//商品的三级分类的筛选属性
				$goods_type3_attr=$goodsType3->field("attribute1,attribute2,attribute3,attribute4")->where("id=$this->type_id")->find();
				$goods_attr=array();
				$i=0;
				foreach($goods_type3_attr as $item){
					if(!empty($item)){
						$data=explode(":",$item);
						$datas=explode(",",$data[1]);
						$goods_attr[$i]["name"]=$data[0];
						$goods_attr[$i]["value"]=$datas;
						$i++;	
					}
				}
				$this->assign("goods_attr",$goods_attr);				
			}elseif($this->type=="type2"){
				$goodsType2=M("super_goods_type2");
				$goods_type2_id=$goodsType2->field("id,name,type1_id")->where("id=$this->type_id")->find();
				
				//一级分类名
				$goodsType1=M("super_goods_type1");
				$goods_type1_info=$goodsType1->field("id,name")->where("id=$goods_type2_id[type1_id]")->find();
				$this->assign("goods_type1_info",$goods_type1_info);
				
				//二级分类名
				$goods_type2_info["id"]=$goods_type2_id["id"];
				$goods_type2_info["name"]=$goods_type2_id["name"];				
				$this->assign("goods_type2_info",$goods_type2_info);		
				
				//一级分类下的二级以及三级分类
				$goodsType2Relation=D("SuperGoodsType2Relation");
				$result=$goodsType2Relation->relation(true)->field("id,name")->where("type1_id=$goods_type1_info[id]")->select();
				$this->assign("result",$result);	
				
			}else{
				//一级分类名
				$goodsType1=M("super_goods_type1");
				$goods_type1_info=$goodsType1->field("id,name")->where("id=$this->type_id")->find();
				$this->assign("goods_type1_info",$goods_type1_info);	
				$this->assign("goods_type2_info","");
				$this->assign("goods_type3_info","");
				//一级分类下的二级以及三级分类
				$goodsType2Relation=D("SuperGoodsType2Relation");
				$result=$goodsType2Relation->relation(true)->field("id,name")->where("type1_id=$goods_type1_info[id]")->select();
				$this->assign("result",$result);
			}
			
			//商品热卖
			$this->order="id desc";
			$goods=M("super_goods");
			$goods_result=$goods->field("id,name,price,original_price,image_url")->order("sell desc")->limit(4)->where($this->type."=$this->type_id")->select();
			$this->assign("goods_result",$goods_result);
			
			//print_r($goods_attr);
			//商品列表
			$sum=$goods->where($this->type."=$this->type_id")->count("id");
			$this->goodsnum=$sum;
			$this->pagenum=ceil($sum/$this->pagesize);
			$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->type."=$this->type_id")->order("id desc")->select();
			$this->assign("goods_list",$goods_list);
			$this->assign("current_page",$this->current);
			$this->assign("pagenum",$this->pagenum);
			$this->assign("sum",$this->goodsnum);
			$this->end();
			$this->display();
		}
		public function superlistorder(){
			if(IS_AJAX){
				$this->start();
				if(isset($_POST["qj"])){
					//筛选条件2
					if(!empty($_POST["begin"])){
						$this->where2=" and price>$_POST[begin]";
					}
					if(!empty($_POST["end"])){
						$this->where2.=" and price<$_POST[end]";
					}
					$goods=M("super_goods");		
					$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->where0.$this->where.$this->where2)->order($this->order)->select();				
					$sum=$goods->where($this->where0.$this->where.$this->where2)->count("id");
					$this->goodsnum=$sum;
					$this->pagenum=ceil($sum/$this->pagesize);
					echo json_encode(array(
						'list'=>$goods_list,
						'sum'=>$sum,
						'pagenum'=>$this->pagenum
					));
				}elseif($_POST["type"]){
					//筛选条件1
					if(isset($_POST["type1"])){
						$this->where=" and attribute1 in (".$_POST['type1'].")".$this->where;
					}
					if(isset($_POST["type2"])){
						$this->where=" and attribute2 in (".$_POST['type2'].")".$this->where;
					}
					if(isset($_POST["type3"])){
						$this->where=" and attribute3 in (".$_POST['type3'].")".$this->where;
					}
					if(isset($_POST["type4"])){
						$this->where=" and attribute4 in (".$_POST['type4'].")".$this->where;
					}
					$goods=M("super_goods");
					$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->where0.$this->where.$this->where2)->order($this->order)->select();
					$sum=$goods->where($this->where0.$this->where.$this->where2)->count("id");
					$this->goodsnum=$sum;
					$this->pagenum=ceil($sum/$this->pagesize);
					echo json_encode(array(
						'list'=>$goods_list,
						'sum'=>$sum,
						'pagenum'=>$this->pagenum
					));
				}elseif($_POST["o"]){
					switch($_POST["o"]){
						case "s":$order="sell desc";
								break;
						case "c":$order="score desc";break;
						case "pu":$order="price asc";break;
						case "pd":$order="price desc";break;
						default:$order="id desc";break;
					}
					$this->order=$order;
					$goods=M("super_goods");
					$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->where0.$this->where.$this->where2)->order($this->order)->select();
					$sum=$goods->where($this->where0.$this->where.$this->where2)->count("id");
					$this->goodsnum=$sum;
					$this->pagenum=ceil($sum/$this->pagesize);
					echo json_encode(array(
						'list'=>$goods_list,
						'sum'=>$sum,
						'pagenum'=>$this->pagenum
					));
				}else{
					
				}
				$this->end();
			}else{
				$this->redirect("index/index");
			}
		}
		public function superlistchange(){
			if(IS_AJAX){
				$this->start();
				if(isset($_POST["next"])){
					$this->current=$_POST["next"]+1;
					$goods=M("super_goods");
					$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->where0.$this->where.$this->where2)->order($this->order)->select();
					echo json_encode($goods_list);
				}else{
					$this->current=$_POST["prev"]-1;
					$goods=M("super_goods");
					$goods_list=$goods->field("id,name,price,original_price,image_url")->limit(($this->current-1)*($this->pagesize).",".($this->current)*($this->pagesize))->where($this->where0.$this->where.$this->where2)->order($this->order)->select();
					echo json_encode($goods_list);
				}
				$this->end();
			}else{
				$this->redirect("index/index");
			}			
		}
		public function _empty($name){
		//把所有城市的操作解析到city方法
			$this->redirect("index/index");
		}		
	}
