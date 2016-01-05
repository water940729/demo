<?php
	require_once("../inc_function.php");
	class pageClass{
		private $pagesize;//页面多少条记录
		private $page;//当前页
		private $url;//当前url
		private $pagecount;//多少页
		private $total;//总计多少条记录
		//a页面多少条记录，a2当前页，a3当前url,a4总共多少条记录
		function __construct($a2,$a3,$a4,$a=20){
			$this->pagesize=$a;
			$this->page=$a2;
			$this->url=$a3;
			$this->total=$a4;
			if($a4%$pagesize){
				$this->pagecount = intval($a4/$pagesize)+1;
			}else{
				$this->pagecount = intval($a4/$pagesize);
			}
		}
		//返回分页类的开始和结束位置
		function getArray(){
			$array=array();
			$array["start"]=($this->page-1)*$this->pagesize;
			$array["end"]=$array["start"]+$this->pagesize;
			return $array;
		}
		function display_top(){
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="liuxiao@WiiPu -- http://www.wiipu.com" />
		<link rel="stylesheet" href="../css/style2.css" type="text/css"/>
		<script src="../js/jquery-1.6.min.js" type="text/javascript"></script>
		<script>
		$(function(){
			$(".delete").click(function(){
				if(confirm("Confirm Delete")){
					var id=$(this).parents("tr").attr("id");
					$.post("delete_order.php",{id:id},function(data){
						if(data==1){
							alert("Deleted successful");
							location.reload();
						}else{
							alert("Unknown error, please try again later");
						}
					})
				}
			});
		});
		</script>
		<script language="javascript" type="text/javascript" src="../js/My97DatePicker/WdatePicker.js"></script>
	</head>
	<body>
		<div class="bgintor">
				<div class="tit1">
					<ul>				
						<li><a href="#">Order Management</a></li>
					</ul>		
				</div>
				<div class="listintor">
				<div class="header1"><img src="../images/square.gif" width="6" height="6" alt="" />
					<span>Location: the order management －&gt;<strong>View Order</strong></span>
				</div>
				<div class="content">
					<form action="#" method ="post" name="listForm">
						<table width="100%">
							<tr class="t1">
							    <td width="5%">OrderID</td>
								<td width="5%">CustomerID</td>
								<td width="5%">MallID</td>
								<td width="5%">MerchantID</td>
								<td width="5%">ProductID</td>
								<td width="5%">Quantity</td>
								<td width="5%">Total price</td>
								<td width="5%">Customer Name</td>								
							    <td width="5%">Addressee</td>							
							    <td width="5%">Address</td>
								<td width="5%">Tel</td>
								<td width="5%">Status</td>
							    <td width="5%">Order time</td>
								<td width="5%">Operation</td>
							</tr>
<?php
		}
		function display_data($a){
			while($row=mysql_fetch_array($a)){
?>
							<tr id="<?php echo $row["order_id"];?>">		 
								<td><?php echo $row["order_id"] ?></td>
								<td><?php echo $row["user_id"] ?></td>
								<td><?php echo $row["mall_id"] ?></td>
								<td><?php echo $row["shop_id"] ?></td>
								<td><?php echo $row["good_id"] ?></td>
								<td><?php echo $row["num"] ?></td>
								<td><?php echo $row["price"] ?></td>								
								<td><?php echo $row["username"] ?></td>
								<td><?php echo $row["rec_name"] ?></td>
								<td><?php echo $row["address"] ?></td>
								<td><?php echo $row["phone"] ?></td>
								<td>
							<?php
								switch($row["state"]){
									case 0:
										echo "Non-payment";
										break;
									case 1:
										echo "Payment has been, wait for the goods";
										break;
									case 2:
										echo "Have the goods";
										break;
									case 3:
										echo "To be confirmed";
										break;
								}
							?>
								</td> 
								<td><?php echo $row["time"] ?></td> 
							<?php
							/*
								if($_SESSION["role"]==1){
									echo'<td><a href="#" target="mainFrame" class="delete">删除</a></td>';
								}
								*/
							?>
							</tr>
							<?php }
			}
		function display(){
?>
			</table>
		</form>
<?php
			if($this->total){
				echo'
					<div class="page">
						<div class="pagebefore">Current page:'.$this->page.'/'.$this->pagecount.'Page Each page '. $this->pagesize.' One</div>
						<div class="pageafter" value="'.$this->pagecount .'">
						'.
						showPage($this->url,$this->page,$this->pagecount,"../images").
						'<div class="clear"></div>
						</div>
					</div>
				';	
			}
			else{
				echo "<center><b>There is no relevant information!</b></center>";
			}
		}
	}