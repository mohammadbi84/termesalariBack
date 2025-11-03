function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    // console.log("ttt", regex);
    var results = regex.exec(document.location.search);
    // console.log("lll", results);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};
// console.log("kkkk",getUrlParameter('type[]'));



$(function () {  
  var filters = {
      "category" : [] ,
      "design" : [],
      "designColor" : [] ,
      "priceRange" : [] ,
      "offPrice" : "" ,
      "quantity" : "" ,
      "sort"  : "",
      // "priceSort": "",
      // "dateSort": "",
      // "topSaleSort": "",
    };

    $(".filter-item .checkbox").on('ifUnchecked',function(){
      var value = $(this).attr("value");
      var condition = $(this).parents("section").attr("filter");
      if(condition == "category")
      {
        filters.category.pop(value);
      }
      else if(condition == "design")
      {
        filters.design.pop(value);
      }
      else if(condition == "designColor")
      {
        filters.designColor.pop(value);
      }
      filter(filters);
    })


    $(".filter-item .checkbox").on('ifChecked',function(){
        var value = $(this).attr("value");
        var condition = $(this).parents("section").attr("filter");
        if(condition == "category")
        {
          filters.category.push(value);
        }
        else if(condition == "design")
        {
          filters.design.push(value);
        }
        else if(condition == "designColor")
        {
          filters.designColor.push(value);
        }
        filter(filters);
    })

    $('#quantityFilter').change(function() {
        if (this.checked) {
          filters.quantity = true;
          filter(filters);
        } else {
          filters.quantity = "";
          filter(filters);
        }
    });

    $('#offPriceFilter').change(function() {
        if (this.checked) {
          filters.offPrice = true;
          filter(filters);
        } else {
          filters.offPrice = "";
          filter(filters);
        }
    });

    // $('#priceSort').change(function(){
    //   const v = $(this).val();
    //   filters.priceSort = v;
    //   filter(filters);
    // });

    $('.sort').click(function(event){
      event.preventDefault();
      const v = $(this).data("value");
      filters.sort = v;
      filter(filters);
    });


    function filter(filters)
    {
      var addr = document.location.origin + "/store/pillows/filter";
      $(".loader").show();
      $.ajax({
          type:'GET',
          url: addr,
          data: {
           // model : model,
            category : filters.category,
            design : filters.design,
            designColor : filters.designColor,
            priceRange : filters.priceRange,
            quantity : filters.quantity,
            offPrice : filters.offPrice,
            // priceSort: filters.priceSort,
            sort: filters.sort,
            // value : value
          },
          success:function(data){
            console.log(filters);
            $('#special').html(data);

          },
          complete: function(){
              $('.loader').hide();
          }
      });
    }


    $("#applyPriceFilter").click(function () {
      event.preventDefault();
      var value = $("#priceRange").val();
      // alert(value);
      var condition = "priceRange";
      filters.priceRange = value;
      console.log(filters);
      var addr = document.location.origin + "/store/pillows/filter";
      $(".loader").show();
      $.ajax({
          type:'GET',
          url: addr,
          data: {
            // model : "App\Pillow",
            category : filters.category,
            design : filters.design,
            designColor : filters.designColor,
            priceRange : filters.priceRange,
            // value : value
          },
          success:function(data){
            // console.log(data);
            $('#special').html(data);
          },
          complete: function(){
              $('.loader').hide();
          }
      })



    });

    if(document.location.search) {
      const categoryValue = getUrlParameter('category[]');
      if(category)
      {
        const chk = $('section[filter=category]').find('input[value="' + categoryValue + '"]');
        chk.click();
        filters.category.push(categoryValue);
        // console.log(filters);
      }
        // else if(condition == "design")
        // {
        //   filters.design.push(value);
        // }
        // else if(condition == "designColor")
        // {
        //   filters.designColor.push(value);
        // }
    }
    


})//END