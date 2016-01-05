<?php

namespace Home\Model;
use Think\Model;

class ShopModel extends Model{
    protected $tableName = "shop"; 
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
}

