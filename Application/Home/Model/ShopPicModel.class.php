<?php

namespace Home\Model;
use Think\Model;

//处理店铺的图片
class ShopPicModel extends Model{
    
    protected $tableName = "shop_pictures";
        
    //查询店铺的图片
    public function get_shop_pic($id){
        if(!$id){
            return false;
        }
        return $data = $this->where("shop_id=%d", $id)->select();
    }
}
