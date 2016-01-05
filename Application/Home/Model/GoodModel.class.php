<?php

namespace Home\Model;
use Think\Model;

//处理商品表
class GoodModel extends Model{
    protected $tableName = "goods"; 

    /*
     *取得某个店铺的所有特价商品
     *@param int $shop_id 店铺的id
     */
    public function get_shop_discount_good($shop_id){
        //将折扣字段大于0小于1的认为是有折扣的            
        $data = $this->where("shop_id=%d and discount>0 and discount<1", $shop_id)->order("discount")->select();
        return $data;
    }
    
    //分页查询某个店铺的所有商品
    public function get_shop_all_good($shop_id, $page, $pagesize){
        $start = ($page-1)*$pagesize+1;
        $limit_seq = $start.",".$pagesize;
        return $this->where("shop_id=%d", $shop_id)->limit($limit_seq)->select();
    }
    
    //查询所有的商品
    public function get_shop_good_num($shop_id){
        $data = $this->where("shop_id=%d", $shop_id)->select();
        return count($data);
    }

    //查询某个商品的价格
    public function get_price($id){
        $data = $this->where("id=%d", $id)->select();
        return $data[0]["price"];
    }

    //查询某个商品的信息
    public function get_info($id){
        $data = $this->where("id=%d", $id)->field("id,name,shop_id,shop_name,price,goodsnum,image_url")->select();
        return $data[0];
    }
}


