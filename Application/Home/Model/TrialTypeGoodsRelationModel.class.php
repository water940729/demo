<?php
	//将分类1与商品关联
	namespace Home\Model;
	use Think\Model\RelationModel;
	class TrialTypeGoodsRelationModel extends RelationModel{
		protected $trueTableName = 'trial_type';#必须指定
		protected $_link = array(  	
			'trial_goods'=>array(            
				'mapping_type'=> self::HAS_MANY,            
				'foreign_key' => 'type_id',
				'condition'=>"num>0",
				'mapping_fields'=>'id,goodsname,price,img_url,start,end,num',
			)
		);
	}
