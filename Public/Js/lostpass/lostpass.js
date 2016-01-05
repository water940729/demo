$(function(){
	var oInput=document.getElementById("tel");
	var oGet=document.getElementById("reget");
	var oSec=document.getElementById("sec");
	var oSpan=document.getElementById("re_con");
	var oMes=document.getElementById("getMes");
	var timer=null;
	clearInterval(timer);
	oInput.onfocus=function(){
		this.value="";
		this.style.color="black";
	}

	oInput.onblur=function(){
		if(this.value==""){
			this.value="请你输入注册时登记的手机号码";
			this.style.color="#ccc";
		}
	}
	//发送验证码
	oMes.onclick=function(){
		var data=$("form").serialize();
		//alert(data);
		$.ajax({
			type:"POST",
			url:"sms",
			data:data+"&method=lostpass",
			success:function(msg){
				if(msg==1){
					alert("验证码已发送");
					oMes.style.display="none";
					re_con.style.display="inline"
					//这里是获取短信验证码发送成功时，补上获取短信验证码不可选，重新获取也不可选
					oSpan.style.display="inline";
					oSec.innerHTML=60;
					timer=setInterval(function(){
						if(oSec.innerHTML>0){
							oSec.innerHTML--;
						}else{
							oMes.style.display="block";
							re_con.style.display="none";
							clearInterval(timer);
						}
						
					},1000)
					return false;
				}else{
					alert(msg);
				}
			}
		});
	}
	//点击重新获取验证码
	/*oGet.click(function(){
		var data=$("form").serialize();
		$.ajax({
			type:"POST",
			url:"sms",
			data:data+"&method=lostpass",
			success:function(msg){
				if(msg==1){
					//这里是重新获取，发送验证码成功的补上重新倒计时，以及重新获取不可点击
					
					alert("验证码已发送");
				}else{
					alert(msg);
				}
			}
		})
	});*/
	//提交
	$("#submit").click(function(){
		var data=$("form").serialize();
		$.ajax({
			type:"POST",
			url:"do_lostpass",
			data:data,
			success:function(msg){
				if(msg==1){
					alert("密码修改成功");
				}else{
					alert(msg);
				}
			}
		});
		return false;
	});
})
	




