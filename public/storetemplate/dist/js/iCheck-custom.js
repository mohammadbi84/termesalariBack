$(function () {
	//------------------------iCheck--------------------------
	//Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass   : 'iradio_flat-blue'
    })

	$(".checkAll").on('ifChecked',function(){
		// $("#dataTable-table").find('.checkbox').iCheck('check');
		$(".dataTable").find('.checkbox').iCheck('check');
		// $(".dataTable tbody tr").toggleClass("bg-skyblue");
	});

	$(".checkAll").on('ifUnchecked',function(){
		$(".dataTable").find('.checkbox').iCheck('uncheck');
		// $(".dataTable tbody tr").toggleClass("bg-skyblue");
	});

	$('.checkbox').on('ifChecked',function(){
		$(this).parents("tr").addClass("bg-skyblue");
	});

	$('.checkbox').on('ifUnchecked',function(){
		$(this).parents("tr").removeClass("bg-skyblue");
	});

	$(".dataTable tbody tr").click(function (){
		var b = $(this).find('.icheckbox_flat-blue').attr("aria-checked");
		if(b == 'false')
		{
			$(this).find('.icheckbox_flat-blue').iCheck('check');
			$(this).addClass("bg-skyblue");
		}
		else if (b == 'true')
		{
			$(this).find('.icheckbox_flat-blue').iCheck('uncheck');
			$(this).removeClass("bg-skyblue");
		}
	});


})//End