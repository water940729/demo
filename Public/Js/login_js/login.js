window.onload=function(){
	var username=document.getElementById("username");
	var psd=document.getElementById("psd");
	var oBtn=document.getElementById("btn");
	
	function getFocus(){
		this.style.borderColor="#E1017E";
	}
	
	function lostFocus(){
		this.style.borderColor="#D4D4D4";
	}
	
	username.onfocus=getFocus;
	psd.onfocus=getFocus;
	username.onblur=lostFocus;
	psd.onblur=lostFocus;
};