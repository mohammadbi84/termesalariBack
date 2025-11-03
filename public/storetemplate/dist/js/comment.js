$(function(){	
	$("#saveComment").click(function(event){
		$('#text').removeClass('is-invalid');
		event.preventDefault();
		event.stopPropagation();

		if($('#text').val() == '')
		{
			swal();
			swal("خطا در انجام عملیات", 'لطفا ابتدا نظر خود را تایپ کنید .',"error");
			$('#text').addClass('is-invalid');
			$('#text').focus();
			return false;
		}

		var id = $('#saveComment').data("id");
      	var text = $('#text').val();
     	var model = $('#saveComment').data("model");
     	var url = document.location.origin + "/comment";
     	var token = $("input[name='_token']").val();

		$.ajax({
		    type: 'POST',
		    url:  url,
		    dataType: 'json',
		    data: { 'product':id, 'model':model, 'text':text,'_token':token },
		    success: function(data){
		    	// $("body").html(data);
		        // console.log(data);
		        
		        if(data.res == "error")
		        {
		        	title = "خطا  در اجرای عملیات" ;
		        }
		        else if(data.res == "success")
		        {
		        	title = "عملیات با موفقیت انجام شد.";
		        }
		        swal(title, data.message,data.res);

				$('#text').val("").focus();
		    }
		});
		
	});
})//END