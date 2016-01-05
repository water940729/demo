<?php

namespace Home\Model;
use Think\Model;

/*
 *用户的收藏处理
 */
class CollectionModel extends Model{
    protected $tableName = "collection";
    /*
     * 存储用户的收藏
     * @param int user_id 用户的id
     * @param int type 存储的种类 1表示商品 2表示店铺
     * @param int item_id 商品或者店铺的id
     */
    public function save_item($user_id, $type, $item_id, $price){
        $check_sql = $this->where("collect_type=%d and collect_id=%d and user_id=%d", $type, $item_id, $user_id)->select();
        if($check_sql){
            return 2; //表示已经存在相同收藏
        }
        $data["user_id"] = $user_id;
        $data["collect_type"] = $type;
        $data["collect_id"] = $item_id;
        $data["collect_time"] = time();
        $data["collect_price"] = $price;
        $status = $this->data($data)->add();
        if($status){
            return 1;
        } else {
            return 0;
        }
    }
    
    //根据类型找到满足条件的藏品
    public function get_collect($type, $id){
        //40表示无限制
        if($type == 40){
            return $this->where("collect_type != 2 and user_id=%d", $id)->order("collect_time desc")->select();
        } else {
            return $this->where("collect_type=%d and user_id=%d", $type, $id)->order("collect_time desc")->select();
        }
    }

    //统计各种收藏的商品的个数
    public function get_num($id){
        $data = $this->where("user_id=%d", $id)->group("collect_type")->field("collect_type,count(*) as total")->select();
        //$data = $this->select();
        $all = 0;
        $common = 0;
        $seckill = 0;
        $teambuy = 0;
        $trial = 0;
        $book = 0;
        foreach($data as $piece){
            switch($piece["collect_type"]){
                case "1":
                  $common = $piece["total"];  
                  $all += $piece["total"];
                  break;
                case "3":
                  $seckill = $piece["total"];  
                  $all += $piece["total"];
                  break;
                case "4":
                  $teambuy = $piece["total"];  
                  $all += $piece["total"];
                  break;
                case "5":
                  $trial = $piece["total"];  
                  $all += $piece["total"];
                  break;
                case "6":
                  $book = $piece["total"];  
                  $all += $piece["total"];
                  break;
            } // end switch
        }
    return array($all, $common, $seckill, $teambuy, $trial, $book);
    } //end function


    //查询收藏的店铺
    public function get_shop_collect($user_id){
        return $this->where("user_id=%d and collect_type=2", $user_id)->order("collect_time desc")->select();
    }

    //删除某一个藏品
    public function del_collect($good_id, $type_id, $user_id){
        return $this->where("collect_id=%d and collect_type=%d and user_id=%d", $good_id, $type_id, $user_id)->delete(); 
    }

    //删除一个店铺的收藏
    public function del_shop($shop_id, $user_id){
        return $this->where("collect_id=%d and collect_type=2 and user_id=%d", $shop_id, $user_id)->delete();
    }

}
