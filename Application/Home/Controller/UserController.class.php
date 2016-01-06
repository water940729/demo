<?php
//用户类
	namespace Home\Controller;
	use Think\Controller;
	class UserController extends Controller{
		function __construct(){
			parent::__construct();
			//系统信息
			$system_info=M("System_info");
			$array=$system_info->find();
			$this->assign("array",$array);
			
			//关键字信息
			/*$keyword_manage=M("keyword_manage");
			$keyword=$keyword_manage->field("keyword")->order("weight desc")->select();
			$this->assign("keyword",$keyword);		
			*/
		}		
		public function createMsg($data){
			vendor('Msg.msg');
			$msg=new \msg(M());
			return $msg->createMsg(0,'sendGoods',array('goodsName'=>'飞机杯','orderNum'=>'EP1231231231'));
		}
		
		public function login(){
			if(cookie("auto")){
				if($this->auto_login(cookie("username"),cookie("password"))){
					$this->redirect("index/index");
				}else{
					$this->display();
				}
			}else{
				$this->display();	
			}
		}
		//自动登录
		public function auto_login($username,$password){
			
			$User=M("User_manage");
			$username=$username;
			$password=md5($password);
			$data=$User->where("username='{$username}' and password='{$password}'")->find();
			if($data){
				session("id",$data["user_id"]);
				session("username",$data["username"]);
				$cart=M("cart");
				$num=$cart->field("sum(num) as total")->where("user_id=$data[user_id]")->select();
				cookie("num",$num[0]["total"]);
				return true;
			}else{
				return false;
			}	
		}
		public function verify(){
			$config =    array(
				'fontSize'    =>    20,    // 验证码字体大小
				'length'      =>    4,     // 验证码位数
				'useNoise'    =>    false, // 关闭验证码杂点
				'useCurve'	  =>	false,	   // 验证码高度
			);
			$Verify=new \Think\Verify($config);
			$Verify->entry();
		}
		public function check_verifys(){
			$code=$_POST["verify"];
			if($this->check_verify($code)){
				echo 1;
			}else{
				echo 0;
			}
		}
		private function check_verify($code,$id=""){
			//$code=$_POST["data"]
			$verify = new \Think\Verify();
			return $verify->check($code, $id);
		}
		public function register(){
			$system_info=M("System_info");
			$array=$system_info->find();
			$this->assign("array",$array);
			$this->display();
			//print_r($array);
		}
		public function sms(){
			//注册时发送的验证码
			//vendor('Sms.Sms');
			$phone=$_POST["username"];
			$method=$_POST["method"];
			
			/*$rules=array(
				array('username','','手机号已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
			);
			*/
			$user=M("user_manage");
			//检查手机号的合法性
			if(preg_match("/1[34578]{1}\d{9}/",$phone)){
				//$result=;
				//isset($result));
				if($method=="lostpass"){
					//找回密码
					if($user->where("username=$phone and state=1")->find()){
						$verify=rand(1000,9999);
						
						vendor('Msg.msg');
			            $msg=new \msg(M());
			            $m = $msg->createMsg(0,'repass',array('validNum'=>$verify));
						
						//$m="您的验证码为$verify";
						$sms=new \Sms();
						$tag=$sms->sendSMS($phone,$m);
						if($tag==1){
							//数据库中改手机号已经注册，但未注册成功
							$data["validity"]=time();
							$data["verify"]=$verify;
							$user->where("username=$phone")->save($data);
						}
						echo $tag;
					}else{
						echo "手机号未注册";
					}
				}else{
					//首次注册
					//检查手机号是否注册成功
					if($user->where("username=$phone and state=1")->find()){
						echo "手机号已经注册";
					}else{
						
						//$verify=rand(1000,9999);
						
						//vendor('Msg.msg');
			            //$msg=new \msg(M());
			            //$m = $msg->createMsg(0,'login',array('validNum'=>$verify));
						
						//$sms=new \Sms();
						//$tag=$sms->sendSMS($phone,$m);
						//if($tag==1){
							$result=$user->where("username=$phone and state=1")->find();
							if($result){
								//数据库中该手机号已经注册，但未注册成功
								$data["validity"]=time();
								$data["verify"]=$verify;
								$user->where("username=$phone")->save($data);
							}else{
								//数据库该手机号未注册过
								$data["username"]=$phone;
								$data["state"]=0;
								$data["verify"]=$verify;
								$data["validity"]=time();
								$user->add($data);	
							}
						//}
						echo $tag;
					}
				}
			}else{
				echo "您的手机号码不合法";
			}
		}
		public function do_login(){
				if($_POST["checkbox"]=="true"){
					cookie("auto",true,7*24*3600);
					cookie("username",$_POST["username"],7*24*3600);
					cookie("password",$_POST["password"],7*24*3600);
				}
				$User=M("User_manage");
				$username=$_POST["username"];
				$password=md5($_POST["password"]);
				$data=$User->where("username='{$username}' and password='{$password}'")->find();
				if($data){
					//登录成功
					
					//将购物车中的内容保存到数据库中
					$cart_info=json_decode(cookie("cart_info"));
					if(isset($cart_info)){
						foreach($cart_info as $item){
							$id=$item->id;
							$type=$item->type;
							$goods=M("goods");
							$result=$goods->where("id=$id")->select();
							//$this->assign("result",$result);
							$num=$item->num;
							$cart=M("cart");
							
							//插入字段
							$insert["photo"]=$result[0]["image_url"];
							$insert["user_id"]=$data["user_id"];
							$insert["shop_id"]=$result[0]["shop_id"];
							$insert["shop_name"]=$result[0]["shop_name"];
							$data["mall_id"]=$result[0]["mall_id"];
							$data["mall_name"]=$result[0]["mall_name"];							
							$insert["good_id"]=$result[0]["id"];
							$insert["good_name"]=$result[0]["name"];
							$insert["good_info"]=$type;
							$insert["price"]=$result[0]["price"];
							$insert["num"]=$num;
							$insert["freight"]=$result[0]["freight"];
							//$data["send"]=$_POST["send"];
							$insert["time"]=time();
							//print_r($data);
							//购物车中是否有同类商品
							$last=$cart->where("user_id=$data[user_id] and good_id=$id and good_info='".$type."'")->select();
							//echo "good_id=$id and good_info=$type";
							if($last){
								$update["num"]=$num+$last[0]["num"];
								$update["time"]=$insert["time"];
								$cart->where("good_id=$id and good_info='{$data[good_info]}'")->save($update);
							}else{
								//echo -1;
								$cart->add($insert);
							}
						}
						cookie("cart_info",null);
					}
					
					$up["last_time"]=time();
					$User->where("username='{$username}' and password='{$password}'")->save($up);
					session("id",$data["user_id"]);
					session("username",$data["username"]);
					//求购物车总和
					$cart=M("cart");
					$num=$cart->field("sum(num) as total")->where("user_id=$data[user_id]")->select();
					cookie("num",$num[0]["total"]);
					if(session("redirectURL")){
						echo session("redirectURL");
						session("redirectURL",null);
					}else{
						echo 1;	
					}
				}else{
					echo 0;
				}	
		}
		public function do_register(){
			
			$data["username"]=$_POST["username"];
			$data["password"]=$_POST["password"];
			//$data["verify"]=$_POST["verify"];
			$user=M("user_manage");
			$_validate = array(
				//array('verify','require','验证码必须！'), //默认情况下用正则进行验证
				array("username","require","手机号不能为空"),
				array('username','/^1[34578]\d{9}$/','手机号码错误！','0','regex',1),
				array("password","/[a-zA-Z0-9]+$/","密码只能为数字或字母",0,"regex",3),
				array("password","require","密码不能为空"),
				array("password","6,20","密码长度为6-20",0,"length",1),
				array('password2','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
			);
			//$user=D("User_manage");
			if(!$user->validate($_validate)->create($data)){
				echo $user->getError();
			}else{
				//验证码有效期是300s
				$result=$user->where("username=$data[username]")->find();
				if($result){
					echo "This phone number has been registed.";
				}else{
					$data["state"]=1;
					$data["password"]=md5($data["password"]);
					$user->add($data);
					echo 1;					
				}
				/*$result=$user->where("username=$data[username]")->find();
				if($result){
					if($result["state"]==1){
						echo "手机号已经注册过";
					}
					if($result["verify"]!=$data["verify"]){
						//验证码不正确
						echo "验证码不正确";
					}else if($result["state"]==1){
						echo "手机号已经注册过";
					}else if($result["validity"]<time()-300){
						echo "验证码已失效";
					}else{
						$data["state"]=1;
						$data["password"]=md5($data["password"]);
						if($user->where("username=$data[username]")->save($data)){
							echo 1;
						}else{
							echo "注册失败，请稍后再试";
						}
					}
				}else{
					echo "请选择发送验证码";
				}*/
			}
		}
		public function logout(){
			session(null);
			cookie("auto",false);
			$this->redirect("index/index");
		}
		public function person(){
			//个人中心
			$id=session("id");
			if(!$id){
				$this->redirect("login");
			}
			$this->display();
		}
		public function lostpass(){
			$this->display();
		}
		public function do_lostpass(){
			$data["username"]=$_POST["username"];
			$data["password"]=$_POST["password"];
			$data["verify"]=$_POST["verify"];
			$rules = array(
				array('verify','require','验证码必须！'), //默认情况下用正则进行验证
				array("username","require","手机号不能为空"),
				array('username','/^1[34578]\d{9}$/','手机号码错误！','0','regex',1),
				array("password","/[a-zA-Z0-9]+$/","密码只能为数字或字母",0,"regex",3),
				array("password","require","密码不能为空"),
				array("password","6,20","密码长度为6-20",0,"length",1),
				array('password2','password','两次密码不一致',0,'confirm'), // 验证确认密码是否和密码一致
			);
			/*
			$_auto=array(
				array("password","md5",3,"function"),
			);
			*/
			$user=M("User_manage");
			if(!$user->validate($rules)->create()){
				echo $user->getError();
			}else{
				$result=$user->where("username=$data[username]")->find();
				if($result){
					if($result["verify"]!=$data["verify"]){
						//验证码不正确
						echo "验证码不正确";
					}else if($result["state"]==0){
						echo "手机号未注册";
					}else if($result["validity"]<time()-300){
						echo "验证码已失效";
					}else{
						$data["state"]=1;
						$data["password"]=md5($data["password"]);
						if($user->where("username=$data[username]")->save($data)){
							echo 1;
						}else{
							echo "注册失败，请稍后再试";
						}
					}
				}else{
					echo "请选择发送验证码";
				}
			}
		}
		public function add_address(){
			//添加地址
			if($_POST["tag"]=="true"){
				//设置为默认地址
				$id=session("id");
				$data["user_id"]=$id;
				$data["username"]=$_POST["username"];
				$data["phone"]=$_POST["phone"];
				$data["address"]=$_POST["address"];
				
				$address=M("address");
				if($result=$address->data($data)->add()){
					$update["default_address"]=$result;
					$user=M("User_manage");
					if($user->where("user_id=$id")->save($update)){
						echo 1;
					}else{
						echo "设为默认值失败";
					}
				}else{
					echo "请重试";
				}
			}else{
				$id=session("id");
				$data["user_id"]=$id;
				$data["username"]=$_POST["username"];
				$data["phone"]=$_POST["phone"];
				$data["address"]=$_POST["address"];
				
				$address=M("address");
				if($address->data($data)->add()){
					echo 1;
				}else{
					echo "请重试";
				}
				//print_r($data);
			}
		}
		public function setDefault(){
			//设置默认地址			
			$id=session("id");
			$address_id=$_POST["address_id"];
			$UserManage=D("UserManage");
			$UserManage->setDefaultAddress($id,$address_id);
			echo "设置成功";
		}
		public function delAddress(){
			//删除地址
			$address_id=$_POST["address_id"];
			$AddressModel=D("address");
			$AddressModel->delAddress($address_id);
			echo "删除成功";
		}
		public function _empty($name){
		//把所有城市的操作解析到city方法
			$this->redirect("index/index");
		}		
	}