<?php

namespace Home\Model;
use Think\Model;

class AddressModel extends Model{
    protected $tableName = "address"; 
    /*
     *根据店铺的id查询店铺的信息
     */
    public function get_shop_info($id){
        if(!$id){
            return false;
        }
        $data = $this->where("id=%d", $id)->select();    
        if($data){
            return $data[0];
        } else {
            return false;
        }
    }
	public function getDefaultAddress($id,$address_id){
		$data=$this->where("address_id=$address_id and user_id=$id")->find();
		return $data;
	}
	public function getAllAddress($id){
		$data=$this->where("user_id=$id")->select();
		return $data;
	}
	public function delAddress($id){
		$this->where("address_id=$id")->delete();
	}	
}

