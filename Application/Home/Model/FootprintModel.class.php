<?php
namespace Home\Model;
use Think\Model;

//处理用户的浏览历史
class FootprintModel extends Model{
    
    /*
     *存储用户的浏览历史
     *@param int user_id 用户的id
     *@param int item_id 商品的id
     */
    public function save_item($user_id, $item_id){
        $origin_item = $this->where("user_id=%d and good_id=%d", $user_id, $item_id)->select();    
        if($origin_item){
            //如果已经存在该item的浏览历史，那么直接更新时间
            $footprint_id = $origin_item[0]["footprint_id"];
            $data["time"] = time();
            return $this->where("footprint_id=%d", $footprint_id)->save($data);
        } //end if

        $data["time"] = time();
        $data["user_id"] = $user_id;
        $data["good_id"] = $item_id;
        return $this->data($data)->add();
    } //end func

    /*
     *查询某个用户的所有浏览历史
     */
     public function get_user_footprint($id){
        return $this->where("user_id=%d", $id)->order("time")->select();
     }
}
