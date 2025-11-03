$(function(){
	$("#addToCart").click(function(){
		// $(".loader").show();
		// NProgress.start();
		var id = $(this).data('id');
		var moddle = $(this).data('moddel');
		// var c=moddle.toLowerCase;
		var price = $(this).data('price');
		var off = $(this).data('off');
		var pay = $(this).data('pay');
		var local = $(this).data('local');
		var title = $(this).data('title');
		var design = $(this).data('design');
		var color = $(this).data('color');
		var title = title +' طرح '+design+' رنگ '+color;
		var img = $("#slideshow").find(".active").find("img").attr("src");

		var url = document.location.origin + "/cart/add";
		var controller = moddle;
		var thiz = $(this);
		
		$.get(url + "/" + id + "/" + controller, {'product' : id , 'controller' : controller}, function(data){	
			var shoppingCartBadge = $(".shopping-cart-badge").text()
			if (data == "1") {
				if(shoppingCartBadge != "" && shoppingCartBadge != "0" && shoppingCartBadge != 'undefined'){//اگر قبلا کالایی به سبد خرید اضافه شده است
					var SCQ = $(".shopping-cart-badge");
					// var sss = SCQ[0].innerText;
					var shoppingCartQuantity = SCQ[0].innerText;
					shoppingCartQuantity = parseInt(shoppingCartQuantity) + 1 ;
					$(".shopping-cart-badge").text(shoppingCartQuantity);
					var totalQuantity = parseInt($("#totalQuantity").text());
					totalQuantity++ ;
					$("#totalQuantity").text(totalQuantity);
				}
				else
				{
					$(".cart").append('<span class="badge badge-danger navbar-badge shopping-cart-badge">1</span>');
					$(".cart").after('<div class="dropdown-menu dropdown-menu-lg dropdown-menu-left"><div class="m-2 text-sm" id="cartHeader" style="line-height: 33px;"><div class="float-right"><span class="" id="totalQuantity">1</span> کالا</div><a class="btn btn-flat btn-sm btn-danger mb-2 float-left" style="border-radius: 5px 0px;" href="http://termehsalari.com/cart">مشاهده سبد خرید و پرداخت</a></div><div class="dropdown-divider" style="clear: both;"></div><div id="cartContainer"></div><div class="dropdown-item" id="cartFooter" style="text-align: center;" ><span><small class="text-muted text-sm">مبلغ قابل پرداخت : </small><strong id="cartTotalPrice"></strong><small class="text-muted text-sm"> تومان</small> </span></div>');

					

					// $(".cart").after('</div><div class="dropdown-item" id="cartFooter" style="text-align: center;" ><span><small class="text-muted text-sm" sty>مبلغ قابل پرداخت : </small><strong id="cartTotalPrice"></strong><small class="text-muted text-sm"> '+local+'</small></span></div></div>');



					// <a href="http://termehsalari.com/login" class="btn btn-danger text-sm btn-block" style="margin-top: 10px">ورود و ثبت سفارش</a> 
				}

				// var price = thiz.parents(".card-sale").find(".price").children("span").text().trim().replace(/,/gi,"");
				var totalPrice = $("#cartTotalPrice").text().trim().replace(/,/gi,"");
				if(totalPrice=="") totalPrice = 0;
				// totalPrice = parseInt(totalPrice) + parseInt(price);
				totalPrice = parseInt(totalPrice) + parseInt(pay);
				$("#cartTotalPrice").text($.number(totalPrice));

				var cartQuantity = $("#cartContainer").children("div[data-id='"+ id +"'][data-moddel='"+ moddle +"']").find(".cartQuantity").text();
				if(cartQuantity != "")//اگر محصول قبلا در کارت اضافه شده
				{
					cartQuantity++;
					$("#cartContainer").children("div[data-id='"+ id +"'][data-moddel='"+ moddle +"']").find(".cartQuantity").text(cartQuantity);	
				}
				else
				{
					// var alt = $("#title").text();
					// $("#cartContainer").append('<a class="dropdown-item" href="#" data-id="'+ id +'" data-moddel="'+ moddle +'" ><img class="w-25 ml-2 " src="'+ img +'" alt="'+ alt +'" style="vertical-align: super;"><p class="text-sm d-inline-block" style="width: 72%">'+ alt +'<span class="d-block mt-2 text-muted"><span><span class="cartQuantity">1</span> عدد </span><a href="#" class="deleteCartItem" data-id="'+id+'" data-model="'+moddle+'"><i class="far fa-trash-alt float-left"></i></a></span></p></a><div class="dropdown-divider" style="clear: both;"></div>');
					item = '<div class="dropdown-item" data-id="'+id+'" data-moddel="'+moddle+'"><div class="row"><div class="col-4 m-auto"><img class="w-100" src="'+img+'" alt="'+title+'" style="vertical-align: super;"></div><div class="col-8"><p class="text-sm" title="'+title+'"><a href="'+document.location.origin+'/'+ moddle.toLowerCase() +'/'+id+'" data-id="'+ id +'" data-moddel="'+moddle+'">'+title.substr(0,29)+'... </a></p></div></div><div class="row mt-2">';
					if(off > 0){
                        item = item + '<div class="col-6"><span class=" text-muted text-sm"><del><span class="cartOriginalPrice">'+$.number(price)+'</span> '+local+' </span></del></div><div class="col-6"><span class="mt-2 text-muted text-sm"><span class="cartPrice">'+$.number(pay)+'</span> '+ local +' </span></div>';
					}
                    else{
						item = item + '<div class="col-12"><div class="col-6"><span class="mt-2 text-muted text-sm"><span class="cartPrice">'+$.number(price)+' </span> '+local+'</span> </div></div>';
                    }
                    
                    item = item + '</div><div class="row mt-2 text-muted text-sm"><div class="col-6 text-right"><span class="cartQuantity">1 </span> عدد </div><div class="col-6 text-left"><a href="#" class="deleteCartItem" data-id="'+id+'" data-model="'+moddle+'"><i class="far fa-trash-alt float-left"></i></a></div></div></div><div class="dropdown-divider" style="clear: both;"></div>';
					$("#cartContainer").append(item);
				}

				swal("عملیات با موفقیت انجام شد.", "کالا به سبد خرید شما اضافه گردید. برای ثبت سفارش  وارد سبد خرید خود شوید." ,"success");
			}
			else if(data == "error" || data == '0')
				swal("خطا  در انجام عملیات", "اتمام موجودی در انبار" ,"error");
			// console.log(data);
		
			// $('.loader').hide();
			// NProgress.done();
		});

	});

});//end