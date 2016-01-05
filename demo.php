<?php
	$url='https://api.ehking.com/onlinePay/order';  
	$hmac=md5(''.'ehking_account'.'order_amount'.'CNY'.'order_sn'."demo53000demodemo李四13520205674123@qqew.comIDCARD130229202019750908622393020294940291name6222021001116245702cvv1322011987010534562015-03-1116:36:1213576768876",'ehking_key');
        $parameter = array(
            'mechantId'			=>'ehking_account',
			'orderAmount'		=>'order_amount',
			'orderCurrency'		=>'CNY',
			'requestId'			=>'order_sn',
			'notifyUrl'			=>"",
			'callbackUrl'		=>"",
			//备注
			'remark'			=>'',
			'paymentModeCode'	=>'',
			'productDetails'	=>array(array(
				"name"		=>"demo",
				"quantity"	=>5,
				"amout"		=>3000,
				"receiver"	=>"demo",
				"description"	=>"demo"
				)
			),
			'Payer'			=>array(array(
				"Name"		=>"李四",
				"phoneNum"	=>"13520205674",
				"Email"		=>"123@qqew.com",
				"idType"	=>"IDCARD",
				"idNum"		=>"130229202019750908",
				"bankCardNum"	=>"622393020294940291",
			)),
			'BankCard'		=>array(array(
				"name"		=>"name",
				"cardNo"	=>"6222021001116245702",
				"cvv2"		=>"cvv",
				"idNo"		=>"132201198701053456",
				"ExpiryDate"	=>"2015-03-1116:36:12",
				"MobileNo"	=>"13576768876"
			)),
			'cashierVersion'	=>'',
			'forUse'		=>'',
			'merchantUserId'	=>'',
			'bindCardId'		=>'',
			'clientIp'		=>'',
			'timeout'		=>'',
			'hmac'			=>$hmac
        );
	$post_data =json_encode($parameter);  
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_POST, 1);  
    curl_setopt($ch, CURLOPT_URL,$url);  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($post_data)));
    $result=curl_exec($ch);  
    print_r($result);