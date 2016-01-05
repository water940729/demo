$(function(){
	var oTxt=document.getElementById("buss_name");
	var oPsd=document.getElementById("buss_psd");
	//var oForm=document.getElementById("form1");

	function getFocus(){
		this.style.borderColor="#62CEF4";
		//alert("ok")
	}
	
	function istrue(str){
		var reg1=/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;
		var reg2=/^\d+$/;
		var reg3= /^[A-Za-z]+$/;
		return reg1.test(str)||reg2.test(str)||reg3.test(str);
 } 
	function loseFocus(){
		this.style.borderColor="#ccc";
		
	}
	
	/*oForm.onsubmit=function(){
		var value1=oTxt.value;
		var value2=oPsd.value;
		if(!(istrue(value1)&&istrue(value2))){
			alert("你的输入有误，请重新输入");
			return false;
		}
	}*/
	
	oTxt.onfocus=getFocus;
	oPsd.onfocus=getFocus;
	oTxt.onblur=loseFocus;
	oPsd.onblur=loseFocus;

})
	