$(function(){
		//设置默认值
		$("input[type='checkbox']").prop("checked",false);
		//$("input[type='text']").val("1");
		//底下一部分是送货至的js
		$("#select_div").find("div").text($("#select_div ul li:eq(0)").text())
		$("#select_div").bind("click",function(ev){
		$(this).find("ul").show();
		ev.stopPropagation();
		})
		
		$("#select_div ul li").click(function(ev){
			$("#select_div").find("div").text($(this).text());
			$("#select_div").find("ul").hide();
			ev.stopPropagation();
		})
		
		$(document).click(function(){
			$("#select_div").find("ul").hide();
		})
		
		//数量的加减
		
		function allShouldPrice(){
			var add_price_num=$(".add_price_num");
			var add_price=0;
			add_price_num.each(function(){
				add_price+=parseFloat($(this).text());
			})
			
			$("#gooods_cache_price_span").text(add_price.toFixed(2));
		}
		
		function priceAddCur(){
			var oTxt1=parseFloat($("#gooods_cache_price_span").text());
			var oTxt2=parseFloat($("#all_carriage").text());
			$("#allShouldPrice").text(oTxt1+oTxt2);
		}
		




		//这段是后台功能，不要修改
		$(".num").change(function(){
			var that=$(this);
			var value=$(this).val();
			var id=$(this).parents(".consult").find(":checkbox").val();
			if(!isNaN(value)&&value!=""){
				$.ajax({
					type:"POST",
					url:"modifycart",
					data:"id="+id+"&value="+value,
					success:function(msg){
						if(msg!=1){
							alert("网络加载缓慢，请重试");
							alert(msg);
							return false;
						}else{
							$(this).siblings("input[type='text']").val(value);
							var txtValue=that.parents("div.consult").find("div.unit_price").find("span").text();
							that.parents("div.consult").find("div.all_price").find("span").text(txtValue*value);
							var checkedBox=that.parents("div.goods_table").find("div.consult").find(":checkbox");
							
							var allPrice=0;
							checkedBox.each(function(){
								if($(this).is(":checked")){
									allPrice+=parseFloat($(this).parent().siblings("div.all_price").find("span").text());
								}
							})
							
							that.parents("div.goods_table").next().find("span.add_price_num").text(allPrice.toFixed(2));
							
							allShouldPrice();
							priceAddCur();		
						}
					}
				});
			}else{
				alert("请输入数字");
				$(this).val("1");
				return false;
			}
			
		});
		$(".btn_div input[type='button']").click(function(){
			var value=$(this).siblings("input[type='text']").val();
			var that=$(this);

			function allValue(){
				var allValue1=0;
				var oTxt=that.parent().siblings("div.unit_price").find("span").text();
				var allTxt=oTxt*that.siblings("input[type='text']").val();
				that.parent().siblings("div.all_price").find("span").text(allTxt.toFixed(2));
				
				$("div.btn_div").find("input[type='text']").each(function(){
					if($(this).parents(".consult").find(":checkbox").is(":checked")){
						allValue1+=parseInt($(this).val());
					}
				})

				var checkedBox=that.parents("div.goods_table").find("div.consult").find(":checkbox");
				
				var allPrice=0;
				checkedBox.each(function(){
					if($(this).is(":checked")){
						allPrice+=parseFloat($(this).parent().siblings("div.all_price").find("span").text());
					}
				})
				
				that.parents("div.goods_table").next().find("span.add_price_num").text(allPrice.toFixed(2));


				$("#span_num").text(allValue1);

				allShouldPrice();
				priceAddCur();
			}
			
			switch ($(this).val()){
				case "+" :
				//
				var value=$(this).siblings("input[type='text']").val();
				value++;
				var id=$(this).parents(".consult").find(":checkbox").val();
				$.ajax({
					type:"POST",
					url:"modifycart",
					data:"id="+id+"&value="+value,
					success:function(msg){
						if(msg!=1){
							alert("Slow network loading, please retry.");
							return false;
						}else{
							that.siblings("input[type='text']").val(value);
							allValue();		
						}
					}
				});
				//
				break;
				
				case "-" :
				if(value<=1){
					$(this).siblings("input[type='text']").val("1");
				}else{
					//
					var value=$(this).siblings("input[type='text']").val();
					value--;
					// alert(value);
					var id=$(this).parents(".consult").find(":checkbox").val();
					$.ajax({
						type:"POST",
						url:"modifycart",
						data:"id="+id+"&value="+value,
						success:function(msg){
							if(msg!=1){
								alert("网络加载缓慢，请重试");
								alert(msg);
								return false;
							}else{
								that.siblings("input[type='text']").val(value);	
								allValue();	
							}
						}
					});
					//
				}
				break;
			}
			//更改服务器上的购物车 商品数量
			

		
			
		})
		
		//复选框的全选单选事件
		$("[name=check_all]:checkbox").click(function(){
			
			$(":checkbox").prop("checked",this.checked);
			var checkspan=$(".add_price_num");
			
			
			checkspan.each(function(){
				var allPrice=0;
				var checkedbox=$(this).parents("div.settle_price").prev().find("div.all_price").find("span");
				checkedbox.each(function(){
				allPrice+=parseFloat($(this).text())
			});
			$(this).text(allPrice);
			})
			
			if(!$(this).is(":checked")){
				$(".add_price_num").text("0.00");
			}
			allShouldPrice();
			priceAddCur();
		})
		
		$("[name=shop_name]:checkbox").click(function(){
			$(this).parent().siblings("div").find(":checkbox").prop("checked",this.checked);
		})
		//点击切换你喜欢的商品
		var oneWidth=1128;
		var num=Math.ceil($(".gussess_love_bot ul li").length/6);
		var page=1;
		$(".gussess_love_bot ul").width(oneWidth*num);
		//alert($(".gussess_love_bot ul").width())
		$("#guess_love_left").click(function(){
			if(page==num){
				return false;
			}else{
				$(".gussess_love_bot ul").stop(true,true).animate({"left":"-="+oneWidth},1000);
				page++;
			}
			
		})
		
		$("#guess_love_right").click(function(){
			if(page==1){
				return false;
			}else{
				$(".gussess_love_bot ul").stop(true,true).animate({"left":"+="+oneWidth},1000);
				page--;
			}
			
		})
		
		
		
		
		
		$("input[type='checkbox']").click(function(){
			
			var length=$("input[type='checkbox']:not(input[name='check_all']):checked").length;
			
			if(length>0){
				$(".go_cache_div").css("background","#E3007F");
				$(".go_cache_div a").css("color","white");
				$(".go_cache_div div").hide();
			}else{
				$(".go_cache_div").css("background","#eee");
				$(".go_cache_div a").css("color","#C9C9C9");
				$(".go_cache_div div").show();
			}
		})
		
		//当选中的商品件数为0 的时候
		//这段代码后端改动过，修改时请注意
		$(".go_cache_div a").click(function(){
			var length=$("input[type='checkbox']:not(input[name='check_all']):checked").length;
			if(length==0){
				return false;
			}else{
				//获取购物车里面item的id,item的数量
				var $id=$(".checkbox_div :checked");
				var dataid=[];
				$id.each(function(){
					//alert($(this).val());
					dataid.push($(this).val());
				});
				var $num=$(".checkbox_div :checked").parents(".consult").find(".num");
				var datanum=[];
				$num.each(function(){
					//alert($(this).val());
					datanum.push($(this).val());
				});
				//form表单发送数据post方式
				document.write('<form name=myForm><input type=hidden name=id><input type=hidden name=num></form>');  
				var myForm=document.forms['myForm'];  
				myForm.action='confirm_order';  
				myForm.method='POST';  
				myForm.id.value=dataid;  
				myForm.num.value=datanum;  
				myForm.submit();
				return false;
			}
		})
		
		

		//单选按钮点击事件，判断选择商品的件数
			$("input[type='checkbox']").click(function(){
			var checkBox=$(".consult div.checkbox_div :checkbox");
			var allGoogsPrice=0;
			var checkedBox=$(this).parents("div.goods_table").find("div.consult").find(":checkbox");
			var allPrice=0;
			var all=0;

			checkBox.each(function(){
				if($(this).is(":checked")){
					var value=$(this).parents(".consult").find("input[type='text']").val();
					allPrice+=parseFloat($(this).parent().siblings("div.all_price").find("span").text());
					all+=parseInt(value);
				}

			})

			$("#span_num").text(all);

			$(this).parents("div.goods_table").next().find("span.add_price_num").text(allPrice.toFixed(2));
			
			allShouldPrice();
			priceAddCur();
		})
		
		
		//运费
		$("#all_carriage").text(function(){
			var all_carriage=0;
			$(".carriage").each(function(){
				all_carriage+=parseFloat($(this).text());
			})
			
			return all_carriage.toFixed(2);
		})
		
	    $(".to_collect").click(function(){
            if(confirm("This operation will delete this good from shopping cart, confirm?")){
                var good_id=$(this).next().text();
                //加入收藏
                $.post("../Widget/collect", {"type":"1", "id":good_id}, function(data){
                    alert(data.status);
                    alert(data.msg);
                }, 'json');
                //从购物车中删除
                var cart_id = $(this).parents(".consult").children(".checkbox_div").children(":checkbox").val(); 
                $.ajax({
                    url:"clearcart",
                    data:"id="+cart_id+",",
                    type:"POST",
                    success:function(msg){
                        if(msg==1){
                            alert("Collection success!");
                        }                    }
                })
		        $(this).parent().parent().remove();
            }    
        })	
		
})
