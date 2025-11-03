function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    // console.log("ttt", regex);
    var results = regex.exec(document.location.search);
    // console.log("lll", results);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};
// console.log("kkkk",getUrlParameter('type[]'));


$.removeElementFromCollection = function(collection,key) {
    // if the collections is an array
    if(collection instanceof Array) {
        // use jquery's `inArray` method because ie8 
        // doesn't support the `indexOf` method
        if($.inArray(key, collection) != -1) {
            collection.splice($.inArray(key, collection), 1);
        }
    }
    // it's an object
    else if(collection.hasOwnProperty(key)) {
        delete collection[key];
    }

    return collection;
};


$(function () {  
  var filters = {
      "category" : [] ,
      // "design" : [],
      // "designColor" : [] ,
      "colorDesign" : {
        'color':[],
        'design':[]
      } ,
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
        // filters.category.pop(value);
        $.removeElementFromCollection(filters.category, value);
      }
      else if(condition == "design" )
      {
        $.removeElementFromCollection(filters.colorDesign.design, value);
      }
      else if(condition == "designColor")
      {
        $.removeElementFromCollection(filters.colorDesign.color, value);
      }
      /*else if(condition == "design")
      {
        $.removeElementFromCollection(filters.design, value);
      }
      else if(condition == "designColor")
      {
        // console.log(value);
        $.removeElementFromCollection(filters.designColor, value);
      }*/
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
          filters.colorDesign.design.push(value);
        }
        else if(condition == "designColor")
        {
          filters.colorDesign.color.push(value);
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
      var addr = document.location.origin + "/store/tablecloths/filter";
      $(".loader").show();
            console.log(filters);
      $.ajax({
          type:'GET',
          url: addr,
          data: {
            category : filters.category,
            // design : filters.colorDesign.design,
            // designColor : filters.colorDesign.color,
            colorDesign : filters.colorDesign,
            priceRange : filters.priceRange,
            quantity : filters.quantity,
            offPrice : filters.offPrice,
            sort: filters.sort,
          },
          success:function(data){
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
      var addr = document.location.origin + "/store/tablecloths/filter";
      $(".loader").show();
      $.ajax({
          type:'GET',
          url: addr,
          data: {
            category : filters.category,
            // design : filters.colorDesign.design,
            // designColor : filters.colorDesign.color,
            colorDesign : filters.colorDesign,
            priceRange : filters.priceRange,
            quantity : filters.quantity,
            offPrice : filters.offPrice,
            sort: filters.sort,
            /*category : filters.category,
            design : filters.colorDesign.design,
            designColor : filters.colorDesign.color,
            priceRange : filters.priceRange,*/

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