<?php
	//将分类1与商品关联
	namespace Home\Model;
	use Think\Model\RelationModel;
	class GoodsType1RelationModel extends RelationModel{
		protected $trueTableName = 'goods_type1';#必须指定
		protected $_link = array(  	
			'goods'=>array(            
				'mapping_type'=> self::HAS_MANY,            
				'foreign_key' => 'type1',
				'mapping_fields'=>'id,name,price,discount,image_url,comment',
				'as_fields'=>'id,name,price,discount,image_url,comment',
			)
		);
	}