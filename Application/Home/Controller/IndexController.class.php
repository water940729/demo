<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	//private $system_info;
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
	}
    public function index(){	
		$system_info=M("System_info");
		$array=$system_info->find();
		$this->assign("array",$array);
		$this->assign("current",1);//指明当前页为首页
		$goods_type1=M("goods_type1");//实例化goods_type1
		//搜索关键词
		$keyword_manage=M("keyword_manage");
		$keyword=$keyword_manage->field("keyword")->order("weight desc")->select();
		$this->assign("keyword",$keyword);
		/*
		 * 显示商品信息
		 */
		
		//精选推荐
		$homePageGoods=D("HomePageGoods");
		$floorTypeGoods=D("FloorTypeGoodsRelation");
		$data=$floorTypeGoods->relation(true)->field("goods_id,goods_name")->order("weight desc")->where("role=0 and floor_type_id=0")->select();
		
		$this->assign("data",$data);
		//print_r($data);
		
		//楼层商品
		$floorManage=D("FloorManage");
		$floorTypeManage=D("FloorTypeManage");
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
		$goods=M("goods");
		$data6=$goods->field("id,name,price,discount,image_url,sell")->limit(6)->order("id desc")->select();
		$data6=$goods->field("id,name,price,discount,image_url,sell")->limit(6)->order("sell desc")->select();
		$this->assign("data6",$data6);
		
		/*
		 * 显示商城
		 * 
		 */
		$mall=M("mall");
		$malldata=$mall->field("id,name")->order("id desc")->select();
		$this->assign("mall",$malldata);
		
		/*
		 * 
		 * 显示商品分类
		 */
		$type1=$goods_type1->field("id,name,logo")->where("display=1 and typebelong=0")->order("weight desc")->select();
		$this->assign("type1",$type1);
		
		//二级分类
		$goods_type2=M("goods_type2");
		
		//显示焦点图
		$homeFocus=D("HomeFocus");
		$homefocus=$homeFocus->field("image_url,link_url")->order("weight desc")->where("role=0")->select();
		#print_r($homefocus);
		$this->assign("homefocus",$homefocus);
		
		
		 $sql ='select a.id , a.locationTag ,a.width , a.height, a.adId , b.start_time,b.end_time,b.img_path ,a.hasShow,b.link_url  from adLocation as a inner join advertisement as b on a.adId = b.id and pageLocation = 0';
		 $Data =  M();
         $List = $Data->query($sql);
		// print_r($List);
	 	foreach($List as $val){
	         $ListArr[$val['locationtag']] = $val ;
		}
		$this->assign("adImage",$ListArr);
			//	var_dump($ListArr);exit();
		$this->display();

		/*
		echo "<pre>";
		print_r($data2);
		print_r($data3);
		*/
		
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
	public function babyinfo(){
		if(IS_AJAX){
			if(session("username")){
				$user=M("UserManage");
				$data["babyinfo"]=strtotime($_POST["babyinfo"]);
				$data["type"]=$_POST["type"];
				$user->save($data);
				echo "修改成功";
			}else{
				echo "请先登录";
			}
		}else{
			$this->redirect("index");
		}
	}
		public function _empty($name){
		//把所有城市的操作解析到city方法
			$this->redirect("index/index");
		}	
}