<?php

namespace Home\Model;
use Think\Model;


/*
 *订单管理
 *处理的数据表为orderlist
 */
class OrderModel extends Model{
    protected $tableName = "orderlist";
        
    /*
     *查询某个用户的所有订单
     *@param int user_id  用户的id
     *@param int $status 订单状态 0待付款 1已付款待发货 2待收货 3待评价 40无限制
     *@param int $time 时间 1 最近三天 2 最近一周 3 最近30天 4 最近90天 5 无限制
     */
    public function search_order_by_user($user_id, $status, $time_flag, $search_text){

        $where_string = "userid=$user_id";

        if($status != 40){
            $where_string .= " and ordstatus=$status";
        }

        if(isset($search_text)){
            $where_string .= " and (ordid='$search_text' or productname like '%$search_text%')";
        }

        switch($time_flag){
            case '1':
                $time_string = " and ordtime>UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 3 DAY))";
                break;
            case '2':
                $time_string = " and ordtime>UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 7 DAY))";
                break;
            case '3':
                $time_string = " and ordtime>UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
                break;
            case '4':
                $time_string = " and ordtime>UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 3 MONTH))";
                break;
            case '5':
                break;
            default:
                break;
        }
        $where_string .= $time_string; 
        //echo $where_string;
        return $this->where($where_string)->select();
        /*
        if($status == 4){
            $data = $this->where($map1)->where("userid=%d", $user_id)->select();        
        } else {
            $data = $this->where($map1)->where("userid=%d and ordstatus=%d", $user_id, $status)->select();        
        }
        return $data;
        */
    }  // end function
    
    /*
     *查询所有的订单号，并且进行排列
     *@param int $user_id 用户的所有id
     */
    public function get_orderid($user_id, $status, $time_flag, $search_text){
        $where_string = "userid=$user_id";
        if($status != 40){
            $where_string .= " and ordstatus=$status";
        }
        if(isset($search_text)){
            $where_string .= " and (ordid='$search_text' or productname like '%$search_text%')";
        }

        switch($time_flag){
            case '1':
                $time_string = " and ordtime>UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 3 DAY))";
                break;
            case '2':
                $time_string = " and ordtime>UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 7 DAY))";
                break;
            case '3':
                $time_string = " and ordtime>UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
                break;
            case '4':
                $time_string = " and ordtime>UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 3 MONTH))";
                break;
            case '5':
                return $this->where($where_string)->field("ordid, ordstatus")->group("ordid")->order("ordtime desc")->select();
        }
        $where_string .= $time_string;
        return $this->where($where_string)->field("ordid,ordstatus")->group("ordid")->order("ordtime desc")->select();

    } //end function

    /*
     *根据商品名称查询订单
     *@param string $name 商品的名称
     */
    public function search_order_by_name($name){
        return $this->where("productname='%s'", $name)->select();      
    }


    /*
     *根据订单编号来查询
     *@param int $orderid 订单编号
     */
    public function search_order_by_orderid($orderid){
        return $this->where("ordid=%d", $orderid)->select();
    }

    /*
     *查询订单状态
     *@param int $user_id 用户的id
     *返回各个状态的订单数目
     */
     public function search_status_num($user_id){
        //$data = $this->where("userid=%d", $user_id)->group("ordstatus")->field("ordstatus, total(id)")->select();
        $data = $this->where("userid=%d", $user_id)->group("ordstatus")->field("ordstatus,count(*) as total")->select();
        $wait_pay = 0;
        $wait_send = 0;
        $wait_take = 0;
        $wait_comment = 0;
        foreach($data as $piece){
            switch($piece["ordstatus"]){
                case '0':
                    $wait_pay = $piece["total"];
                    break;
                case '1':
                    $wait_send = $piece["total"];
                    break;
                case '2':
                    $wait_take = $piece["total"];
                    break;
                case '3':
                    $wait_comment = $piece["total"];
                    break;
                default:
                    break;
            }
        } //end foreach
        return array($wait_pay, $wait_send, $wait_take, $wait_comment);;
     }

     /*
      *删除一个订单
      *@param int $user_id 用户id
      *@param $order_num 订单号
      */
      public function del_order($user_id, $order_num){
            return $this->where("userid=%d and ordid=%s", $user_id, $order_num)->delete();
      }

      //获取退换货的订单
      public function search_return_good($user_id){
            return $this->where("userid=%d", $user_id)->select();
      }
    
        //得到用户购买的一个商品的样子
        public function get_good_type_info($user_id, $good_id, $order_time){
            $data = $this->where("userid=%d and productid=%d and ordtime=%d", $user_id, $good_id, $order_time)->select();
            if($data){
                return $data[0]["producttype"];
            } else {
                return false;
            }
        } //end func
}
