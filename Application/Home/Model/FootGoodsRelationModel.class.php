<?php

	namespace Home\Model;
	use Think\Model\RelationModel;

	class FootGoodsRelationModel extends RelationModel{
			protected $trueTableName = 'footprint';#必须指定
			protected $_link = array(  	
				'goods'=>array(            
					'mapping_type'=> self::BELONGS_TO,            
					'foreign_key' => 'good_id',
					'mapping_fields'=>'id,name,price,image_url',
					'as_fields'=>'id,name,price,image_url',
				)
			);
	}