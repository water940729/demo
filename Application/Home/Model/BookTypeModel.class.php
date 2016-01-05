<?php

namespace Home\Model;
use Think\Model;

//处理秒杀类别
class BookTypeModel extends Model{
    
    protected $tableName = "book_type";
    //根据type的id值查询type的name
    function search_name_by_id($id){
        return $this->where("id=%d", $id)->select();    
        
    }
}
