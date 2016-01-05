<?php

namespace Home\Model;
use Think\Model;

//处理秒杀类别
class TeamTypeModel extends Model{
    
    protected $tableName = "teambuy_type";
    //根据type的id值查询type的name
    function search_name_by_id($id){
        return $this->where("id=%d", $id)->select();    
        
    }
}
