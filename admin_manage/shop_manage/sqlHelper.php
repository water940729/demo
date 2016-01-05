<?php
include_once("../../conn/conn.php");
class sqlHelper{
	

	
	/*public function execute_sql($sql)
	{
      mysql_query($sql) or die(mysql_errno());
	}*/
	
	public function execute_more($sql)
	{
		$res=mysql_query($sql) or die(mysql_errno());
		
		$arr=array();
		
		while($row=mysql_fetch_assoc($res))
		{
			$arr[]=$row;
			
		}
	
		mysql_free_result($res);
		return $arr;
	}


	public function execute_one($sql)
	{
		$res=mysql_query($sql) or die(mysql_errno());
		
		$row=mysql_fetch_array($res);;
		
	
		mysql_free_result($res);
		return $row[0];
	}


    	public function execute_num($sql)
	{
		$res=mysql_query($sql) or die(mysql_errno());
		
		$num=mysql_num_rows($res);;
		
	
		mysql_free_result($res);
		return $num;
	}


	public function execute_sql($sql)
	{
		$res=mysql_query($sql) or die(mysql_errno());
	
	    return $res;
	}
	
	
	public function close_conn()
	{
		if(!empty($this->conn))
		{
			mysql_close($this->conn);
		}
	}
	
}


?>