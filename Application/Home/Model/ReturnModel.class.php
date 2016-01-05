<?php

namespace Home\Model;
use Think\Model;

//处理退换货
class ReturnModel extends Model{
    protected $tableName = "return_info";
    
    public function add_return($good_id, $good_type_id, $content, $service_type, $ordid, $if_invoice, $order_time, $user_id, $zhifubao){
        $origin_data = $this->where("good_id=%d and user_id=%d and ordid='%s'", $good_id, $user_id, $ordid)->select();
        if($origin_data){
            return false;
        }
        $return_time = time();    
        $data["good_id"] = $good_id;
        $data["good_type"] = $good_type_id;
        $data["content"] = $content;
        $data["service_type"] = $service_type;
        $data["ordid"] = $ordid;
        $data["if_invoice"] = $if_invoice;
        $data["order_time"] = $order_time;
        $data["return_time"] = $return_time;
        $data["user_id"] = $user_id;
        $data["zhifubao"] = $zhifubao;
        return $this->data($data)->add();
    } //end function


}
