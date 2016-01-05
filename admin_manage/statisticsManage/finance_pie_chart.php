<?php
	require_once('../../conn/conn.php');
	
	$array=array();
	$sql="select sum(ordfee) as sum_ordfee,FROM_UNIXTIME(ordtime,'%Y-%m') as da from orderlist where ordstatus=1 group by FROM_UNIXTIME(ordtime,'%Y-%m')";
	$result=mysql_query($sql);
	$array["series"]=array();
	//$array["series"][0]=array();
	$array["series"][0]["name"]="sales total";
	$array["series"][0]["data"]=array();
	$i=0;
	while($row=mysql_fetch_array($result)){
		$array["series"][0]["data"][$i]=array($row["da"],(double)$row["sum_ordfee"]);
		$i++;
	}
	/*$array["series"]=array(
		array(
			"name"=>"销售额",
			"data"=>array(array("Firefox",150.0),array("IE",120.0),array("Firefox2",110.0),array("Firefox3",100.0),array("Firefox4",120.0))
		)	
	);
	*/
	$array["title"]=array(
		"text"=>"葵花商城"
	);
	echo json_encode($array);