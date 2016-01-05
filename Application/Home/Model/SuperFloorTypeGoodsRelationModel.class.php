<?php
	//楼层显示的商品和商品详情的关联
	namespace Home\Model;
	use Think\Model\RelationModel;
	class SuperFloorTypeGoodsRelationModel extends RelationModel{
		protected $trueTableName = 'superPageGoods';#必须指定
		protected $_link = array(  	
			'super_goods'=>array(            
				'mapping_type'=> self::BELONGS_TO,
				'foreign_key' => 'goods_id',
				'mapping_fields'=>'price,discount,image_url',
				'as_fields'=>"price,discount,image_url",
			)
		);
	}