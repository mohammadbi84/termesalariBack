$(function(){
	$("#addToFavorite").click(function(event){
		event.preventDefault();
		var id = $(this).data("id");
		var model = $(this).data("model");
		var url = document.location.origin + "/user/add-favorite";
		$.ajax({
	        type:'GET',
	        url:url,
	        data: {
	          id : id,
	          model: model
	        },
	        success:function(data){
	            // console.log(data);
				// $("body").html(data);
				if(data.res == "error")
		        {
		        	title = "خطا  در اجرای عملیات" ;
		        }
		        else if(data.res == "success")
		        {
		        	title = "عملیات با موفقیت انجام شد.";
		        }
		        swal(title, data.message,data.res);
	            }
	    });
	});

	//--------------------------------------------------------
	$(".removeFromFavorites").click(function(event){
		event.preventDefault();
		var $thiz = $(this);
		var id = $(this).data("id");
		var url = document.location.origin + "/user/remove-favorite/";


	swal({
		  title: "اخطار",
		  text: "آیا از حذف این محصول از لیست علاقه مندی ها مطمئن هستید؟",
		  icon: "warning",
		   buttons: ["انصراف","حذف"],
		  dangerMode: true,
		})
		.then((willDelete) => {
		  	if (willDelete) {
			  	$.ajax({
			        type:'GET',
			        url:url,
			        data: {
			          id : id,
			        },
			        success:function(data){
			            // console.log(data);
						if(data.res == "error")
				        {
				        	title = "خطا  در اجرای عملیات" ;
				        }
				        else if(data.res == "success")
				        {
				        	$thiz.parents('.media').hide("fast");
				        	title = "عملیات با موفقیت انجام شد.";
				        }
				        swal(title, data.message,data.res);
			        }
			    });
			}
		});	
	})



});//end