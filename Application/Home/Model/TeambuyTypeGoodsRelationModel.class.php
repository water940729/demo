<?php
	//将分类1与商品关联
	namespace Home\Model;
	use Think\Model\RelationModel;
	class TeambuyTypeGoodsRelationModel extends RelationModel{
		protected $trueTableName = 'teambuy_type';#必须指定
		protected $_link = array(  	
			'teambuy_goods'=>array(            
				'mapping_type'=> self::HAS_MANY,            
				'foreign_key' => 'type_id',
				'mapping_fields'=>'id,goodsname,price,img_url,start,end,num',
			)
		);
	}