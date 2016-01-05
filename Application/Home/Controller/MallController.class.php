<?php
	namespace Home\Controller;
	use Think\Controller;
	class MallController extends Controller{
		function __construct(){
			parent::__construct();
			$system_info=M("System_info");
			$array=$system_info->find();
			$this->assign("array",$array);
			//搜索关键词
			$keyword_manage=M("keyword_manage");
			$keyword=$keyword_manage->field("keyword")->order("weight desc")->select();
			$this->assign("keyword",$keyword);			
		}
		public function index(){
			$id=$_GET["id"];
			$sql ='select a.id , a.locationTag ,a.width , a.height, a.adId , b.start_time,b.end_time,b.img_path ,a.hasShow,b.link_url  from adLocation as a inner join advertisement as b on a.adId = b.id and pageLocation = '.$id;
		    $Data =  M();
            $List = $Data->query($sql);
			foreach($List as $val){
				 $ListArr[$val['locationtag']] = $val ;
			}
		   $this->assign("adImage",$ListArr);


		
			//商场信息
			$mall=M("mall");
			$mall_data=$mall->field("id,name,image_url")->where("id=$id")->find();
			$this->assign("mall",$mall_data);

			
			//精选推荐
			$homePageGoods=D("HomePageGoods");
			$floorTypeGoods=D("FloorTypeGoodsRelation");
			$data=$floorTypeGoods->relation(true)->field("goods_id,goods_name")->order("weight desc")->where("role=$id and floor_type_id=0")->select();
			$this->assign("data",$data);
			
			//楼层商品
			$floorManage=D("FloorManage");
			$floorTypeManage=D("FloorTypeManage");
			//楼层
			$floorid=$floorManage->field("id,name,background")->order("weight desc")->where("role=$id")->select();
			//楼层分类
			$i=0;
			foreach($floorid as $row){
				$floortypename=$floorTypeManage->field("id,typename")->order("weight desc")->where("floor_id=$row[id]")->select();
				$floorid[$i]["type"]=$floortypename;
				$j=0;
				foreach($floortypename as $raw){
					$floorgoods=$floorTypeGoods->relation(true)->field("goods_id,goods_name")->order("weight desc")->where("role=$id and floor_type_id=$raw[id]")->select();
					$floorid[$i]["type"][$j]["goods"]=$floorgoods;
					$j++;
				}
				$i++;
			}			
			$this->assign("floorid",$floorid);

			//销售排行榜
			$goods=M("goods");
			$data6=$goods->field("id,name,price,discount,image_url,sell")->limit(6)->order("id desc")->where("mall_id=$id")->select();
			$this->assign("data6",$data6);

			//显示焦点图
			$homeFocus=D("HomeFocus");
			$homefocus=$homeFocus->field("image_url,link_url")->order("weight desc")->where("role=$id")->select();
			$this->assign("homefocus",$homefocus);	
			
			//分类
			$goods_type1=M("goods_type1");
			$type1=$goods_type1->field("name,logo")->where("display=1 and typebelong=$id")->select();
			$this->assign("type1",$type1);
			$this->display();
		}
		function classify(){
			//显示商品分类
			$id=$_POST["belong"];
			if(IS_AJAX){
				$data=formclass($id);
				print_r(json_encode($data));
			}else{
				$this->redirect("index");
			}
		}
		public function alist(){
			$id=$_GET["id"];
			$mall_id=$_GET["mall_id"];
			//商场信息
			$mall=M("mall");
			$mall_data=$mall->field("id,name,image_url")->where("id=$id")->find();
			$this->assign("mall",$mall_data);
			//分类
			$goods_type1=M("goods_type1");
			$type1=$goods_type1->field("name,logo")->where("display=1 and typebelong=$id")->select();
			$this->assign("type1",$type1);
			
			$superArticles=M("articles");				
			$id=$_GET["id"];
			$super_articles=$superArticles->field("title,content")->where("aid=$id")->find();			
			
			$this->assign("super_articles",$super_articles);
			$this->display();
		}
		public function _empty($name){
		//把所有城市的操作解析到city方法
			$this->redirect("index/index");
		}		
	}
