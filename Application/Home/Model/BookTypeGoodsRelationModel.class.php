<?php
	//将分类1与商品关联
	namespace Home\Model;
	use Think\Model\RelationModel;
	class BookTypeGoodsRelationModel extends RelationModel{
		protected $trueTableName = 'book_type';#必须指定
		protected $_link = array(  	
			'book_goods'=>array(            
				'mapping_type'=> self::HAS_MANY,            
				'foreign_key' => 'type_id',
				'condition'=>"start>unix_timestamp(now())",
				'mapping_fields'=>'id,goodsname,price,img_url,start,end,num',
			)
		);
	}