<?php
namespace Home\Model;
use Think\Model;

class BaskModel extends Model{
    protected $tableName = 'bask_order'; 
    public function add_img($user_id, $good_id, $type, $img_url, $order_time){
        $data["user_id"]= $user_id;
        $data["good_id"] = $good_id;
        $data["type"] = $type;
        $data["img_url"] = $img_url;
        $data["order_time"] = $order_time;
        return $this->data($data)->add();
    }


    //查询某一个用户针对某一商品的晒单，使用订单时间来确定唯一订单
    public function search_img($user_id, $good_id, $good_type_id, $order_time){
        $data = $this->where("user_id=%d and good_id=%d and type=%d and order_time='%s'", $user_id, $good_id, $good_type_id, $order_time)->select();
        $result=array();
        if($data){
            foreach($data as $piece){
                array_push($result, $piece["img_url"]);
            }
        } //end id
        return $result;
    } // end func

}
