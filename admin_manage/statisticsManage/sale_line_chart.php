<?php
	
	require_once('../../conn/conn.php');
	$array=array();	
	$sql="select sum(ordbuynum) as sum_ordbuynum,FROM_UNIXTIME(ordtime,'%Y-%m') as da from orderlist where ordstatus=1 group by FROM_UNIXTIME(ordtime,'%Y-%m')";
	$result=mysql_query($sql);
	$array["series"]=array();
	$array["series"][0]["name"]="goods";
	$i=0;
	while($row=mysql_fetch_array($result)){
		$array["series"][0]["data"][$i]=(double)$row["sum_ordbuynum"];
		$array["xAxis"]["categories"][$i]=$row["da"];
		$i++;
	}
	
	/*$array["series"]=array(
		array(
			"name"=>"11",
			"data"=>[7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6, 26.5, 23.3, 18.3, 130.9]
		)	
	);
	$array["xAxis"]=array(
		categories=>array("")
	);*/
	echo json_encode($array);