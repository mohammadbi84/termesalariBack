@extends('store-layout')

@section('title', $title . ' طرح ' . $bedcover->color_design->design->title . ' رنگ ' .
    $bedcover->color_design->color->color)

    @push('link')
        <link href="{{ asset('/hometemplate/lib/font-awesome/css/all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/hometemplate/lib/animate/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/hometemplate/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/hometemplate/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/storetemplate/dist/css/termehsalari.css') }}" rel="stylesheet">
        <link href="{{ asset('/storetemplate/dist/css/container-fluid-responsive.css') }}" rel="stylesheet">
    @endpush

    @push('linkLast')
        <link href="{{ asset('/storetemplate/plugins/owlcarousel/dist/assets/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/storetemplate/plugins/owlcarousel/dist/assets/owl.theme.default.min.css') }}" rel="stylesheet">
        {{-- Rating --}}
        <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/css-stars.css') }}">
        <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css') }}">
        <link rel="stylesheet"
            href="{{ asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/fontawesome-stars-o.css') }}">
        <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/magnify-master/dist/css/magnify.css') }}">
        <style type="text/css">
            .br-wrapper {
                display: inline-block;
            }

            a[data-toggle="tab"] span {
                padding: 10px 0 10px 0;
                display: inline-block;
            }

            .box-product .title {
                font-size: 0.8rem;
                color: #666;
            }

            .box-product .price {
                text-align: right;
                font-size: 1rem;
                font-weight: bold;
            }

            .box-product .price-down,
            .box-product .price-old {
                font-size: 0.95rem;
            }

            /*.owl-item>.box-product-outer{
          margin: 20px 5px 0 5px;
         }*/
            #addToFavorite {
                color: #9b9b9b;
            }

            .owl-next {
                left: -6px !important;
            }

            .owl-prev {
                right: -6px !important;
            }

            .zoom {
                /*width: auto !important;
         height: 400px;*/
                display: inline-block !important;
            }

            .magnify-lens {
                z-index: 99999 !important;
            }
        </style>
    @endpush

@section('main-content')
    {{-- {{ dd(session('compares')) }} --}}
    <div class="row">
        <div class="col-md-12" style="margin: 0 auto;">
            <div class="card">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible" style="margin: 5px 5px;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fa fa-check"></i> توجه!</h5>
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-header">
                    <h3 class="card-title">
                        <span id="title"><a href="{{ route('bedcover.storeIndex') }}" style="color: #18d26e;">محصولات
                                روتختی</a> / {{ $bedcover->category->title }} طرح
                            {{ $bedcover->color_design->design->title }} رنگ
                            {{ $bedcover->color_design->color->color }}</span>
                        <a href="{{ route('compare.index') }}"
                            class="btn btn-flat btn-secondary position-fixed
                  	@if (session()->has('compares') and count(session('compares')['product']) > 0) d-block
                  	@else
                    	d-none @endif
                "
                            id="compareSide" style="left: 0px;z-index: 999;"> <i class="fa fa-angle-double-left"></i> مقایسه
                            (<span id="countCompare">
                                @if (session()->has('compares') and count(session('compares')['product']) > 0)
                                    {{ count(session('compares')['product']) }}
                                @endif
                            </span> کالا) <i class="fa fa-angle-double-right"></i> </a>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body product-header-info">
                    {{-- <div class="row"> --}}
                    @php
                        $images = $bedcover->images()->get()->sortby('ordering');
                        $prices = $bedcover->prices->where('local', 'تومان')->first();
                    @endphp
                    <div style="" class="col-md-7 m-auto">
                        <div class="owl-carousel owl-theme" id="slideshow" style=" width:100%;">
                            @foreach ($images as $key => $image)
                                <a href="{{ asset('storage/images/' . $image['name']) }}">
                                    <img class="w-100 zoom" style=""
                                        src="{{ asset('storage/images/' . $image['name']) }}" alt="{{ $image['name'] }}">
                                </a>
                            @endforeach
                        </div>

                    </div><!-- /.card-col-md-6 -->

                    <div class="mt-3" style="width: 320px; margin: auto auto;">
                        <div class="card card-sale card-danger card-outline ">

                            <div class="card-header" style="border-bottom: 0px;">
                                <h3 class="card-title"><span><a style="color: black" href="#details">>> مشاهده مشخصات فنی
                                            محصول <<</a></span></h3>
                            </div>

                            <div class="card-body">
                                <p class="quantity" data-id="{{ $bedcover->quantity }}" style="color: #ef3a4e;">
                                    @if ($bedcover->quantity > 0 and $bedcover->quantity <= 5)
                                        <i class="fas fa-bell"></i>
                                    @endif
                                    @if ($bedcover->quantity == 0)
                                        <span class="text-bold"> اتمام موجودی در انبار </span>
                                    @elseif($bedcover->quantity <= 5)
                                        <span class="text-bold">کمتر از 5 عدد موجود می باشد .</span>
                                    @elseif($bedcover->quantity > 5)
                                        <span class="text-success text-bold"> موجود در انبار</span>
                                    @endif
                                </p>
                                @php
                                    $price = 0;
                                    $off = 0;
                                    if ($prices->offPrice > 0) {
                                        if ($prices->offType == 'مبلغ') {
                                            $price = $prices->price - $prices->offPrice;
                                            $off = $prices->offPrice;
                                        } elseif ($prices->offType == 'درصد') {
                                            $off = $prices->price * ($prices->offPrice / 100);
                                            $price = $prices->price - $off;
                                        }
                                    } else {
                                        $price = $prices->price;
                                    }
                                @endphp

                                <div class="row">

                                    @if ($off > 0)
                                        <div class="col off" style="border-right: 1px solid #ef3a4e; color: black">
                                            <div class="row ">
                                                <div class="col text-center">
                                                    <span><del>{{ number_format($prices->price) }}</del></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col text-muted text-center">
                                                    {{ number_format($off) }} تخفیف
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col price text-center">
                                        <span id="{{ $price }}">{{ number_format($price) }}</span> تومان
                                    </div>
                                </div>

                                <p>
                                <div class="row">
                                    <input @if ($bedcover->quantity > 0) id="addToCart" @endif type="submit"
                                        value="افزودن به سبد خرید"
                                        class="btn btn-block btn-danger btn-lg @if ($bedcover->quantity == 0) disabled @endif"
                                        data-id = "{{ $bedcover->id }}" data-moddel = "Bedcover"
                                        data-design="{{ $bedcover->color_design->design->title }}"
                                        data-color="{{ $bedcover->color_design->color->color }}"
                                        data-title="{{ $bedcover->title }}" data-price="{{ $prices->price }}"
                                        data-pay="{{ $price }}" data-off="{{ $off }}"
                                        data-local="{{ $prices->local }}">
                                </div>
                                </p>

                                <div class="br-wrapper br-theme-fontawesome-stars">
                                    امتیاز :
                                    <select id="showGrade" data-model="Bedcover" data-current-rating="4">
                                        <!-- now hidden -->
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                {{-- {{ dd($bedcover->favorites->where('user_id',Auth::id())) }} --}}

                                <a href="#" id="addToFavorite" data-id="{{ $bedcover->id }}"
                                    data-model="Bedcover" class="float-left mt-1" title="افزودن به لیست علاقه مندی ها"
                                    style="font-size: 1.5rem"><i
                                        class="@if ($bedcover->favorites->where('user_id', Auth::id())->count() > 0) fa fa-heart @else far fa-heart @endif"></i></a>

                                <a href="" id="compare" title="افزودن به لیست مقایسه"
                                    class="float-left ml-2 mt-2" data-id="{{ $bedcover->id }}" data-model="Bedcover"
                                    style="vertical-align: middle;"><img
                                        src="{{ asset('/storetemplate/dist/img/compare.png') }}"></a>

                                {{-- <i class="fas fa-shipping-fast"></i> --}}
                            </div>
                            <!-- /.card-body -->

                            <div>

                            </div>

                        </div>
                    </div><!-- /.card-col-md-4 -->

                    {{-- </div>row --}}

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12" style="margin: 0 auto;">
            <!-- Custom Tabs -->
            <div class="card">
                <div class="card-header d-flex p-0">
                    {{-- <h3 class="card-title p-3">تب‌ها</h3> --}}
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item" id="details"><a class="nav-link active " href="#tab_1"
                                data-toggle="tab"><span>مشخصات فنی محصول</span></a></li>
                        <li class="nav-item" id="comment"><a class="nav-link " href="#tab_2"
                                data-toggle="tab"><span>نظرات کاربران</span></a></li>

                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <table class="table table-striped table-data">
                                <tr>
                                    <th colspan="2" style="color: #ef3a4e;">{{ $bedcover->category->title }} طرح
                                        {{ $bedcover->color_design->design->title }} رنگ
                                        {{ $bedcover->color_design->color->color }}</th>
                                </tr>
                                <tr>
                                    <td>کد محصول</td>
                                    <td>{{ $bedcover->code }}</td>
                                </tr>
                                <tr>
                                    <td>دسته بندی</td>
                                    <td>{{ $bedcover->category->title }}</td>
                                </tr>
                                <tr>
                                    <td>عنوان طرح</td>
                                    <td>{{ $bedcover->color_design->design->title }}</td>
                                </tr>
                                <tr>
                                    <td>تعداد رنگ بافت ترمه</td>
                                    <td>{{ $bedcover->color_design->design->countOfColor }} رنگ</td>
                                </tr>

                                <tr>
                                    <td>رنگ محصول</td>
                                    <td>{{ $bedcover->color_design->color->color }}</td>
                                </tr>

                                <tr>
                                    <td>مشتمل بر</td>
                                    <td class="multi-line">{{ $bedcover->contains }}</td>
                                </tr>
                                <tr>
                                    <td>ابعاد محصول</td>
                                    <td class="multi-line">{{ $bedcover->dimensions }}</td>
                                </tr>
                                <tr>
                                    <td>وزن تقریبی</td>
                                    <td class="multi-line">{{ $bedcover->weight }}</td>
                                </tr>
                                <tr>
                                    <td>جنس محصول</td>
                                    <td>{{ $bedcover->kind }}</td>
                                </tr>
                                <tr>
                                    <td>نوع دوخت</td>
                                    <td>{{ $bedcover->sewingType }}</td>
                                </tr>
                                <tr>
                                    <td>آستر</td>
                                    <td>{{ $bedcover->haveEster }}</td>
                                </tr>
                                <tr>
                                    <td>جنس آستر</td>
                                    <td>{{ $bedcover->kindOfEster }}</td>
                                </tr>
                                <tr>
                                    <td>قابلیت شستشو</td>
                                    <td>{{ $bedcover->washable }}</td>
                                </tr>
                                <tr>
                                    <td>قیمت محصول</td>
                                    <td>{{ number_format($prices->price) }} تومان</td>
                                </tr>
                                @if ($prices->offPrice > 0)
                                    <tr>
                                        <td>تخفیف</td>
                                        <td>
                                            @if ($prices->offType == 'مبلغ')
                                                {{ number_format($prices->offPrice) }}
                                                <small
                                                    class="badge badge-danger">{{ round(($prices->offPrice * 100) / $prices->price, 1) }}%</small>
                                            @elseif($prices->offType == 'درصد')
                                                {{ number_format(($prices->offPrice * $prices->price) / 100) }}
                                                <small class="badge badge-danger">{{ $prices->offPrice }}%</small>
                                            @endif
                                        </td>
                                    </tr>
                                @endif

                                @can('create', App\Bedcover::class)
                                    <tr>
                                        <td>موجودی در انبار</td>
                                        <td>{{ $bedcover->quantity }}</td>
                                    </tr>
                                @endcan
                                <tr>
                                    <td>توضیحات بیشتر</td>
                                    <td class="multi-line">{{ $bedcover->description }}</td>
                                </tr>

                            </table>
                        </div>


                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            <!-- Box Comment -->
                            {{-- <div class="card card-widget"> --}}

                            {{-- <div class="card-body"> --}}
                            <!-- post text -->
                            <p>مجموعه ترمه سالاری آماده پذیرش نظرات و پیشنهادات شما مشتریان عزیز می باشد.لطفا تجربیات خود را
                                در استفاده از محصولات ما برای دیگران به اشتراک بگذارید.</p>
                            <br><br>

                            <div class="br-wrapper br-theme-fontawesome-stars" style="margin-bottom: 20px;">
                                شما به این محصول چه امتیازی می دهید:
                                <select id="setGrade" data-model="Bedcover" data-id="{{ $bedcover->id }}">
                                    <!-- now hidden -->
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>

                            </div>

                            {{-- </div> --}}
                            <!-- /.card-body -->
                            <div class="card-footer card-comments">
                                @foreach ($comments as $comment)
                                    {{-- {{ dd($comment) }} --}}
                                    <div class="card-comment">
                                        <!-- User image -->
                                        <img class="img-circle img-sm"
                                            src="{{ asset('storetemplate/dist/img/' . $comment->user->image) }}"
                                            alt="User Image">

                                        <div class="comment-text">
                                            <span class="username">
                                                {{ $comment->user->name }} {{ $comment->user->family }}
                                                <span class="text-muted float-left">8:03 امروز</span>
                                            </span><!-- /.username -->
                                            {{ $comment->text }}
                                        </div>
                                        <!-- /.comment-text -->
                                    </div>
                                    <!-- /.card-comment -->
                                @endforeach
                            </div>
                            <!-- /.card-footer -->

                            <div class="card-footer">
                                @if (Auth::check())
                                    <form action="" method="">
                                        @csrf
                                        <!-- <input type="hidden" value="" name="_token" id="token" value="{{ csrf_token() }}"> -->
                                        <img class="img-fluid img-circle img-sm"
                                            src="{{ asset('storetemplate/dist/img/' . Auth::user()->image) }}"
                                            alt="profile Image">
                                        <!-- .img-push is used to add margin to elements next to floating images -->
                                        <div class="img-push">
                                            <textarea name="text" id="text" class="form-control  @error('text') is-invalid @enderror"
                                                autofocus="autofocus" placeholder="نظر خود را تایپ و ثبت کنید">{{ old('text') }}</textarea>
                                            <br>
                                            <input type="submit" id="saveComment" data-model="Bedcover"
                                                data-id="{{ $bedcover->id }}" value="ثبت" class="btn btn-danger">
                                        </div>
                                    </form>
                                @else
                                    <div style="color: red;text-align: center;">::برای ثبت نظرات خود ابتدا با نام کاربری
                                        وارد سایت شوید. ::</div>
                                @endif
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.tab-pane -->


                </div>
                <!-- /.tab-content -->
                <!--</div> /.card-body -->
            </div>
            <!-- ./card -->
        </div>

        <!-- /.col -->
        @if ($likeBedcovers->count() > 0)
            <div class="col-md-12" style="margin: 0 auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><span>محصولات مرتبط</span></h3>
                    </div>
                    <div class="">
                        <div class="owl-carousel owl-theme listCarousel carousel-fade card-body" id="carouselItems">
                            @foreach ($likeBedcovers as $key => $likeBedcover)
                                <div class="box-product-outer">
                                    <div class="box-product">
                                        <a href="{{ route('bedcover.show', [$likeBedcover->id]) }}">
                                            <div class="img-wrapper mb-2">
                                                <img alt="Product"
                                                    src="{{ asset('/storage/images/thumbnails/' . $likeBedcover->images->sortby('ordering')->first()->name) }}"
                                                    class="w-100">
                                            </div>
                                        </a>

                                        <h6>
                                            <a href="{{ route('bedcover.show', [$likeBedcover->id]) }}"
                                                class="title">{{ $likeBedcover->category->title }} طرح
                                                {{ $likeBedcover->color_design->design->title }} رنگ
                                                {{ $likeBedcover->color_design->color->color }}</a>
                                        </h6>
                                        <div class="price">
                                            @php
                                                $prices = $likeBedcover->prices->where('local', 'تومان')->first();
                                            @endphp
                                            <div>
                                                @if ($prices->offPrice > 0)
                                                    <span class="price-down">
                                                        @if ($prices->offType == 'مبلغ')
                                                            {{ round(($prices->offPrice * 100) / $prices->price, 1) }}%-
                                                        @elseif($prices->offType == 'درصد')
                                                            {{ $prices->offPrice }}%-
                                                        @endif
                                                    </span>
                                                @endif
                                                @if ($prices->offPrice > 0)
                                                    @if ($prices->offType == 'مبلغ')
                                                        {{ number_format($prices->price - $prices->offPrice) }}
                                                    @elseif($prices->offType == 'درصد')
                                                        {{ $prices->price - $prices->price * ($prices->offPrice / 100) }}
                                                    @endif
                                                @else
                                                    {{ number_format($prices->price) }}
                                                @endif
                                                تومان
                                            </div>
                                            <span class="price-old">{{ number_format($prices->price) }}</span>
                                        </div>
                                        <small class="text-muted">{{ count($likeBedcover->grades) }} نفر</small>
                                        <div class="br-wrapper br-theme-fontawesome-stars float-left">
                                            <select class="showGradeLikeBedcover{{ $key }}">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                        <div style="clear: both;">
                                            @if ($likeBedcover->quantity > 0 and $likeBedcover->quantity <= 5)
                                                <i class="fas fa-bell" style="color: #ef3a4e"></i>
                                            @endif
                                            <small
                                                @if ($likeBedcover->quantity > 5) style="color: #000" @else style="color: #ef3a4e" @endif>
                                                @if ($likeBedcover->quantity == 0)
                                                    اتمام موجودی در انبار
                                                @elseif($likeBedcover->quantity <= 5)
                                                    کمتر از 5 عدد موجود می باشد .
                                                @endif
                                            </small>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        @endif
    </div>
    <!-- /.row -->
    <!-- END CUSTOM TABS -->
@endsection

@push('js')
    <script src="{{ asset('/storetemplate/dist/js/jquery.number.min.js') }}"></script>
    <script src="{{ asset('/storetemplate/plugins/owlcarousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/storetemplate/dist/js/carousel.js') }}"></script>
    <script src="{{ asset('/storetemplate/plugins/jquery-bar-rating/dist/jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('/storetemplate/dist/js/comment.js') }}"></script>
    <script src="{{ asset('/storetemplate/dist/js/compare.js') }}"></script>
    <script src="{{ asset('/storetemplate/dist/js/favorite.js') }}"></script>
    <script src="{{ asset('/storetemplate/dist/js/grade.js') }}"></script>
    <script src="{{ asset('/storetemplate/dist/js/cart.js') }}"></script>
    <script src="{{ asset('/storetemplate/plugins/magnify-master/dist/js/jquery.magnify.js') }}"></script>
    <script src="{{ asset('/storetemplate/plugins/magnify-master/dist/js/jquery.magnify-mobile.js') }}"></script>
    <script>
        $(function() {

            @foreach ($likeBedcovers as $key => $likeBedcover)
                $('.showGradeLikeBedcover{{ $key }}').barrating({
                    theme: 'fontawesome-stars-o',
                    initialRating: "{{ $likeBedcover->grades->avg('grade') ?? '0' }}",
                    readonly: true,
                });
            @endforeach


            $('#showGrade').barrating({
                theme: 'fontawesome-stars-o',
                initialRating: "{{ number_format($grade, 1, '.', '') }}",
                readonly: true,

            });


        }); //END
    </script>
@endpush
