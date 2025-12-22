@extends("homeStore-layout")

@section('title','فروشگاه ترمه سالاری | محصولات رومیزی')

@push('linkLast')
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/iCheck/all.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('../storetemplate/plugins/select2/select2.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Ion Slider -->
  <!-- <link rel="stylesheet" href="{{asset('/storetemplate/plugins/ionslider/ion.rangeSlider.css')}}"> -->
  <!-- ion slider Nice -->
  <!-- <link rel="stylesheet" href="{{asset('/storetemplate/plugins/ionslider/ion.rangeSlider.skinNice.css')}}"> -->
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/ion.rangeSlider-master/css/ion.rangeSlider.min.css')}}">

  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/CSS-Checkbox-Library-master/dist/css/checkboxes.min.css')}}">

  <style type="text/css" media="screen">


    .compareLabel{
      top: -8px;
      right: 10px;
      /*display: none;*/
      /*transition: all 3s;*/
    }

    .productItem:hover > .compareLabel{
      display: block !important;
    }

    span.open_me {
      bottom: 0px !important;
    }

    /*.box-product .img-wrapper{
      height: auto !important;
      width: 100%;
      background-repeat: no-repeat;
      background-size: contain;
      background-position: top;
    }*/
    /*.box-product-outer {
      margin: 0px !important;
      width: 290px !important;
      height: 360px !important;
    }*/

    @media (max-width: 800px) {
      /*.box-product .img-wrapper
      {
        height: 120px !important;
      }*/

    }

    @media only screen and (max-width: 800px) {
      #main {
        padding: 0px 20px 0 20px !important;
        padding-top: 0px !important;
      }
    }


    .searchclear{
      position: absolute;
      left: 15px;
      top: 12px;
      bottom: 0;
      margin: auto;
      font-size: 14px;
      cursor: pointer;
      color: #ccc;
      /*display: none;*/
    }

    .collapse-icon{
      cursor: pointer;
      position: absolute;
      top: 13px;
      left: 5px;
      color: gray;
    }

    .ckbx-style-17{
      position: relative;
    }

    .ckbx-style-17>span{
      font-size: 1rem;
      position: absolute;
      right: 60px;
    }

  </style>
@endpush

@section("main-content")
{{--{{dd(config('app.locale'))}}--}}
  <div class="row mt-4 mb-4">
    <aside class="col-lg-3 col-md-6 col-sm-6" >
      <!-- <h5>Filters</h5> -->

      <!-- Section: Price -->
      <section class="card mb-8" filter="price">
        <div class="card-header">
          <h6 class="card-title p-3">محدوده قیمت</h6>

          <!-- card tools -->
          <div class="card-tools">
            <div class="collapse-icon" data-widget="collapse" data-toggle="tooltip">
              <i class="fa fa-chevron-up" aria-hidden="true"></i>
            </div>
          </div>
          <!-- /.card-tools -->

        </div>
        <div class="card-body">
          <form style="text-align: center;">
            @csrf
            <input class="" id="priceRange" type="text" name="priceRange" value="">
            {{-- <input class="btn btn-flat btn-primary" type="submit" id="applyPriceFilter" name="applyPriceFilter" value="اعمال محدوده قیمت"> --}}
            <a href="" id="applyPriceFilter" class="btn btn-flat btn-primary btn-sm mt-4"><i class="fa fa-filter"></i> اعمال محدوده قیمت</a>
          </form>

        </div>

      </section>
      <!-- Section: Price -->

      <!-- Section: Quantity -->
      <section class="card mb-8" filter="quantity">

        <div class="card-body">
          {{-- <form>
            @csrf --}}
            <div class="ckbx-style-17">
              <span style="font-size: 1rem"> فقط کالاهای موجود  </span><input type="checkbox" id="quantityFilter" value="0" name="quantityFilter" >
              <label for="quantityFilter"></label>
            </div>
          {{-- </form> --}}

            {{--<div class="ckbx-style-8">
                <span style="font-size: 1rem"> فقط کالاهای موجود  </span><input type="checkbox" id="ckbx-style-8-1" value="0" name="ckbx-style-8">
                <label for="ckbx-style-8-1"></label>
            </div>
             <div class="ckbx-style-5">
                <input type="checkbox" id="ckbx-style-5-1" value="0" name="ckbx-style-5">
                <label for="ckbx-style-5-1"></label>
            </div> --}}

        </div>

      </section>
      <!-- Section: Quantity -->

      <!-- Section: OffPrice -->
      <section class="card mb-8" filter="quantity">

        <div class="card-body">
          {{-- <form> --}}
            {{-- @csrf --}}
            <div class="ckbx-style-17">
              <span style="font-size: 1rem"> فقط تخفیف و حراجی  </span><input type="checkbox" id="offPriceFilter" name="offPriceFilter">
              <label for="offPriceFilter"></label>
            </div>
          {{-- </form> --}}

            {{-- <div class="ckbx-style-8">
                <input type="checkbox" id="ckbx-style-8-1" value="0" name="ckbx-style-8">
                <label for="ckbx-style-8-1"></label>
            </div>
            <div class="ckbx-style-5">
                <input type="checkbox" id="ckbx-style-5-1" value="0" name="ckbx-style-5">
                <label for="ckbx-style-5-1"></label>
            </div> --}}

        </div>

      </section>
      <!-- Section: OffPrice -->

      <!-- Section: Design -->
      <section filter="design" class="card mb-8">
        <div class="card-header">
          <h6 class="card-title p-3">طرح</h6>
            <!-- card tools -->
            <div class="card-tools">
              <div class="collapse-icon" data-widget="collapse" data-toggle="tooltip">
                <i class="fa fa-chevron-up" aria-hidden="true"></i>
              </div>
            </div>
            <!-- /.card-tools -->
        </div>

        <div class="card-body ">

            {{-- <select name="design_id" id="design_id" class="form-control select2 " multiple="multiple" style="width: 100%;" >

              @foreach($designs as $design)
                <option  @if ($design->id == old('design_id')) selected @endif value="{{$design->id}}">{{$design->title}}
                   {{ $design->title }}

                </option>
              @endforeach

            </select> --}}
          <div style="position: relative;">
            <input type="Search" class="form-control mb-4 searchInput" id="searchInput" name="searchInput" placeholder="جستجو.." style="display: inline-block;">
            <i class="fa fa-times searchclear"></i>
          </div>

          <div id="design_id" class="filter" style="overflow: auto; height: 230px;" >
            @foreach($designs as $key=>$design)
              <div class="form-check pl-0 mb-3 filter-item">
                <label class="form-check-label" for="design[]">
                  <input type="checkbox" class="checkbox" name="design[]" condition="design" id="design{{ $design->id }}" value="{{ $design->id }}"> {{ $design->title }}
                </label>
              </div>
             {{-- @if($key == 5)
                <div class="collapse" id="moreDesigns">
              @endif --}}
            @endforeach
            {{-- @if($key >= 5)
              </div>
              <a href="#" class="" data-toggle="collapse" data-target="#moreDesigns">
                <i class="fa fa-chevron-down"  aria-hidden="true"></i>بیشتر ...
              </a>
            @endif --}}
          </div>


        </div>
      </section>
      <!-- Section: Design -->


      <!-- Section: Type -->
      <section filter="category" class="card mb-8 ">
        <div class="card-header">
          <h6 class="card-title p-3">نوع</h6>
            <!-- card tools -->
            <div class="card-tools">
              <div class="collapse-icon" data-widget="collapse" data-toggle="tooltip">
                <i class="fa fa-chevron-up" aria-hidden="true"></i>
              </div>
            </div>
            <!-- /.card-tools -->
        </div>

        <div class="card-body ">
          <div style="position: relative;">
            <input type="Search" class="form-control mb-4 searchInput" id="searchInput" name="searchInput" placeholder="جستجو.." style="display: inline-block;">
            <i class="fa fa-times searchclear"></i>
          </div>

          <div id="category" class="filter" style="overflow: auto; height: 230px;" >

            @foreach($categories as $key=>$category)

              <div class="form-check pl-0 mb-3 filter-item">
                <label class="form-check-label" for="category{{ $key }}">
                  <input type="checkbox" class="checkbox" name="category{{ $key }}"  id="category{{ $key }}" value="{{ $category->id }}"> {{ $category->title }}
                </label>
              </div>

            @endforeach

          </div>


        </div>
      </section>
      <!-- Section: Type -->

      <!-- Section: DesignColor -->
      <section filter="designColor" class="card mb-8">
        <div class="card-header">
          <h6 class="card-title p-3">رنگ ها</h6>
            <!-- card tools -->
            <div class="card-tools">
              <div class="collapse-icon" data-widget="collapse" data-toggle="tooltip">
                <i class="fa fa-chevron-up" aria-hidden="true"></i>
              </div>
            </div>
            <!-- /.card-tools -->
        </div>

        <div class="card-body ">

          <div style="position: relative;">
            <input type="Search" class="form-control mb-4 searchInput" id="searchInput" name="searchInput" placeholder="جستجو.." style="display: inline-block;">
            <i class="fa fa-times searchclear"></i>
          </div>

          <div id="design_color_id" class="filter" style="overflow: auto; height: 230px;" >
            @foreach($colors as $key=>$color)
              <div class="form-check pl-0 mb-3 filter-item">
                <label class="form-check-label" for="designColor[]">
                  <input type="checkbox" class="checkbox" name="designColor[]" id="designColor{{ $color->id }}" value="{{ $color->id }}"> {{ $color->color }}
                </label>
              </div>
            @endforeach
          </div>


        </div>
      </section>
      <!-- Section: DesignColor -->

      <!-- Section: Color -->
      {{-- <section class="mb-4" filter="color">
        <h6 class="font-weight-bold mb-3">Color</h6>

        <div class="btn-group btn-group-toggle btn-color-group d-block mt-n2 ml-n2" data-toggle="buttons">
          <label for="color-1" class="btn rounded-circle white border-inset-grey p-3 m-2 waves-effect waves-light">
            <input id="color-1" class="filter-option" type="checkbox" color="white">
          </label>
          <label for="color-2" class="btn rounded-circle grey p-3 m-2 waves-effect waves-light">
            <input id="color-2" class="filter-option" type="checkbox" color="grey">
          </label>
          <label for="color-3" class="btn rounded-circle black p-3 m-2 waves-effect waves-light">
            <input id="color-3" class="filter-option" type="checkbox" color="black">
          </label>
          <label for="color-4" class="btn rounded-circle green p-3 m-2 waves-effect waves-light">
            <input id="color-4" class="filter-option" type="checkbox" color="green">
          </label>
          <label for="color-5" class="btn rounded-circle blue p-3 m-2 waves-effect waves-light">
            <input id="color-5" class="filter-option" type="checkbox" color="blue">
          </label>
          <label for="color-6" class="btn rounded-circle purple p-3 m-2 waves-effect waves-light">
            <input id="color-6" class="filter-option" type="checkbox" color="purple">
          </label>
          <label for="color-7" class="btn rounded-circle yellow p-3 m-2 waves-effect waves-light">
            <input id="color-7" class="filter-option" type="checkbox" color="yellow">
          </label>
          <label for="color-8" class="btn rounded-circle indigo p-3 m-2 waves-effect waves-light">
            <input id="color-8" class="filter-option" type="checkbox" color="indigo">
          </label>
          <label for="color-9" class="btn rounded-circle red p-3 m-2 waves-effect waves-light">
            <input id="color-9" class="filter-option" type="checkbox" color="red">
          </label>
          <label for="color-10" class="btn rounded-circle orange p-3 m-2 waves-effect waves-light">
            <input id="color-10" class="filter-option" type="checkbox" color="orange">
          </label>
        </div>
      </section> --}}
      <!-- Section: Color -->
    </aside>


    <div class="col-lg-9 col-md-6 col-sm-12">

      <div class="row card">
        <!-- <div class="col-md-12"> -->
          <div class="card-header position-relative">
            <div class="card-title">
              <span><a href="{{ route('homeStore.index') }}">صفحه اصلی فروشگاه</a> / محصولات رومیزی {{-- ( {{ $tablecloths->count() }} کالا) --}}</span>

              {{-- {{ dd(count(session('compares'))) }} --}}
                <a href="{{ route("compare.index") }}" class="btn btn-flat btn-danger position-fixed
                  @if(session()->has('compares') and count(session('compares')["product"]) > 0 )
                    d-block
                  @else
                    d-none
                  @endif
                " id="compareSide" style="left: 0px;z-index: 999;"> <i class="fa fa-angle-double-left"></i> مقایسه    (<span id="countCompare">
                  @if(session()->has('compares') and count(session('compares')["product"]) > 0 )
                    {{ count(session('compares')["product"]) }}
                  @endif
                </span> کالا) <i class="fa fa-angle-double-right"></i> </a>
            </div>
          </div>

          <div class="col-12 p-4">
            مرتب سازی بر اساس:

            <a href="#" class="btn btn-flat btn-outline-danger btn-sm sort mr-2 mb-2" data-value="topSales">پرفروش ترین</a>

            <a href="#" class="btn btn-flat btn-outline-danger btn-sm sort mr-2 mb-2" data-value="lastDate">جدیدترین</a>

            <a href="#" class="btn btn-flat btn-outline-danger btn-sm sort mr-2 mb-2" data-value="priceDesc">ارزان ترین</a>

            <a href="#" class="btn btn-flat btn-outline-danger btn-sm sort mr-2 mb-2" data-value="priceAsc">گران ترین</a>

            <a href="#" class="btn btn-flat btn-outline-danger btn-sm sort mr-2 mb-2" data-value="topOffer">پیشنهاد ویژه</a>

            <a href="#" class="btn btn-flat btn-outline-danger btn-sm sort mr-2 mb-2" data-value="topRate">محبوب ترین</a>
          </div>

          <div id="" class="col-12">
            {{-- @dd($tablecloths) --}}
            <div id="special" class="row align-items-center justify-content-center">
              @foreach($tablecloths as $key=>$tablecloth)
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4 position-relative productItem">
                  <label class="form-check-label position-absolute compareLabel d-none" for="compare">
                    <input type="checkbox" class="checkbox checkboxCompare" name="compare[]" id="compareTablecloth{{ $tablecloth->id }}" value="{{ $tablecloth->id }}" data-model="Tablecloth"> مقایسه
                  </label>
                  <div class="box-product-outer">
                    <div class="box-product">
                      <a href="{{ route('tablecloth.show',[$tablecloth]) }}" >
                        <div class="img-wrapper mb-2">
                            @if(count($tablecloth->images) > 0)
                              <img alt="Product" src="{{ asset('/storage/images/thumbnails/'.$tablecloth->images->sortby('ordering')->first()->name) }}" class="w-100">
                            @else
                              <img alt="Product" src="{{ asset('/storage/images/thumbnails/no-image.jpg') }}" class="w-100">
                            @endif
                        </div>
                      </a>
                      <h6>
                        <a href="{{ route('tablecloth.show',[$tablecloth]) }}" class="title">{{ $tablecloth->category->title }} طرح {{ $tablecloth->color_design->design->title}} رنگ {{ $tablecloth->color_design->color->color }}</a>
                      </h6>
                      <div class="price">
                          @php
                            $prices = $tablecloth->prices->where("local","تومان")->first();
                          @endphp
                          <div>
                            @if($prices->offPrice > 0)
                            <span class="price-down">
                                @if($prices->offType == 'مبلغ')
                                  {{ number_format(round(($prices->offPrice * 100) / $prices->price , 1)) }}%-
                                @elseif($prices->offType == 'درصد')
                                  {{ number_format($prices->offPrice) }}%-
                                @endif
                            </span>
                            @endif
                            @if($prices->offPrice > 0)
                              @if($prices->offType == 'مبلغ')
                                {{ number_format($prices->price - $prices->offPrice) }}
                              @elseif($prices->offType == 'درصد')
                                {{ number_format($prices->price - ($prices->price * ($prices->offPrice/100))) }}
                              @endif
                            @else
                              {{ number_format($prices->price) }}
                            @endif
                            تومان
                          </div>

                            <span class="price-old">
                            @if($prices->offPrice > 0)
                              {{ number_format($prices->price) }}
                            @endif
                            </span>

                      </div>
                      <small class="text-muted">{{ count($tablecloth->grades) }} نفر</small>
                      <div class="br-wrapper br-theme-fontawesome-stars float-left">
                        <select class="showGrade{{$key}}">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                      </div>
                      <div style="clear: both;">
                        @if($tablecloth->quantity > 0 and $tablecloth->quantity <= 5)
                        <i class="fas fa-bell" style="color: #ef3a4e"></i>
                        @endif
                        <small @if($tablecloth->quantity > 5) style="color: #000" @else style="color: #ef3a4e" @endif>
                        @if($tablecloth->quantity == 0) اتمام موجودی در انبار
                          @elseif($tablecloth->quantity <= 5)کمتر از 5 عدد موجود می باشد  .
                        @endif
                        </small>
                      </div>

                    </div>
                  </div>
                </div>
              @endforeach
            </div>

        </div>
{{-- @dd($tablecloths) --}}
        @if(count($tablecloths) > 15)
        @endif
        <div class="" style="margin: 20px auto;">{{ $tablecloths->links() }}</div>
      </div>

    </div>

  </div>






@endsection

@push("js")
  <!-- iCheck 1.0.1 -->
  <script src="{{asset('/storetemplate/plugins/iCheck/icheck.min.js')}}"></script>
  <!-- Select2 -->
  <script src="{{asset('../storetemplate/plugins/select2/select2.full.min.js')}}"></script>
  <script src="{{asset('../storetemplate/plugins/select2-multi-checkboxes-master/select2.multi-checkboxes.js')}}"></script>
  <script src="{{asset('/storetemplate/plugins/ion.rangeSlider-master/js/ion.rangeSlider.min.js')}}"></script>
  <script src="{{asset('/storetemplate/dist/js/filter-tablecloth.js')}}"></script>
  <script src="{{asset('/storetemplate/dist/js/compare.js')}}"></script>

  <script>
    $(function () {

      // $('.select2').select2({
      //   minimumResultsForSearch: Infinity
      // });

      $('.select2').select2({
        placeholder: "لطفاً عنوان طرح را انتخاب کنید.",
        width: "100%",
        dir :"rtl"
      })
//-------------Show Grade---------------------------------
      @foreach($tablecloths as $key=>$tablecloth)
        $('.showGrade{{$key}}').barrating({
          theme:'fontawesome-stars-o',
          initialRating: "{{$tablecloth->grades->avg('grade') ?? '0'}}",
          readonly:true,
        });
      @endforeach

//-------------------iCheck---------------------
      $('input[class*="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass   : 'iradio_flat-blue'
      });
//-------------------iCheck---------------------
      /* ION SLIDER */
    $('#priceRange').ionRangeSlider({

      min     : 0 ,
      max     : {{ $maxPrices }},
      from    : 0,
      to      : {{ $maxPrices }},
      type    : 'double',
      step    : 100000,
      prefix  : ' تومان ',
      prettify_enabled: true,
      prettify_separator: ",",
      prettify: function (num) {
        n = num.toLocaleString('en-US', {minimumFractionDigits: 0});
        persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        n = n.replace(/\d/g, function(match) {
            return persian[match]; // [0] is the entire matched text, which is one digit
        });
        return n;
      }
    });
//-------------------Search---------------------
    $(".searchclear").hide();
    $(".searchInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      if(value != ""){
        $(this).parent("div").find(".searchclear").fadeIn('fast');
        $(this).parents("section").find(".filter .filter-item").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      }
      else{
        $(this).parent("div").find(".searchclear").fadeOut('fast');
      }
    });

    $(".searchclear").click(function(){
        $(this).parent("div").find(".searchInput").val('');
        // var c = $(this).parents("section").find(".filter").find('.filter-item');
        $(this).parents("section").find(".filter").find('.filter-item').each(function( index ) {
          $(this).fadeIn("fast");
        });
        $(".searchInput").trigger("keyup");
        $(this).fadeOut("fast");
    });

    $(".collapse-icon").click(function () {
      if($(this).children("i").hasClass("fa-chevron-up")){
        $(this).children("i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
      }
      else if($(this).children("i").hasClass("fa-chevron-down")){
        $(this).children("i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
      }

    });

//----------------------------------------------------------------------

    @if(session()->has('compares') and count(session('compares')["product"]) > 0 )
      @php $compares = session('compares'); @endphp
      @foreach($compares["product"] as $compareID => $compare)
        $("#compare{{ $compares["model"][$compareID] }}{{ $compareID }}").iCheck("check");
        $("#compare{{ $compares["model"][$compareID] }}{{ $compareID }}").parents(".compareLabel").removeClass("d-none");
      @endforeach
    @endif

    // $(".compareLabel").on("ifChecked",function(){
    //   $(this).removeClass('d-none');
    //   var id = $(this).find("input").val();
    //   $.ajax({
    //     type:'GET',
    //     url: "{{ route('compare.add') }}",
    //     data: {
    //         id: id,
    //         model: "Tablecloth",
    //     },
    //     success:function(data){
    //       if (data ==  1) {
    //         $("#compareSide").removeClass("d-none");
    //         $("#compareSide").addClass("d-block");
    //       }
    //       $("#countCompare").text(data);
    //     }
    //   });


    // });

    // $(".compareLabel").on("ifUnchecked",function(){
    //   $(this).addClass('d-none');
    //   var id = $(this).find("input").val();
    //   $.ajax({
    //     type:'GET',
    //     url: "{{ route('compare.remove') }}",
    //     data: {
    //         id: id,
    //         model: "Tablecloth",
    //     },
    //     success:function(data){
    //       if (data == 0) {
    //         $("#compareSide").removeClass("d-block");
    //         $("#compareSide").addClass("d-none");
    //       }
    //       else if(data > 0){
    //         $("#compareSide").fadeIn("slow");
    //         $("#countCompare").text(data);
    //       }
    //     }
    //   });
    // });



//https://scotch.io/@mohammad-fouladgar/make-your-laravels-query-filter-with-the-cleanest-code
//https://nova.laravel.com/docs/1.0/filters/defining-filters.html
//https://dev.to/mehdifathi/making-the-advanced-query-filter-with-eloquent-filter-in-laravel-3m5l
//https://medium.com/@mykeels/writing-clean-composable-eloquent-filters-edd242c82cc8
//https://appdividend.com/2018/05/03/how-to-create-filters-in-laravel/

// var obj = {};
// obj.product = [];
// for(var i=0; i < someObj.length; i++) {
//    obj.product.push[{"attribute": someObj[i]}]
// }
//Result:{"product":[{"attribute":"value"}, {"attribute":"value"}]}



    // $('#isAgeSelected').click(function() {
    //   $("#txtAge").toggle(this.checked);
    // });

    // if($("#isAgeSelected").is(':checked'))
    //     $("#txtAge").show();  // checked
    // else
    //     $("#txtAge").hide();  // unchecked


    // $("#quantityFilter").click(function(){

      // var d = $(this).attr('checked');
      // if($(this).is(':checked'))
      // alert("ok");
      // filters.quantity = true;
      // filter(filters);

    // })





    })//end
  </script>

@endpush

