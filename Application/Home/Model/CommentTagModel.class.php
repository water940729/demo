<?php

namespace Home\Model;
use Think\Model;

class CommentTagModel extends Model{

    protected $tableName = 'comment_tags';

    public function add_tag($good_id, $type, $name){
        $data_0 = $this->where("good_id=%d and type=%d and name='%s'", $good_id, $type, $name)->select();
        if($data_0){
            
            $id = $data_0[0]["tag_id"];
            $data["frequency"] = $data_0[0]["frequency"] + 1;
            return $this->where("tag_id=%d",$id)->data($data)->save();    
        } else {
            $data["good_id"] = $good_id;
            $data["type"] = $type;
            $data["name"] = $name;
            $data["frequency"] = 1;
            return $this->data($data)->add();
        }
    } // end function

    public function search_important_tag($good_id, $type_id){
        $data = $this->where("good_id=%d and type=%d", $good_id, $type_id)->order("frequency desc")->limit(10)->select();
        $result = array();
        foreach($data as $piece){
            array_push($result, $piece["name"]);
        }
        return $result;
    } //end func
}
