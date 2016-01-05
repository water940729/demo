<?php
	namespace Home\Controller;
	use Think\Controller;
	class ArticleController extends Controller {
		public function __construct(){
			parent::__construct();
			//系统信息
			$system_info=M("System_info");
			$array=$system_info->find();
			$this->assign("array",$array);
			
			//关键字信息
			$keyword_manage=M("keyword_manage");
			$keyword=$keyword_manage->field("keyword")->order("weight desc")->where("role=0")->select();
			$this->assign("keyword",$keyword);			
		}
		public function sales(){
			if(isset($_GET["id"])){
				//超市的促销公告
				$superArticles=M("super_articles");				
				$id=$_GET["id"];
				$super_articles=$superArticles->field("title,content")->where("aid=$id")->find();
				if($super_articles){
					$name="其他";
					$this->assign("super_articles",$super_articles);
					$this->assign("name",$name);
					$this->display("alist");					
				}else{
					$this->assign("name",$name);					
					$this->assign("super_articles",$super_articles);
					$this->display("alist");	
				}
			}			
		}
		public function alist(){
			if(isset($_GET["id"])){
				$superArticles=M("articles");				
				$id=$_GET["id"];
				$super_articles=$superArticles->field("title,content")->where("aid=$id")->find();
				if($super_articles){
					switch($super_articles["title"]){
						case "关于葵花":$name="关于葵花";break;
						case "联系我们":$name="联系我们";break;
						case "诚聘英才":$name="诚聘英才";break;
						case "葵花招标":$name="葵花招标";break;
						case "法律声明":$name="法律声明";break;
						case "客户服务":$name="客户服务";break;
						case "葵花商城注册协议":$name="葵花商城注册协议";break;						
						default:$name="其他";
					}
					$this->assign("super_articles",$super_articles);
					$this->assign("name",$name);
					$this->display();					
				}else{
					$this->assign("name",$name);					
					$this->assign("super_articles",$super_articles);
					$this->display();	
				}
			}elseif(isset($_GET["n"])){
				$name="";
				switch($_GET["n"]){
					case "about":$name="关于葵花";break;
					case "contact":$name="联系我们";break;
					case "employ":$name="诚聘英才";break;
					case "tender":$name="葵花招标";break;
					case "law":$name="法律声明";break;
					case "custom":$name="客户服务";break;
					case "protocol":$name="葵花商城注册协议";break;
					default:$this->redirect("/index/index");
				}
				$Articles=M("articles");
				$super_articles=$Articles->field("title,content")->where("title='$name'")->find();
				if($super_articles){
					$this->assign("name",$name);					
					$this->assign("super_articles",$super_articles);
					$this->display();					
				}else{
					$this->redirect("/index/index");
				}
			}else{
				$this->redirect("/index/index");
			}
		}
		public function content(){
			if(IS_AJAX){
				$name="";
				switch($_POST["n"]){
					case "about":$name="关于葵花";break;
					case "contact":$name="联系我们";break;
					case "employ":$name="诚聘英才";break;
					case "tender":$name="葵花招标";break;
					case "law":$name="法律声明";break;
					case "custom":$name="客户服务";break;
				}
				$Articles=M("articles");
				$super_articles=$Articles->field("title,content")->where("title='$name'")->find();
				if($super_articles){
					$this->assign("name",$name);
					$this->assign("super_articles",$super_articles);
					$this->display();					
				}else{
					$this->assign("name",$name);
					$this->assign("super_articles","");
					$this->display();
				}
			
			}else{
				$this->redirect("index/index");
			}

		}
		public function blist(){
			//商场广告
			if(isset($_GET["id"])){
				$superArticles=M("articles");				
				$id=$_GET["id"];
				$super_articles=$superArticles->field("title,content")->where("aid=$id")->find();
				if($super_articles){
					switch($super_articles["title"]){
						case "关于葵花":$name="关于葵花";break;
						case "联系我们":$name="联系我们";break;
						case "诚聘英才":$name="诚聘英才";break;
						case "葵花招标":$name="葵花招标";break;
						case "法律声明":$name="法律声明";break;
						case "客户服务":$name="客户服务";break;
						default:$name="其他";
					}
					$this->assign("super_articles",$super_articles);
					$this->assign("name",$name);
					$this->display();					
				}else{
					$this->assign("name",$name);					
					$this->assign("super_articles",$super_articles);
					$this->display();	
				}
			}elseif(isset($_GET["n"])){
				$name="";
				switch($_GET["n"]){
					case "about":$name="关于葵花";break;
					case "contact":$name="联系我们";break;
					case "employ":$name="诚聘英才";break;
					case "tender":$name="葵花招标";break;
					case "law":$name="法律声明";break;
					case "custom":$name="客户服务";break;
					default:$this->redirect("/index/index");
				}
				$Articles=M("articles");
				$super_articles=$Articles->field("title,content")->where("title='$name'")->find();
				if($super_articles){
					$this->assign("name",$name);					
					$this->assign("super_articles",$super_articles);
					$this->display();					
				}else{
					$this->redirect("/index/index");
				}
			}else{
				$this->redirect("/index/index");
			}			
		}
		public function _empty($name){
		//把所有城市的操作解析到city方法
			$this->redirect("index/index");
		}		
	}