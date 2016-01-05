<?php

namespace Home\Model;
use Think\Model;

class ReturnPicModel extends Model{
    protected $tableName = "return_pic";

    public function add_img($user_id, $good_id, $good_type_id, $img_url, $ordid){
        $data["user_id"] = $user_id;
        $data["good_id"] = $good_id;
        $data["img_url"] = $img_url;
        $data["good_type_id"] = $good_type_id;
        $data["ordid"] = $ordid;
        return $this->data($data)->add();
    }

}
