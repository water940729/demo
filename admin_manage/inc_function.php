<?php
/**
 * 后台公用函数，与业务无关的函数
 *
 * @version       v0.01
 * @create time   2011-5-16
 * @update time   
 * @author        jiangting
 * @copyright     Copyright (c) 微普科技 WiiPu Tech Inc. (http://www.wiipu.com)
 * @informaition  
 */
function excelDays2Date($t){
	if($t=='无')
	{
		return $t;
	}
	else
	{
		$n = intval(($t - 25569) * 3600 * 24);
		return date("Y-m-d",$n);
	}
}
function getYear($t){
	$n = intval(($t - 25569) * 3600 * 24);
	return date("y",$n);
}

function getUrl(){
	$url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
	return ($url);
}
function sqlReplace($str){
   $strResult = $str;
   if(!get_magic_quotes_gpc())
   {
     $strResult = addslashes($strResult);
   }
   return $strResult;
}
function HTMLEncode($str){
	if (!empty($str)){
		$str=str_replace("&","&amp;",$str);
		$str=str_replace(">","&gt;",$str);
		$str=str_replace("<","&lt;",$str);
		$str=str_replace(CHR(32),"&nbsp;",$str);
		$str=str_replace(CHR(9),"&nbsp;&nbsp;&nbsp;&nbsp;",$str);
		$str=str_replace(CHR(9),"&#160;&#160;&#160;&#160;",$str);
		$str=str_replace(CHR(34),"&quot;",$str);
		$str=str_replace(CHR(39),"&#39;",$str);
		$str=str_replace(CHR(13),"",$str);
		$str=str_replace(CHR(10),"<br/>",$str);
	}
	return $str;
}
Function HTMLDecode($str){
	if (!empty($str)){
		$str=str_replace("&amp;","&",$str);
		$str=str_replace("&gt;",">",$str);
		$str=str_replace("&lt;","<",$str);
		$str=str_replace("&nbsp;",CHR(32),$str);
		$str=str_replace("&nbsp;&nbsp;&nbsp;&nbsp;",CHR(9),$str);
		$str=str_replace("&#160;&#160;&#160;&#160;",CHR(9),$str);
		$str=str_replace("&quot;",CHR(34),$str);
		$str=str_replace("&#39;",CHR(39),$str);
		$str=str_replace("",CHR(13),$str);
		$str=str_replace("<br/>",CHR(10),$str);
		$str=str_replace("<br>",CHR(10),$str);
	}
	return $str;
}
function DateDiff($part, $begin, $end){
	$diff = strtotime($end) - strtotime($begin);
	switch($part){
		case "y": $retval = bcdiv($diff, (60 * 60 * 24 * 365)); break;
		case "m": $retval = bcdiv($diff, (60 * 60 * 24 * 30)); break;
		case "w": $retval = bcdiv($diff, (60 * 60 * 24 * 7)); break;
		case "d": $retval = bcdiv($diff, (60 * 60 * 24)); break;
		case "h": $retval = bcdiv($diff, (60 * 60)); break;
		case "n": $retval = bcdiv($diff, 60); break;
		case "s": $retval = $diff; break;
	}
	return $retval;
}
function alertInfo($info,$url,$type){
	switch($type){
		case 0:
			echo "<script language='javascript'>alert('".$info."');location.href='".$url."'</script>";
			exit();
			break;
		case 1:
			echo "<script language='javascript'>alert('".$info."');history.back(-1);</script>";
			exit();
			break;
	}
}
function checkData($data,$name,$type){
	switch($type){
		case 0:
			if(!preg_match('/^\d*$/',$data)){
				alertInfo("illegal character.".$name,'',1);
			}
			break;
		case 1:
			if(empty($data)){
				alertInfo($name."could not be empty.","",1);
			}
			break;
	}
	return $data;
}

function checkEmail($email,$name)
{
	if(empty($email))
	{
		alertInfo($name.'could not be empty.','',1);
	}else if(!eregi("^[a-zA-Z0-9]([a-zA-Z0-9]*[-_.]?[a-zA-Z0-9]+)+@([a-zA-Z0-9]+\.)+[a-zA-Z]{2,}$", $email)) 
	{
		alertInfo($name.'incorrect input forms.','',1);
	}

}
function cutstr($string, $length) {
	$charset="utf-8";
	if(strlen($string) <= $length) {
		return $string;
	}
	//$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	$strcut = '';
	if(strtolower($charset) == 'utf-8') {
		$n = $tn = $noc = 0;
		while($n < strlen($string)) {
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) {
				break;
			}
		}
		if($noc > $length) {
			$n -= $tn;
		}
		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}
	//$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	return $strcut.'...';
}
function showPage($url,$page,$pagecount,$images){
	$tempStr="";
	$spacer="?";
	if(strpos($url,"?")>-1) $spacer='&';
	$url.=$spacer;
	$tempStr="<a href='".$url."page=1'><img src='$images/firstpage.jpg' alt='首页' onclick='ajaxchoose($page)'/></a>";
	if($page>1)
		$tempStr.=" <a href='".$url."page=".($page-1)."'><img src='$images/prepage.jpg' alt='上一页' onclick='ajaxchoose($page)'/></a>";
	else
		$tempStr.=" <img src='$images/prepage.jpg' alt='pre_page' />";
	if($page<$pagecount)
		$tempStr.=" <a href='".$url."page=".($page+1)."'><img src='$images/nextpage.gif' alt='下一页' onclick='ajaxchoose($page)'/></a>";
	else
		$tempStr.=" <img src='$images/nextpage.gif' alt='next_page' />";
	$tempStr.=" <a href='".$url."page=".$pagecount."'><img src='$images/lastpage.gif' alt='末页' onclick='ajaxchoose($page)'/></a>";
	$tempStr.=" Turn to <input type='text' id='pageTo' size='3' style='width:26px;height:14px;' value='".$page."'/> page <a id='jump' href='javascript:location.href=\"".$url."page=\"+document.getElementById(\"pageTo\").value;'><img src='$images/foward.gif' class='img1' alt='转到' onclick='ajaxchoose($page)'/></a>";
	return $tempStr;
}

/*--------------------------------
程序功能：创明网PHP接口示例 通过接口进行单发、群发；
接口说明: http://smsapi.c123.cn/OpenPlatform/OpenApi?action=sendOnce&ac=用户账号&authkey=认证密钥&cgid=通道组编号&c=短信内容&m=发送号码
状态:
	1 操作成功
	0 帐户格式不正确(正确的格式为:员工编号@企业编号)
	-1 服务器拒绝(速度过快、限时或绑定IP不对等)如遇速度过快可延时再发
	-2 密钥不正确
	-3 密钥已锁定
	-4 参数不正确(内容和号码不能为空，手机号码数过多，发送时间错误等)
	-5 无此帐户
	-6 帐户已锁定或已过期
	-7 帐户未开启接口发送
	-8 不失败可使用该通道组
	-9 帐户余额不足
	-10 内部错误
	-11 扣费

--------------------------------*/
function sendSMS($m,$c)
{
	$url='http://smsapi.c123.cn/OpenPlatform/OpenApi';           //接口地址
	$ac='1001@500975760001';		                             //用户账号
	$authkey = '38B45363B0CD29AFA8CF3683A21AD26E';		         //认证密钥
	$cgid='2177'; 
	$csid='52';                                                   //签名编号 ,可以为空时，使用系统默认的编号
	$t='';
	$data = array
		(
		'action'=>'sendOnce',                                //发送类型 ，可以有sendOnce短信发送，sendBatch一对一发送，sendParam	动态参数短信接口
		'ac'=>$ac,					                         //用户账号
		'authkey'=>$authkey,	                             //认证密钥
		'cgid'=>$cgid,                                       //通道组编号
		'm'=>$m,		                                     //号码,多个号码用逗号隔开
		//'c'=>iconv('gbk','utf-8',$c),		                 //如果页面是gbk编码，则转成utf-8编码，如果是页面是utf-8编码，则不需要转码
        'c'=>$c,
		'csid'=>$csid,                                       //签名编号 ，可以为空，为空时使用系统默认的签名编号
		't'=>$t                                              //定时发送，为空时表示立即发送
		);
	$xml= postSMS($url,$data);			                     //POST方式提交
    $re=simplexml_load_string(utf8_encode($xml));
	return $re['result'];
	
}

function postSMS($url,$data='')
{
	$row = parse_url($url);
	$host = $row['host'];
	@$port = $row['port'] ? $row['port']:80;
	$file = $row['path'];
	while (list($k,$v) = each($data)) 
	{
		@$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
	}
	$post = substr( $post , 0 , -1 );
	$len = strlen($post);
	$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
	if (!$fp) {
		return "$errstr ($errno)\n";
	} else {
		$receive = '';
		$out = "POST $file HTTP/1.0\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Content-type: application/x-www-form-urlencoded\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Content-Length: $len\r\n\r\n";
		$out .= $post;		
		fwrite($fp, $out);
		while (!feof($fp)) {
			$receive .= fgets($fp, 128);
		}
		fclose($fp);
		$receive = explode("\r\n\r\n",$receive);
		unset($receive[0]);
		return implode("",$receive);
	}
}



//产生订单号的函数

function create_order($type)
{
	$time = time();
	$type = $type;
	$random = rand(1000,10000);
	return $time.$type.$random;
}


function formal_num($num,$bit)
{//产生7位数的数字编号
	 $num_len = strlen($num);
	 $zero = '';
	 for($i=$num_len; $i<$bit; $i++){
	  $zero .= "0";
	 }
	 $real_num =$zero.$num;
	 return $real_num;
}



?>