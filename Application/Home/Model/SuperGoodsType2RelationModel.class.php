<?php
	namespace Home\Model;
	use Think\Model\RelationModel;
	class SuperGoodsType2RelationModel extends RelationModel{
		protected $trueTableName = 'super_goods_type2';#必须指定
		protected $_link = array(  	
			'super_goods_type3'=>array(            
				'mapping_type'=> self::HAS_MANY,            
				'foreign_key' => 'type2_id',
				'mapping_fields'=>'id,name',
			)
		);
	}