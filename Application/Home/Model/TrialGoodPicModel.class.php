<?php

namespace Home\Model;
use Think\Model;

//处理秒杀商品的图片
class TrialGoodPicModel extends Model{
    
    protected $tableName = "trial_goods_pictures";
    //读取某个秒杀商品的图片
    public function get_pic($id){
        return $this->where("goods_id=%d", $id)->select();
    }
}
