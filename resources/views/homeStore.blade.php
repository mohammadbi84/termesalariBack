@extends("homeStore-layout")

@section('title','فروشگاه اینترنتی ترمه سالاری')
@push('link')
<style type="text/css">
  .small-box{
    background-size:cover !important;
  }

  .small-box>.small-box-footer{
    background: rgba(0,0,0,.4) !important;
    text-align: right !important;
    text-indent: 5px;
    height: 36px;
  }

  .small-box>.small-box-footer:hover{
    background: rgba(0,0,0,.6) !important; 
  }

  .ui-chat-container .btn_chat_lancher span.open_me{
     bottom: -11px !important;
  }

  .chat-box-footer .social>a i{
    line-height: 30px;
  }

  /*.owl-next,
  .owl-prev
  {
    position: absolute;
  }

  .owl-next{
    left: -12px !important;
  }

  .owl-prev{
    right: 3px !important;
  }

  #tableclothsCategories .owl-next,
  #tableclothsCategories .owl-prev{
    top: 50%;
    transform: translateY(-50%);
  }*/

  #tableclothsCategories .owl-prev{
    right: -34px !important;
  }

      @media (min-width:100px) and (max-width:300px) {
      #main {
        padding: 0px !important;
      }
    }

    @media (min-width:300px) and (max-width:400px) {
      #main {
        padding: 0px !important;
      }
    }

    @media (min-width:400px) and (max-width: 500px) {
      
      #main {
        padding: 0px !important;
      }
    }

    @media only screen and (max-width: 500px) {
      #main {
        padding: 0px !important;
      }
    }

    @media (min-width:500px) and (max-width: 700px) {
      #main {
        padding: 0px 60px 20px 60px !important;
      }
    }

    @media (min-width:700px) and (max-width: 800px) {
      #main {
        padding: 0px 140px 20px 140px !important;
      }
    }

    @media only screen and (min-width: 800px) {
      #main {
        padding: 0px 130px 20px 130px !important;
      }
    }

    @media (min-width:100px) and (max-width:350px) {
      #header #logo{
        padding-left: 0px !important;
      }

      #header #logo h1 {
        font-size: 90% !important;
      }
    }
    @media only screen and (max-width: 1048px) {
      #main {
        padding: 0px !important;
        padding-top: 92px !important;
      }
    }


</style>
@endpush
@section("main-content")
<!-- <div class="row">
  <div class="container-fluid"> -->
      <div class="card-body">
        <div class="row">
          <div class="col text-center alert alert-success text-bold" style="color:white !important">رنگ تصاویر با رنگ واقعی محصولات 20% تفاوت دارد.</div>
        </div>
        <div class="row align-items-center justify-content-between">
          <div class="col-lg-7 col-md-12 col-sm-12 align-self-start">
            <div class="owl-carousel owl-theme" id="slideshow">
              @foreach($slideshowImagesB as $image)
                <a href="{{ $image->link }}" title="{{ $image->title }}">
                  <img class="w-100" style="padding: 5px;"   src="{{ asset('storage/images'.$image->image) }}">
                </a>
              @endforeach
            </div>
          </div>

          <div class="col-lg-4 col-md-6 col-sm-6 mt-2 align-self-start">
            <div class="row align-items-center justify-content-center" >

              <div class="col-12 mt-2 text-center" style="background-color: #ffffff">
                <img src="{{ asset('/storetemplate/dist/img/join-us.png') }}" class="w-100" >
              </div>

              <div class="col-12 text-center" style=""><!--  position-relative -->
                <img src="{{ asset('/storetemplate/dist/img/newsletter.png') }}" class="w-100 "><!-- position-absolute -->
                <form method="post" action="{{ route('newsletter.store') }}" class="w-100" style="z-index: 2" >
                  @csrf
                  <div class="input-group input-group-sm mb-3 position-absolute" style=""><!-- bottom: -10; left: 50%;transform: translateX(-50%); width: 90% -->
                    <div class="input-group-prepend">
                      <input type="submit" class="btn btn-flat btn-danger joinNewsletter" value="عضویت">
                    </div>
                    <!-- /btn-group -->
                    <input type="email" class="form-control text-right @error('email_join_newsletter') is-invalid @enderror" name="email_join_newsletter" id="email_join_newsletter" value="{{old('email_join_newsletter')}}" placeholder="آدرس ایمیل  خودتو وارد کن.">
                    @error('email_join_newsletter')
                      <div class="invalid-feedback position-absolute" style="display: inline-block;top: 33px">{{$message}}</div>
                    @enderror
                  </div>
                </form>
              </div>

              

              {{-- <div class="col-12 position-relative" style="min-height: 49%; background: #4dd871 url('{{ asset('/storetemplate/dist/img/newsletter.jpg') }}') no-repeat center top; background-size: 80%;">
                <form method="post" action="{{ route('newsletter.store') }}" class="w-100">
                  @csrf
                  <div class="input-group mb-3 position-absolute" style="bottom: -10; left: 50%;transform: translateX(-50%); width: 90%">
                    <div class="input-group-prepend">
                      <input type="submit" class="btn btn-flat btn-danger joinNewsletter" value="عضویت">
                    </div>
                    <!-- /btn-group -->
                    <input type="email" class="form-control text-right @error('email_join_newsletter') is-invalid @enderror" name="email_join_newsletter" id="email_join_newsletter" value="{{old('email_join_newsletter')}}" placeholder="آدرس ایمیل  خودتو وارد کن.">
                    @error('email_join_newsletter')
                      <div class="invalid-feedback position-absolute" style="display: inline-block;top: 33px">{{$message}}</div>
                    @enderror
                  </div>
                </form>
              </div> --}}
              {{-- <div class="col-12 mt-2" style="min-height: 49%; background: #0dbbd3 url('{{ asset('/storetemplate/dist/img/join-us.jpg') }}') no-repeat right center; background-size: 100%;">
              </div> --}}
              
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-12 mt-4">
            <div class="card-header">
              <div class="card-title">
                <span>محصولات</span>
                {{-- @php dd($_SERVER['HTTP_HOST']) @endphp --}}
              </div> 
            </div>
            <div class="card-body">
              <div class="row justify-content-center">

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 ">
                  <a href="{{ route("tablecloth.storeIndex") }}"><div class="icon-box">
                    <img src="{{ asset("/storetemplate/dist/img/tablecloth-icon.png") }}" alt="tablecloth">
                    <h6>رومیزی</h6>
                  </div></a>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 ">
                  <a href="{{ route("bedcover.storeIndex") }}"><div class="icon-box">
                    <img src="{{ asset("/storetemplate/dist/img/bedcover-icon.png") }}" alt="bedcover">
                    <h6>روتختی</h6>
                  </div></a>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 ">
                  <a href="{{ route("pillow.storeIndex") }}"><div class="icon-box">
                    <img src="{{ asset("/storetemplate/dist/img/pillow-icon.png") }}" alt="pillow-icon">
                    <h6>پشتی و کوسن</h6>
                  </div></a>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 ">
                  <a href="{{ route("prayermat.storeIndex") }}"><div class="icon-box">
                    <img src="{{ asset("/storetemplate/dist/img/prayermat-icon.png") }}" alt="prayermat">
                    <h6>سجاده و جانماز</h6>
                  </div></a>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 ">
                  <a href="{{ route("fabric.storeIndex") }}"><div class="icon-box">
                    <img src="{{ asset("/storetemplate/dist/img/fabric-icon2.png") }}" alt="fabric">
                    <h6>پارچه ترمه</h6>
                  </div></a>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 ">
                  <a href=""><div class="icon-box">
                    <h1 style="width: 150px;height: 115px;">...</h1>
                    <h6>سایر محصولات</h6>
                  </div></a>
                </div>

              </div>
            </div>
          </div>

                {{-- @php dd($_SERVER['HTTP_HOST']) @endphp --}}
         {{--  <div class="col-12 mt-4">
            <div class="card-header">
              <div class="card-title">
                <span>محصولات</span>
              </div> 
            </div>
            <div class="card-body">
              <div id="tableclothsCategories" class="owl-carousel owl-theme listCarousel carousel-fade">
                @foreach($allCategories as $category)
                  <div class="" style="width: 290px;height: 290px;">
                    <a href="{{ route($category->link) }}" title="{{ $category->title }}">
                      <div class="small-box" style='background: url("{{ asset('/storage/images/categories/thumbnails/'.$category->image) }}") center center;'>
                        <div class="inner" style="height: 150px"></div>
                        <a href="{{ route($category->link) }}" class="small-box-footer">{{ $category->title }}<i class="fa fa-chevron-left" style="font-size: 0.6rem;"></i></a>
                      </div>
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          </div> --}}
          @if(isset($sermehProducts) and count($sermehProducts) > 0)
            <div class="col-12">
              <div class="card-header">
                <div class="card-title">
                  <span>سرمه دوزی</span>
                </div> 
              </div>
              <!-- <div class="container carousel"> -->
              <div id="topRequests" class="owl-carousel owl-theme listCarousel carousel-fade card-body" data-ride="carousel">

                @foreach($sermehProducts as $key=>$sermehProduct)
                  <div class="box-product-outer">
                      <div class="box-product">
                        <div class="img-wrapper">
                          <a href="
                            @switch($sermehProduct->category->model)
                                @case('App\Tablecloth')
                                  {{ route('tablecloth.show',[$sermehProduct->id]) }}
                                  @break
                                @case('App\Pillow')
                                  {{ route('pillow.show',[$sermehProduct->id]) }}
                                  @break
                                @case('App\Prayermat')
                                  {{ route('prayermat.show',[$sermehProduct->id]) }}
                                  @break
                                @case('App\Bedcover')
                                  {{ route('bedcover.show',[$sermehProduct->id]) }}
                                  @break
                                @case('App\Fabric')
                                  {{ route('fabric.show',[$sermehProduct->id]) }}
                                  @break
                            @endswitch
                          ">
                              <img alt="Product" src="{{asset('/storage/images/thumbnails/'.$sermehProduct->images->first()->name)}}">
                          </a>
                        </div>
                        <h6>
                          <a href="{{ route('tablecloth.show',[$sermehProduct->id]) }}" class="title">{{ $sermehProduct->category->title }} طرح {{ $sermehProduct->color_design->design->title}} رنگ {{ $sermehProduct->color_design->color->color }}</a>
                        </h6>
                        <div class="price">
                            @php
                              $prices = $sermehProduct->prices->where("local","تومان")->first();  
                            @endphp
                            <div>
                              @if($prices->offPrice > 0)
                              <span class="price-down">
                                  @if($prices->offType == 'مبلغ')
                                    {{ round(($prices->offPrice * 100) / $prices->price , 0) }}%-
                                  @elseif($prices->offType == 'درصد')
                                    {{ $prices->offPrice }}%-
                                  @endif
                              </span>
                              @endif
                              @if($prices->offPrice > 0)
                                @if($prices->offType == 'مبلغ')
                                  {{number_format($prices->price - $prices->offPrice)}}
                                @elseif($prices->offType == 'درصد')
                                  {{ $prices->price - ($prices->price * ($prices->offPrice/100)) }}
                                @endif
                              @else
                                {{number_format($prices->price)}}
                              @endif
                              تومان
                            </div>
                            <span class="price-old">{{ number_format($prices->price) }}</span>
                        </div>
                        <small class="text-muted">{{ count($sermehProduct->grades) }} نفر</small>
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
                          @if($sermehProduct->quantity > 0 and $sermehProduct->quantity <= 5)
                          <i class="fas fa-bell" style="color: #ef3a4e"></i>
                          @endif
                          <small @if($sermehProduct->quantity > 5) style="color: #000" @else style="color: #ef3a4e" @endif>
                          @if($sermehProduct->quantity == 0) اتمام موجودی در انبار 
                            @elseif($sermehProduct->quantity <= 5)کمتر از 5 عدد موجود می باشد  .
                          @endif
                          </small>
                        </div>

                      </div>
                  </div>
                
                @endforeach
              </div>
            </div>
          @endif


          <div class="col-12 mt-4">
            <div class="card-header">
              <div class="card-title">
                <span>محصولات رومیزی</span>
                {{-- @php dd($_SERVER['HTTP_HOST']) @endphp --}}
              </div> 
            </div>
            <div class="card-body">
              <div id="tableclothsCategories" class="owl-carousel owl-theme listCarousel carousel-fade">
                @foreach($tableclothsCategories as $category)
                  <div class="" style="width: auto;">
                    {{-- width: 290px;height: 290px --}}
                    <a href="{{ $category->link . $category->id }}" title="{{ $category->title }}">
                      <div class="small-box" style='background: url("{{ asset('/storage/images/categories/thumbnails/'.$category->image) }}") no-repeat center center;'>
                        <div class="inner" style="height: 150px"></div>
                        <a href="{{ $category->link . $category->id }}" class="small-box-footer">{{ $category->title }}<i class="fa fa-chevron-left" style="font-size: 0.6rem;"></i></a>
                        {{-- $_SERVER['HTTP_HOST'] .  --}}
                      </div>
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        
          @if(isset($topRequests) and count($topRequests) > 0)
            <div class="col-12">
              <div class="card-header">
                <div class="card-title">
                  <span>پرفروش ترین ها</span>
                </div> 
              </div>
              <!-- <div class="container carousel"> -->
              <div class="card-body">
                <div id="topRequests" class="owl-carousel owl-theme listCarousel carousel-fade" data-ride="carousel">
                
                  @foreach($topRequests as $key=>$topRequest)
                    <div class="box-product-outer">
                        <div class="box-product">
                          <div class="img-wrapper">
                            <a href="
                              @switch($topRequest->orderitemable_type)
                                  @case('App\Tablecloth')
                                    {{ route('tablecloth.show',[$topRequest->orderitemable->id]) }}
                                    @break
                                  @case('App\Pillow')
                                    {{ route('pillow.show',[$topRequest->orderitemable->id]) }}
                                    @break
                                  @case('App\Prayermat')
                                    {{ route('prayermat.show',[$topRequest->orderitemable->id]) }}
                                    @break
                                  @case('App\Bedcover')
                                    {{ route('bedcover.show',[$topRequest->orderitemable->id]) }}
                                    @break
                                  @case('App\Shoe')
                                    {{ route('shoe.show',[$topRequest->orderitemable->id]) }}
                                    @break
                              @endswitch
                            ">
                                <img alt="Product" src="{{asset('/storage/images/thumbnails/'.$topRequest->orderitemable->images->first()->name)}}">
                            </a>
                          </div>
                          <h6>
                            <a href="{{ route('tablecloth.show',[$topRequest->orderitemable->id]) }}" class="title">{{ $topRequest->orderitemable->category->title }} طرح {{ $topRequest->orderitemable->color_design->design->title}} رنگ {{ $topRequest->orderitemable->color_design->color->color }}</a>
                          </h6>
                          <div class="price">
                              @php
                                $prices = $topRequest->orderitemable->prices->where("local","تومان")->first();  
                              @endphp
                              <div>
                                @if($prices->offPrice > 0)
                                <span class="price-down">
                                    @if($prices->offType == 'مبلغ')
                                      {{ round(($prices->offPrice * 100) / $prices->price , 0) }}%-
                                    @elseif($prices->offType == 'درصد')
                                      {{ $prices->offPrice }}%-
                                    @endif
                                </span>
                                @endif
                                @if($prices->offPrice > 0)
                                  @if($prices->offType == 'مبلغ')
                                    {{number_format($prices->price - $prices->offPrice)}}
                                  @elseif($prices->offType == 'درصد')
                                    {{ $prices->price - ($prices->price * ($prices->offPrice/100)) }}
                                  @endif
                                @else
                                  {{number_format($prices->price)}}
                                @endif
                                تومان
                              </div>
                              <span class="price-old">{{ number_format($prices->price) }}</span>
                          </div>
                          <small class="text-muted">{{ count($topRequest->orderitemable->grades) }} نفر</small>
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
                            @if($topRequest->orderitemable->quantity > 0 and $topRequest->orderitemable->quantity <= 5)
                            <i class="fas fa-bell" style="color: #ef3a4e"></i>
                            @endif
                            <small @if($topRequest->orderitemable->quantity > 5) style="color: #000" @else style="color: #ef3a4e" @endif>
                            @if($topRequest->orderitemable->quantity == 0) اتمام موجودی در انبار 
                              @elseif($topRequest->orderitemable->quantity <= 5)کمتر از 5 عدد موجود می باشد  .
                            @endif
                            </small>
                          </div>

                        </div>
                    </div>
                  
                  @endforeach
                </div>
                
              </div>
            </div>
          @endif

          @if(isset($specials) and count($specials) > 0)
            <div class="col-12">
              <div class="card-header">
                <div class="card-title">
                  <span>پیشنهاد ویژه</span>
                </div> 
              </div>
              <!-- <div class="container carousel"> -->
              <div id="specials" class="owl-carousel owl-theme listCarousel carousel-fade  card-body" data-ride="carousel">
                @foreach($specials as $key=>$special)
                  <div class="box-product-outer">
                    <div class="box-product">
                      <div class="img-wrapper">
                        <a href="
                          @switch($special->priceable_type)
                              @case('App\Tablecloth')
                                {{ route('tablecloth.show',[$special->priceable->id]) }}
                                @break
                              @case('App\Pillow')
                                  {{ route('pillow.show',[$special->priceable->id]) }}
                                @break
                              @case('App\Prayermat')
                                  {{ route('prayermat.show',[$special->priceable->id]) }}
                                @break
                              @case('App\Bedcover')
                                  {{ route('bedcover.show',[$special->priceable->id]) }}
                                @break
                              @case('App\Shoe')
                                {{ route('shoe.show',[$special->priceable->id]) }}
                                @break
                          @endswitch
                        ">
                            <img alt="Product" src="{{asset('/storage/images/thumbnails/'.$special->priceable->images->first()->name)}}">
                        </a>
                      </div>
                      <h6>
                        <a href="
                          @switch($special->priceable_type)
                              @case('App\Tablecloth')
                                {{ route('tablecloth.show',[$special->priceable->id]) }}
                                @break
                              @case('App\Shoe')
                                {{ route('shoe.show',[$special->priceable->id]) }}
                                @break
                          @endswitch
                        " class="title">{{ $special->priceable->category->title }} طرح {{ $special->priceable->color_design->design->title}} رنگ {{ $special->priceable->color_design->color->color }}</a>
                      </h6>
                      <div class="price">
                          <div>
                            @if($special->offPrice > 0)
                            <span class="price-down">
                                @if($special->offType == 'مبلغ')
                                  {{ round(($special->offPrice * 100) / $special->price , 0) }}%-
                                @elseif($special->offType == 'درصد')
                                  {{ $special->offPrice }}%-
                                @endif
                            </span>
                            @endif
                            @if($special->offPrice > 0)
                              @if($special->offType == 'مبلغ')
                                {{number_format($special->price - $special->offPrice)}}
                              @elseif($special->offType == 'درصد')
                                {{ $special->price - ($special->price * ($special->offPrice/100)) }}
                              @endif
                            @else
                              {{number_format($special->price)}}
                            @endif
                            تومان
                          </div>
                          <span class="price-old">{{ number_format($special->price) }}</span>
                      </div>
                      <small class="text-muted">{{ count($special->priceable->grades) }} نفر</small>
                      <div class="br-wrapper br-theme-fontawesome-stars float-left">
                        <select class="showGradeSpecial{{$key}}"> 
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                      </div>
                      <div style="clear: both;">
                        @if($special->priceable->quantity > 0 and $special->priceable->quantity <= 5)
                        <i class="fas fa-bell" style="color: #ef3a4e"></i>
                        @endif
                        <small @if($special->priceable->quantity > 5) style="color: #000" @else style="color: #ef3a4e" @endif>
                        @if($special->priceable->quantity == 0) اتمام موجودی در انبار 
                          @elseif($special->priceable->quantity <= 5)کمتر از 5 عدد موجود می باشد  .
                        @endif
                        </small>
                      </div>

                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>

      </div>
<!--   </div>
</div> -->
@endsection
 
 @push('js')
  <script>
    $(function () {


//---------------------------Show Grade-------------------------
      @foreach($topRequests as $key=>$topRequest)
        $('.showGrade{{$key}}').barrating({
          theme:'fontawesome-stars-o',
          initialRating: "{{$topRequest->orderitemable->grades->avg('grade') ?? '0'}}",
          readonly:true,
        });
      @endforeach

      @foreach($specials as $key=>$special)
        $('.showGradeSpecial{{$key}}').barrating({
          theme:'fontawesome-stars-o',
          initialRating: "{{$special->priceable->grades->avg('grade') ?? '0'}}",
          readonly:true,
        });
      @endforeach   
//--------------------------------------------Carousel-------------------------------------
    	var owl = $("#tableclothsCategories, #like, #topRequests, #specials").owlCarousel({
        dots: true,
        nav:false,
        rtl: true,
        loop: false,
        items: 3,
        autoplay: true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        // lazyLoad: true,
        margin: 30,
        smartSpeed:450, 
        // navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
        responsiveClass:true,
        autoplayHoverPause: true, // Stops autoplay
        responsiveRefreshRate : 10,
        responsive:{
          0:{
              items:1,
          },
          500:{
              items:1,
          },
          700:{
            items:2,
          },
          900:{
              items:3,
          },
          1200:{
              items:3,
          },
          1500:{
              items:3,
          }
        } 
      });

      // var block = false;
      // $(".owl-item").mouseenter(function(){
      //   if(!block) {
      //     block = true;
      //     owl.trigger('stop.owl.autoplay')
      //     block = false;
      //   }
      // });

      // $(".owl-item").mouseleave(function(){
      //   if(!block) {
      //     block = true;
      //     owl.trigger('play.owl.autoplay',[1000])
      //     block = false;
      //   }
      // });

      $("#slideshow").owlCarousel({
        rtl: true,
        center:true,
        loop: true,
        lazyLoad: true,
        dots: true,
        items: 1,
        autoplay: true,
        autoplayTimeout:6000,
        autoplayHoverPause:true,
        animateOut: 'slideOutDown',
        animateIn: 'flipInX',
        smartSpeed:450,
      });

      

    })//end
  </script>

  @endpush
</body>
</html>
