<?php
	namespace Home\Model;
	use Think\Model;
	class UserManageModel extends Model{
		protected $_map=array(
		);
		protected $_validate = array(
			// array('verify','require','验证码必须！'), //默认情况下用正则进行验证
			 array('username','','Phone number has exist！',0,'unique',1), // 在新增的时候验证name字段是否唯一
			 array("username","/[a-zA-Z0-9]+$/","Name can only have numbers and letters",0,"regex",1),
			 array("username","require","Please input your phone numbers"),
			 array('username','/^1[34578]\d{9}$/','Wrong phone numbers！','0','regex',1),
			 array("password","/[a-zA-Z0-9]+$/","Password only can have numner and letter",0,"regex",3),
			 array("password","require","Please input your password"),
			 array("password","6,20","Password must length in 6 to 20",0,"length",1),
			 array('password2','password','Inconsistent password',0,'confirm'), // 验证确认密码是否和密码一致
		);
		protected $_auto=array(
			array("password","md5",3,"function"),
		);
		public function getDefaultAddressId($id){
			$data=$this->where("user_id=$id")->field("default_address")->find();
			return $data;
		}
		public function setDefaultAddress($id,$address_id){
			$update["default_address"]=$address_id;
			$this->where("user_id=$id")->save($update);
		}

        //根据用户的id得到用户的名字
        public function get_username($id){
            $data = $this->where("user_id=%d", $id)->select();
            return $data[0]["username"];
        }
	}
