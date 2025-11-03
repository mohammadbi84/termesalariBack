$(function(){

    $('#setGrade').barrating('show', {
	  theme: 'my-awesome-theme',
	  emptyValue:'', 
	  	onSelect: function(value, text, event) {
		    if (typeof(event) !== 'undefined') {
		      	// rating was selected by a user
		      	var id = $('#setGrade').data("id");
		      	var garde = value;
		     	var model = $('#setGrade').data("model");
		     	var url = document.location.origin + "/grade/store";
		     	var title = "";
		     	$.ajax({
				    type: 'GET',
				    // url: url + "/" + id + "/" + model + "/" + value ,
				    url: url,
				    data: {
			          id : id,
			          model: model,
			          value: value,
			        },
				    success: function(data){
				        if(data.res == "error") {
				        	title = "خطا  در اجرای عملیات" ;
				        }
				        else if(data.res == "success"){
				        	title = "عملیات با موفقیت انجام شد.";
				        }
				        swal(title, data.message,data.res);
				    }
				});
		    }
	  	}
	});



})//END