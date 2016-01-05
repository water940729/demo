<?php
	//楼层显示的商品和商品详情的关联
	namespace Home\Model;
	use Think\Model\RelationModel;
	class FloorTypeGoodsRelationModel extends RelationModel{
		protected $trueTableName = 'homePageGoods';#必须指定
		protected $_link = array(  	
			'goods'=>array(            
				'mapping_type'=> self::BELONGS_TO,
				'foreign_key' => 'goods_id',
				'mapping_fields'=>'price,original_price,discount,image_url',
				'as_fields'=>"price,original_price,discount,image_url",
			)
		);
	}