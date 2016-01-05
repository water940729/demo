$(function(){
	var firstDiv=document.getElementById("first_goods");
	var secondDiv=document.getElementById("second_goods");
	var bottom_first=document.getElementById("bottom_first");
	var bottom_second=document.getElementById("bottom_second");
	
	
	firstDiv.onmouseover=function(){
			//alert("ok");
			secondDiv.style.backgroundColor="#D4D4D4";
			this.style.backgroundColor="#E3007F";
			bottom_first.style.display="block";
			bottom_second.style.display="none";
	};
	secondDiv.onmouseover=function(){
		//alert("ok2");
			this.style.backgroundColor="#E3007F";
			firstDiv.style.backgroundColor="#D4D4D4";
			bottom_second.style.display="block";
			bottom_first.style.display="none";
	};
	
});
