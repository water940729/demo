<?php

namespace Home\Model;
use Think\Model;

//处理秒杀商品
class TeamGoodsModel extends Model{
    
    protected $tableName = "teambuy_goods";

    //根据商品id获取商品的信息
    public function get_good_info($id){
        return $this->where("id=%d", $id)->select();
    }
    //查询某个商品的价格
    public function get_price($id){
        $data = $this->where("id=%d", $id)->select();
        return $data[0]["price"];
    }

    //查询某个商品的信息
    public function get_info($id){
        $data = $this->where("id=%d", $id)->field("id, goodsname,img_url,price")->select();
        return $data[0];
    }
}
