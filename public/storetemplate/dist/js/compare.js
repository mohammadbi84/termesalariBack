$(function(){  
    $(".compareLabel").on("ifChecked",function(){
      $(this).removeClass('d-none');
      var id = $(this).find("input").val();
      var model = $(this).find("input").data('model');
      $.ajax({
        type:'GET',
        url: document.location.origin + "/compare/add",
        data: {
            id: id,
            model: model,
        },
        success:function(data){
          if (data ==  1) {
            $("#compareSide").removeClass("d-none");
            $("#compareSide").addClass("d-block");
          }
          $("#countCompare").text(data);
          // swal("عملیات با موفقیت انجام شد.", "محصول مورد نظر به لیست علاقه مندی ها اضافه شد.","success");
        }
      });


    });

    $(".compareLabel").on("ifUnchecked",function(){
      $(this).addClass('d-none');
      var id = $(this).find("input").val();
      var model = $(this).find("input").data('model');
      $.ajax({
        type:'GET',
        url:  document.location.origin + "/compare/remove",
        data: {
            id: id,
            model: model,
        },
        success:function(data){
          if (data == 0) {
            $("#compareSide").removeClass("d-block");
            $("#compareSide").addClass("d-none");
          }
          else if(data > 0){
            $("#compareSide").fadeIn("slow");
            $("#countCompare").text(data);
          }
          // swal("عملیات با موفقیت انجام شد.", "محصول مورد نظر به لیست علاقه مندی ها اضافه شد.","success");
        }
      });
    });

    //-------------------------------------------
    $("#compare").click(function(event){
      event.preventDefault();
      var id = $(this).data("id");
      var model = $(this).data("model");
      $.ajax({
        type:'GET',
        url: document.location.origin + "/compare/add",
        data: {
            id: id,
            model: model,
        },
        success:function(data){
            if (data ==  1) {
              $("#compareSide").removeClass("d-none");
              $("#compareSide").addClass("d-block");
            }
            $("#countCompare").text(data);
            swal("عملیات با موفقیت انجام شد.", "محصول مورد نظر به لیست علاقه مندی ها اضافه شد.","success");
        }
    });
  })

})//END