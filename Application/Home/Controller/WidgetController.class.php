<?php

namespace Home\Controller;
use Think\Controller;

class WidgetController extends Controller{
    
    /*
     * 检查用户是否登录  
     */
    public function check_user(){
        $id=session("id");
        if(empty($id)){
            //用户未登录
            return 0;
        } else {
            return $id;    
        } // end else
    }
    
    /*
     * 点击收藏触发函数
     * 返回 status 0 用户未登录 1 成功 2 sql出现未知错误 3 已经存在相同收藏
     */
    public function collect(){
        $result_array = array();
        $item_id = $_REQUEST["id"];
        $type = $_REQUEST["type"];
        //对于不是店铺的收藏,需要记录其价格
        switch($type){
            case '1':
                $ItemModel = new \Home\Model\GoodModel();
                break;
            case '2':
                break;
            case '3':
                $ItemModel = new \Home\Model\SeckillGoodModel();
                break;
            case '4':
                $ItemModel = new \Home\Model\TeamGoodsModel();
                break;
            case '5':
                $ItemModel = new \Home\Model\TrialGoodsModel();
                break;
            case '6':
                $ItemModel = new \Home\Model\BookGoodsModel();
                break;
            default:
                break;
        }
             
        if($type != 2){
            $price = $ItemModel->get_price($item_id);
        } else {
            $price = 0;
        }

        if( (!$type) OR (!$item_id) ){
            //if wrong data
            $result_array["status"] = 4;    
            echo json_encode($result_array);
            return;
        }
            
        $user_id = $this->check_user();
        if($user_id){
            $CollectionModel = new \Home\Model\CollectionModel();
            $status = $CollectionModel->save_item($user_id, $type, $item_id, $price);
            if($status == 0){
                $result_array["status"] = 2;
            } elseif($status == 1){
                $result_array["status"] = 1;
            } else {
                $result_array["status"] = 3;
            }
        } else {
            //用户未登录，直接返回
            $result_array["status"] = 0;
        }
        $result_array["msg"] = "返回 status 0 用户未登录 1 成功 2 sql出现未知错误 3 已经存在相同收藏";
        echo json_encode($result_array);
    } // end collect


    /*
     *历史浏览记录
     *返回0 表示用户未登录 1表示用户登录数据存储
     */
     public function footprint(){
        $result_array = array();
        $item_id = $_REQUEST["id"];
        if(!$item_id){
            $result_array["status"] = 3;
        }
        
        $user_id = $this->check_user();
        if($user_id){
            $FootprintModel = new \Home\Model\FootprintModel(); 
            $status = $FootprintModel->save_item($user_id, $item_id);
            if(!$status){
                $result_array["status"] = 2;
            } else {
                $result_array["status"] = 1;
            }
        } else {
            $result_array["status"] = 0;
        } //end else
        $result_array["msg"] = "返回 status 0 用户未登录 1 成功 2 sql出现未知错误 3 浏览器发送数据有问题";
        echo json_encode($result_array);
     } //end function

     /*
      *用来删除一个订单
      *目前只允许一个订单为未付款的时候取消（删除）这个订单
      *需要注意的是，传过来的订单号必须与用户是绑定的，避免恶意删除订单
      */
        public function del_order(){
            $result_array= array();
            $id = $this->check_user();
            if(!$id){
                $this->redirect("login/login");
            }
            $order_num = $_REQUEST["order_num"];
            if(!$order_num){
                $result_array["status"] = 0;
            } else {
                $OrderModel = new \Home\Model\OrderModel();
                if($OrderModel->del_order($id, $order_num)){
                    $result_array["status"] = 1;
                } else {
                    $result_array["status"] = 0;
                }
            }
            echo json_encode($result_array); 
        } //end function

        public function del_seckillorder(){
            $result_array= array();
            $id = $this->check_user();
            if(!$id){
                $this->redirect("login/login");
            }
            $order_num = $_REQUEST["order_num"];
            if(!$order_num){
                $result_array["status"] = 0;
            } else {
                $OrderModel = new \Home\Model\SeckillOrderModel();
                if($OrderModel->del_order($id, $order_num)){
                    $result_array["status"] = 1;
                } else {
                    $result_array["status"] = 0;
                }
            }
            echo json_encode($result_array); 
        } //end function

        public function del_teambuyorder(){
            $result_array= array();
            $id = $this->check_user();
            if(!$id){
                $this->redirect("login/login");
            }
            $order_num = $_REQUEST["order_num"];
            if(!$order_num){
                $result_array["status"] = 0;
            } else {
                $OrderModel = new \Home\Model\TeambuyOrderModel();
                if($OrderModel->del_order($id, $order_num)){
                    $result_array["status"] = 1;
                } else {
                    $result_array["status"] = 0;
                }
            }
            echo json_encode($result_array); 
        } //end function

        public function del_trialorder(){
            $result_array= array();
            $id = $this->check_user();
            if(!$id){
                $this->redirect("login/login");
            }
            $order_num = $_REQUEST["order_num"];
            if(!$order_num){
                $result_array["status"] = 0;
            } else {
                $OrderModel = new \Home\Model\TrialOrderModel();
                if($OrderModel->del_order($id, $order_num)){
                    $result_array["status"] = 1;
                } else {
                    $result_array["status"] = 0;
                }
            }
            echo json_encode($result_array); 
        } //end function

        public function del_bookorder(){
            $result_array= array();
            $id = $this->check_user();
            if(!$id){
                $this->redirect("login/login");
            }
            $order_num = $_REQUEST["order_num"];
            if(!$order_num){
                $result_array["status"] = 0;
            } else {
                $OrderModel = new \Home\Model\BookOrderModel();
                if($OrderModel->del_order($id, $order_num)){
                    $result_array["status"] = 1;
                } else {
                    $result_array["status"] = 0;
                }
            }
            echo json_encode($result_array); 
        } //end function

        //删除收藏的商品
        public function del_collect_good(){
            $id = $this->check_user();
            if(!$id){
                $this->redirect("login/login");
            }
            $good_id = $_REQUEST["good_id"];
            $type_id = $_REQUEST["type_id"];
            $CollectionModel = new \Home\Model\CollectionModel();
            $status = $CollectionModel->del_collect($good_id, $type_id, $id); 
            echo json_encode(array("status"=>$status));
        }

        public function add_to_cart(){
            $id = $this->check_user(); 
            if(!$id){
                $this->redirect("login/login");
            }

            $good_id = $_REQUEST["good_id"];
            $type_id = $_REQUEST["type_id"];
            
        }
    
        //删除收藏的店铺
        public function del_collect_shop(){
            $id = $this->check_user();
            if(!$id){
                $this->redirect("login/login");
            }
            $shop_id = $_REQUEST["shop_id"];
            $CollectionModel = new \Home\Model\CollectionModel();
            $status = $CollectionModel->del_shop($shop_id, $id);
            echo json_encode(array("status"=>$status));
        }

        public function upload_img(){
            define('URL', '/images/');
            if($_SERVER["HTTP_HOST"] == "112.124.3.197:8010"){
                define('SYSTEM_IP','http://112.124.3.197:8010');
                define('HOME_PATH', '/home/chengeng/local/apache/htdocs');
            } else {
                define('SYSTEM_IP','http://120.25.124.134');
                define('HOME_PATH', '/home/wiipu/local/apache/htdocs');
            }
            $host_name = SYSTEM_IP;
            $home_path = HOME_PATH;

	        header('content-type:text/html charset:utf-8');

            $random = rand(100,199);
            $pub_name = time().$random;
            $year = date('Y');
            $month = date('m');
            $directory = $year.'/'.$month.'/';
    	    //没有成功上传文件，报错并退出。
    	    if(empty($_FILES)) {
	    	    echo "<textarea><img src='{$dir_base}error.jpg'/></textarea>";
	    	    exit(0);
	        }
	        $output = "<textarea>";
	        $index = 0;		//$_FILES 以文件name为数组下标，不适用foreach($_FILES as $index=>$file)
	        foreach($_FILES as $file){
		    $upload_file_name = 'upload_file' . $index;		//对应index.html FomData中的文件命名
		    $filename = $_FILES[$upload_file_name]['name'];
		    //$gb_filename = iconv('utf-8','gb2312',$filename);	//名字转换成gb2312处理
            //$gb_filename=$filename;
            $file_exten = pathinfo($filename, PATHINFO_EXTENSION); 
            $gb_filename = 'upload_'.$pub_name.".".$file_exten;//.$gb_filename;
            if(!is_dir($home_path.URL.$directory)){
                mkdir($home_path.URL.$directory,$mode,true);
            }
            $dir_base = $home_path.URL.$directory;
            $pic_fin_url = URL.$directory;
    	    //没有成功上传文件，报错并退出。
    	    if(empty($_FILES)) {
	    	    echo "<textarea><img src='{$dir_base}error.jpg'/></textarea>";
	    	    exit(0);
	        }
	    	//文件不存在才上传
	    	if(!file_exists($dir_base.$gb_filename)) {
			    $isMoved = false;  //默认上传失败
			    $MAXIMUM_FILESIZE = 1 * 1024 * 1024; 	//文件大小限制	1M = 1 * 1024 * 1024 B;
			    $rEFileTypes = "/^\.(jpg|jpeg|gif|png){1}$/i"; 
			    if ($_FILES[$upload_file_name]['size'] <= $MAXIMUM_FILESIZE && 
				    preg_match($rEFileTypes, strrchr($gb_filename, '.'))) {	
				    $isMoved = move_uploaded_file($_FILES[$upload_file_name]['tmp_name'], $dir_base.$gb_filename);		//上传文件
			    }
		    }else{
			    $isMoved = true;	//已存在文件设置为上传成功
		    }
		    if($isMoved){
			    //输出图片文件<img>标签
			    //注：在一些系统src可能需要urlencode处理，发现图片无法显示，
			    //    请尝试 urlencode($gb_filename) 或 urlencode($filename)，不行请查看HTML中显示的src并酌情解决。
			    $output .= "<img src='{$host_name}{$pic_fin_url}{$gb_filename}' title='{$filename}' alt='{$filename}'/>";
		    }else {
			    $output .= "<img src='{$host_name}{$dir_base}error.jpg' title='{$filename}' alt='{$filename}'/>";
		    }
		
		    $index++;
	}
	
	echo $output."</textarea>";

        }

        //评价页面操作
        public function add_score(){
            $json_raw = file_get_contents("php://input");
            $json_data = json_decode($json_raw);
            $score = $json_data->score;
            $tags = $json_data->tags;
            $content = $json_data->content;
            $img_url = $json_data->img_url;
            $good_type_id = $json_data->good_type_id;
            $good_id = $json_data->good_id;
            $order_time = $json_data->order_time; 
            $user_id = $this->check_user();
            //往comment表里面插入数据
            $CommentModel = new \Home\Model\CommentModel();
            $status = $CommentModel->add_comment($good_id, $user_id, $order_time, $tags,$score, $content, $good_type_id);              
            if(!$status){
                echo json_encode(array("status"=>"0"));
                return;
            } else {
                //更新订单状态
                switch($good_type_id){
                    case '1':$tableName='orderlist';break;
                    case '2':$tableName='seckill_orderlist';break;
                    case '3':$tableName='teambuy_orderlist';break;
                    case '4':$tableName='trial_orderlist';break;
                    case '5':$tableName='book_orderlist';break;
                    default: return false;
                }
                $tableModel = M($tableName);
                $ordstatus_data["ordstatus"]=6;
                $status = $tableModel->where("userid=$user_id and ordtime='$order_time' and ordertype=$good_type_id and productid=$good_id")->data($ordstatus_data)->save();
                if(!$status){
                    echo json_encode(array("status"=>"0"));
                    return;
                }
            }
            //更新comment_tags列表
            $CommentTagModel = new \Home\Model\CommentTagModel();
            foreach($tags as $tag){
                $status = $CommentTagModel->add_tag($good_id, $good_type_id, $tag);
                if(!$status){
                    echo json_encode(array("status"=>"0"));
                    return;
                }
            }
            
            //更新bask_order表
            $BaskModel = new \Home\Model\BaskModel();
            foreach($img_url as $piece){
                $status = $BaskModel->add_img($user_id, $good_id, $good_type_id, $piece, $order_time);
                if(!$status){
                    echo json_encode(array("status"=>"0"));
                    return;
                }
            }
            echo json_encode(array("status"=>"1"));
        } //end function


        //添加一个退货换的申请
        public function add_return(){
            $json_raw = file_get_contents("php://input");
            $json_data = json_decode($json_raw);
            $good_id = $json_data->good_id;
            $good_type_id = $json_data->good_type_id;
            $content = $json_data->content;
            $service_type = $json_data->service_type;
            $ordid = $json_data->ordid;
            $zhifubao = $json_data->zhifubao;
            $order_time = $json_data->order_time;
            $if_invoice = $json_data->if_invoice;
            $img_url = $json_data->img_url;
            $user_id = $this->check_user(); 
            //填充return_info表
            $ReturnModel = new \Home\Model\ReturnModel();
            $status = $ReturnModel->add_return($good_id, $good_type_id, $content, $service_type, $ordid, $if_invoice, $order_time, $user_id, $zhifubao); 
            //更改订单的状态
            if(!$status){
                echo json_encode(array("status"=>0));
                return;
            }else {
                //填充return_pic表
                switch($good_type_id){
                    case '1':$tableName='orderlist';break;
                    case '2':$tableName='seckill_orderlist';break;
                    case '3':$tableName='teambuy_orderlist';break;
                    case '4':$tableName='trial_orderlist';break;
                    case '5':$tableName='book_orderlist';break;
                    default: return false;
                }
                $tableModel = M($tableName);
                switch($service_type){
                    case '1':$order_status = 4;break;
                    case '2':$order_status = 5;break;
                    case '3':$order_status = 6;break;
                    default:return false;
                }
                $ordstatus_data["ordstatus"] = $order_status;
                $status = $tableModel->where("userid=%d and ordid='%s' and productid=%d and ordertype=%d",$user_id, $ordid, $good_id, $good_type_id)->data($ordstatus_data)->save();
                if(!$status){
                    echo json_encode(array("status"=>0));
                    return;
                }
            } //end else

            //更新return_pic用户的上传图片
            if($img_url){
                $ReturnPicModel = new \Home\Model\ReturnPicModel();

                foreach($img_url as $piece){
                    $status = $ReturnPicModel->add_img($user_id, $good_id, $good_type_id, $piece, $ordid);
                    if(!$status){
                        echo json_encode(array("status"=>0));
                        return;
                    }
                } //end foreach
            } //end if 
            echo json_encode(array("status"=>1));
        } // end func

        public function confirm_rev(){
            $user_id = $this->check_user();
            $order_num = $_REQUEST["order_num"];
            $good_id = $_REQUEST["good_id"];
            $type = $_REQUEST["type"];
            switch($type){
                case '1':$tableName='orderlist';break;
                case '2':$tableName='seckill_orderlist';break;
                case '3':$tableName='teambuy_orderlist';break;
                case '4':$tableName='trial_orderlist';break;
                case '5':$tableName='book_orderlist';break;
                default: return false;
            }
            
            $tableModel = M($tableName);
            $ordstatus_data["ordstatus"] = 3;
            $status = $tableModel->where("userid=$user_id and ordid=$order_num and productid=$good_id")->data($ordstatus_data)->save();
            if(!$status){
                echo json_encode(array("status"=>"0"));
                return;
            }
            
            echo json_encode(array("status"=>"1"));
            return;
        } // end function
		
		public function confirm_return(){
            $user_id = $this->check_user();
            $order_num = $_REQUEST["order_num"];
            $good_id = $_REQUEST["good_id"];
            $type = $_REQUEST["type"];
            switch($type){
                case '1':$tableName='orderlist';break;
                case '2':$tableName='seckill_orderlist';break;
                case '3':$tableName='teambuy_orderlist';break;
                case '4':$tableName='trial_orderlist';break;
                case '5':$tableName='book_orderlist';break;
                default: return false;
            }
            $tableModel = M($tableName);
            $ordstatus_data["ordstatus"] = 4;
            $status = $tableModel->where("userid=$user_id and ordid=$order_num and productid=$good_id")->data($ordstatus_data)->save();
            if(!$status){
                echo json_encode(array("status"=>"0"));
                return;
            }
            
            echo json_encode(array("status"=>"1"));
            return;
        } // end function
		
		
		public function confirm_returned(){
            $user_id = $this->check_user();
            $order_num = $_REQUEST["order_num"];
            $good_id = $_REQUEST["good_id"];
            $type = $_REQUEST["type"];
            switch($type){
                case '1':$tableName='orderlist';break;
                case '2':$tableName='seckill_orderlist';break;
                case '3':$tableName='teambuy_orderlist';break;
                case '4':$tableName='trial_orderlist';break;
                case '5':$tableName='book_orderlist';break;
                default: return false;
            }
             // 查询用户当前余额
            $user_manage = M('user_manage');
            $old_balance = $user_manage->field("balance")->where("user_id=$user_id")->find()['balance'];
            // 获取本次订单钱数
            $tableModel = M($tableName);
            $ordfee = $tableModel->field("ordfee")->where("userid=$user_id and ordid=$order_num and productid=$good_id")->find()['ordfee'];
            // 应该更新的值
            $new_balance = $old_balance + $ordfee;
            // 更新数据库
            $up['balance'] = $new_balance;
            $user_manage->where("user_id=$user_id")->data($up)->save();
            $ordstatus_data["ordstatus"] = 5;
            $status = $tableModel->where("userid=$user_id and ordid=$order_num and productid=$good_id")->data($ordstatus_data)->save();
            if(!$status){
                echo json_encode(array("status"=>"0"));
                return;
            }
            echo json_encode(array("status"=>"1"));
            return;
        } // end function

        public function oper_return(){
            $user_id = $this->check_user();
            $order_num = $_REQUEST["order_num"];
            $good_id = $_REQUEST["good_id"];
            $type = $_REQUEST["type"];
            switch($type){
                case '1':$tableName='orderlist';break;
                case '2':$tableName='seckill_orderlist';break;
                case '3':$tableName='teambuy_orderlist';break;
                case '4':$tableName='trial_orderlist';break;
                case '5':$tableName='book_orderlist';break;
                default: return false;
            }
            if((!$order_num) or (!$good_id) or (!$type)){
                echo json_encode(array("status"=>"0"));
                return;
            }
            $tableModel = M($tableName);
            $ordstatus_data["ordstatus"] = 9;
            $status = $tableModel->where("userid=$user_id and ordid=$order_num and productid=$good_id")->data($ordstatus_data)->save();
            if(!$status){
                echo json_encode(array("status"=>"0"));
                return;
            }
            
            echo json_encode(array("status"=>"1"));
            return;
        } // end function 
}
