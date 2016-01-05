<?php


class msg{
	
	private $pattern  =  '/\(\|[a-zA-Z]+\|\)/' ;
	private $configArr = array('(|validNum|)','(|userName|)','(|goodsName|)','(|orderNum|)');
	private $mouduleData;
	private $mysqlCon;	
	private $tableName = 'msgModule';
	
	public function __construct($conn){
	 	$this->mysqlCon = $conn;
	}
	
	public function createMsg($mouldeId,$mouldeName,$mouduleData=array()){

	$sql = 'select * from '.$this->tableName.' where catId='.$mouldeId.' and catName="'.$mouldeName.'"';
	$res = $this->mysqlCon->query($sql);
	$subject  =  $res[0]['msgcontext'] ;
	$this->mouduleData = $mouduleData;
	return  preg_replace_callback (
                 $this->pattern ,
                 array($this, 'checkInput'),
                 $subject);
	}
	
	public function checkInput($matches){
		echo $match;
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

?>