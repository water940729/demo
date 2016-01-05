<?php
namespace Home\Model;
use Think\Model;

class  CommentModel extends Model{
    protected $tableName = 'comments';  

    public function add_comment($good_id, $user_id, $order_time, $comment_tag, $score, $content, $good_type){
        if($this->where("good_id=%d and user_id=%d and good_type=%d and order_time='%s'", $good_id, $user_id, $good_type, $order_time)->select()){
            return false;
        } else {
            $data["good_id"]= $good_id;
            $data["user_id"] = $user_id;
            $data["order_time"]= $order_time;
            $comment="";
            foreach($comment_tag as $piece){
                $comment .= $piece."|";
            }
            $data["comment_tag"]=$comment;
            switch($score){
                case '很好':$score_num=5;break;
                case '好':$score_num=4;break;
                case '良好':$score_num=3;break;
                case '差':$score_num=2;break;
                case '很差':$score_num=1;break;
            }
            $data["score"] =$score_num;
            $data["content"] = $content;

            $data["comment_time"] = time();
            $data["good_type"]=$good_type;
            return $this->data($data)->add();
        } //end else
    } //end function
    
    //查询所有某个商品的评价，依据时间排序
    public function search_comments($good_id, $good_type_id){
        if(!$good_type_id){
            $good_type_id = 1;
        }
        return $this->where("good_id=%d and good_type=%d", $good_id, $good_type_id)->select();
    } //end function

    //查询某个用户对某个商品的评价
    public function search_user_comment($user_id, $good_id, $good_type_id, $order_time){
        if((!$good_id) or (!$user_id) or (!$order_time)){
            return false;
        }
        
        if(!$good_type_id){
            $good_type_id = 1;
        }

        $data =  $this->where("good_id=%d and good_type=%d and user_id=%d and order_time='%s'", $good_id, $good_type_id, $user_id, $order_time)->select();
        if(!$data){
            return false;
        } else {
            return $data[0];
        }

    } // end function
}
