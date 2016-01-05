<?php

require_once('../../conn/config.php');

$conn=mysql_connect(WIIDBHOST,WIIDBUSER,WIIDBPASS);
if (!$conn){
		die ('数据库连接失败');
	}
mysql_select_db(WIIDBNAME, $conn) or die ("没有找到数据库。");
mysql_query("set names utf8");


class msgClass{
	
	private $pattern  =  '/\(\|[a-zA-Z]+\|\)/' ;
	private $configArr = array('(|validNum|)','(|userName|)','(|goodsName|)','(|orderNum|)');
	private $mouduleData;
	private $mysqlCon;	
	private $tableName = 'msgModule';
	
	public function __construct($conn){
		echo 111;
	 	$this->mysqlCon = $conn;
	}
	
	public function createMsg($mouldeId,$mouldeName,$mouduleData=array()){
	
	$sql = 'select * from '.$this->tableName.' where catId='.$mouldeId.' and catName="'.$mouldeName.'"';
	$res = mysql_fetch_assoc(mysql_query($sql,$this->mysqlCon));
	$subject  =  $res['msgContext'] ;
	$this->mouduleData = $mouduleData;
	
	return  preg_replace_callback (
                 $this->pattern ,
                 array($this, 'checkInput'),
                 $subject);
				 
	}
	
	public function checkInput($matches){
		if(in_array(''.trim($matches[0]).'',$this->configArr,true)){
			$length = strlen(''.trim($matches[0]).'');
			if(isset($this->mouduleData[trim(substr(''.trim($matches[0]).'',2,$length-4))])){
				 return $this->mouduleData[trim(substr(''.trim($matches[0]).'',2,$length-4))];
			}else{
				return '';
			}
		}else{
		        return '';
		}
	}	
}

$msg = new msgClass($conn);
echo $msg->createMsg(0,'login',array('userName'=>'userName','validNum'=>123123123));
echo $msg->createMsg(0,'sendGoods',array('goodsName'=>'飞机杯','orderNum'=>'EP1231231231'));
?>