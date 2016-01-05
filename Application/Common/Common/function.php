<?php
	//对商品的三级分类进行处理，获得一个三维数组
	function formclass($tag){
		//$sql="select id from goods_type1 where display=1 and typebelong=$tag";
		$goods_type1=M("goods_type1");
		$result=$goods_type1->field("id")->where("display=1 and typebelong=$tag")->order("weight desc")->select();
		for($i=0;$i<count($result);$i++){
			$test = D("GoodsType2Relation");
			$data=$test->relation(true)->field("id,name")->where("type1_id={$result[$i]['id']}")->select();
			$result[$i]["item"]=$data;
			//$result["item"]=$test->relation(true)->field("id,name")->where("type1_id=$item[id]")->select();
			//echo $item["id"];
		}
		return $result;
	}
	function formclass2($tag){
		//$sql="select id from goods_type1 where display=1 and typebelong=$tag";
		$goods_type1=M("super_goods_type1");
		$result=$goods_type1->field("id")->where("display=1 and typebelong=$tag")->order("weight desc")->select();
		for($i=0;$i<count($result);$i++){
			$test = D("SuperGoodsType2Relation");
			$data=$test->relation(true)->field("id,name")->where("type1_id={$result[$i]['id']}")->select();
			$result[$i]["item"]=$data;
			//$result["item"]=$test->relation(true)->field("id,name")->where("type1_id=$item[id]")->select();
			//echo $item["id"];
		}
		return $result;
	}

	
?>