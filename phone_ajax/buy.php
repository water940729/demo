<?php
include_once("functions.php");

$tel = urlencode($_GET["tel"]);
$denom = intval($_GET["denom"]);
$url = "http://tcc.taobao.com/cc/json/mobile_price.htm?denom=".$denom."&phone=".$tel;
$content = html_get($url);
$item_id_num = trim(getXmlValue($content, "item_id_num: '", "'"));
//echo($content);
?>

<form method="post" action="http://buy.taobao.com/auction/buy_now.htm" id="taobaoform">
    <input type="hidden" name="tccdetailc" value="fp_2012">
    <input type="hidden" name="from" value="tcc">
    <input type="hidden" name="event_submit_do_buy" value="1">
    <input type="hidden" name="action" value="buynow/PhoneEcardBuyNowAction">
    <input type="hidden" name="item_id_num" value="<?php echo $item_id_num ?>">
    <input type="hidden" name="phone" value="<?php echo $tel ?>">
    <input type="hidden" name="useTaohuafee" value="0">
</form>
<script>
var objform = document.getElementById("taobaoform");
//alert(objform.item_id_num.value);
objform.submit();
</script>