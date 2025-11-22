@extends('store-layout')

@section('title', 'سبد خرید')

@push('link')
    <link href="{{ asset('/storetemplate/dist/css/cart.css') }}" rel="stylesheet">
    <style type="text/css">
        #TopMenuCartIcone {
            display: none;
        }
    </style>
@endpush

@section('main-content')
    @php
        $discountCardPrice = 0;
        if (session()->has('discountCardPrice')) {
            $discountCardPrice = session('discountCardPrice');
        }
    @endphp
    <div class="row">
        <div class="col-12">
            @if (session()->has('success') or session()->has('danger'))
                <div
                    class="alert  @if (session()->has('success')) alert-success @elseif(session()->has('danger')) alert-danger @endif  alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fa fa-check"></i> توجه!</h5>
                    @if (session()->has('success'))
                        {{ session('success') }}
                    @elseif(session()->has('danger'))
                        {{ session('danger') }}
                    @endisset
            </div>
        @endif
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <span>سبد خرید
                @if (isset($cart))
                    <b class="header-total-quantity">{{ $sum }}</b>
                @endif
            </span>
        </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body product-header-info cart-container row">

        @if (isset($list) and count($list) > 0)
            <div class="cart-products col-md-7">
                @php
                    $price = 0;
                    $off = 0;
                @endphp
                @foreach ($list['products'] as $key => $product)
                    {{-- {{ dd($list['quantities'][$key]) }} --}}
                    @php
                        $cartItemPrice = 0;
                        $cartItemOff = 0;
                        $p = $product->prices->where('local', 'تومان')->first();
                        if ($p->offPrice > 0) {
                            if ($p->offType == 'مبلغ') {
                                $cartItemPrice = $p->price - $p->offPrice;
                                $cartItemOff = $p->offPrice;
                                $price = $price + ($p->price - $p->offPrice) * $list['quantities'][$key];
                                $off = $off + $cartItemOff * $list['quantities'][$key];
                            } elseif ($p->offType == 'درصد') {
                                $cartItemPrice = $p->price - $p->price * ($p->offPrice / 100);
                                $cartItemOff = $p->price * ($p->offPrice / 100);
                                $price = $price + ($p->price - $cartItemOff) * $list['quantities'][$key];
                                $off = $off + $cartItemOff * $list['quantities'][$key];
                            }
                        } else {
                            $cartItemPrice = $p->price;
                            $price = $price + $p->price * $list['quantities'][$key];
                        }

                    @endphp
                    <div class="cart-product row">
                        <div class="image-box col-md-2">
                            <img class="image-product w-100"
                                src="{{ asset('storage/images/thumbnails/' . $product->images->first()->name) }}"
                                style="" alt="{{ $product->title }}">
                        </div>

                        <div class="info-product col">
                            <h3>{{ $product->category->title }} طرح {{ $product->color_design->design->title }} رنگ
                                {{ $product->color_design->color->color }}</h3>
                            <h3>کد محصول : {{ $product->code }}</h3>
                            <h4>گارانتی اصالت و سلامت فیزیکی کالا</h4>
                            <br>
                            <div class="row">
                                <div>
                                    <div class="quantity-product">
                                        <a href="#" class="increase" data-model="{{ $list['models'][$key] }}"
                                            data-id = "{{ $product->id }}">+</a>
                                        <span class="count">{{ $list['quantities'][$key] }}</span>
                                        <a href="#" class="decrease" data-model="{{ $list['models'][$key] }}"
                                            data-id = "{{ $product->id }}">-</a>
                                        {{-- <form class="del-form" action="{{route('cart.destroy', [$product->id."-". $cart[$product->id]['moddel'] ])}}" method="post">
													@csrf
													@method('delete') --}}
                                        <a href="#" data-model="{{ $list['models'][$key] }}"
                                            data-id = "{{ $product->id }}" class="delete"><i
                                                class="far fa-trash-alt"></i></a>
                                        {{-- </form> --}}
                                    </div>
                                </div>
                                <div class="price-product col-md-8">

                                    @if ($cartItemOff > 0)
                                        <del><span id="price">{{ number_format($p->price) }}</span>
                                            <small>{{ $p->local }}</small></del>
                                        <div style="color: red">
                                            <small> تخفیف</small>
                                            <span id="offprice">{{ number_format($cartItemOff) }}</span>
                                            <small>{{ $p->local }}</small>
                                        </div>
                                        <span>{{ number_format($cartItemPrice) }}</span>
                                        <small>{{ $p->local }}</small>
                                    @else
                                        <span id="price">{{ number_format($cartItemPrice) }}</span>
                                        <small>{{ $p->local }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
                @if (!session()->has('discountCardPrice'))
                    <div class="row mt-4 mb-4" id="discountCardRow">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="input-group input-group-md">
                                <input type="text" name="code" id="code"
                                    placeholder="لطفا در صورت داشتن کد تخفیف، آن را وارد کنید." class="form-control"
                                    style="font-size: 0.95rem;">
                                <span class="input-group-append">
                                    <button type="button" id="saveDiscountCard"
                                        class="btn btn-info btn-flat btn-danger" style="font-size: 0.95rem;">اعمال کد
                                        تخفیف</button>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row total-row">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-sm btn-flat btn-secondary">نمایش لیست محصولات</a>
                        <a href="{{ route('cart.cartlevel2') }}" class="btn btn-sm btn-flat btn-primary">ادامه فرایند
                            خرید</a>
                    </div>
                    <div class="col-md-6" style="text-align: left">
                        <small>مبلغ قابل پرداخت </small>

                        <p style="padding-top: 5px">
                            <b id="total">{{ number_format($price - $discountCardPrice) }}</b> <small>
                                تومان</small>
                        </p>
                    </div>
                </div>
                {{-- @endisset --}}
            </div>
            <div class="cart-info col-md-4  table-responsive p-0">
                <table class="table">
                    <tr>
                        <td>قیمت کالا@if (isset($sum) and $sum > 1)ها (<span
                                    id="cart_info-quantity">{{ $sum }}</span>) @endif
                        </td>
                        <td><span id="cart-info-price"
                                data-value="{{ $price + $off }}">{{ number_format($price + $off) }}</span>
                            <small>تومان </small></td>
                    </tr>
                    <tr>
                        <td>تخفیف کالا@if (isset($sum) and $sum > 1)ها
                            @endif
                        </td>
                        <td style="color: #ef3a4e;"><span id="cart-info-off">{{ number_format($off) ?? '' }}</span>
                            <small>تومان </small></td>
                    </tr>
                    <tr style="border-top: 1px solid #ef3a4e">
                        <td>جمع </td>
                        <td><span id="cart-info-sum"
                                data-value="{{ $price }}">{{ number_format($price) ?? '' }}</span> <small>تومان
                            </small></td>
                    </tr>

                    @if (session()->has('discountCardPrice'))
                        <tr>
                            <td>تخفیف ویژه</td>
                            <td>{{ number_format(session('discountCardPrice')) }} <small>تومان </small></td>
                        </tr>
                    @endif
                    <tr>
                        <td>هزینه ارسال</td>
                        <td style="color: #ef3a4e;" id="cart-info-postPrice">مرحله بعد</td>
                    </tr>
                    <tr>
                        <td>مبلغ قابل پرداخت</td>
                        <td>
                            {{-- @php
									if(session()->has("discountCardPrice"))
										$pricePay = $price - session("discountCardPrice");
									else

								@endphp --}}
                            <span id="cart-info-total"
                                data-value="{{ $price - $discountCardPrice }}">{{ number_format($price - $discountCardPrice) ?? '' }}</span>
                            <small>تومان </small>
                        </td>
                    </tr>
                </table>
            </div>
        @else
            <div style="margin: 0 auto; text-align: center;">
                <img src="{{ asset('/storetemplate/dist/img/empty-cart-icon.png') }}">
                <p>سبد خرید شما خالی است!</p>
                <a href="http://termehsalari.com/shop" class="btn btn-success">نمایش محصولات <img
                        src="{{ asset('/storetemplate/dist/img/online-supermarket-cart.png') }}"></a>
            </div>

        @endif
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('/storetemplate/dist/js/jquery.number.min.js') }}"></script>
<script>
    $(function() {

        $('.increase,.decrease').click(function(event) {
            event.preventDefault();
            $(".loader").show();
            var thiz = $(this);
            var totalQuantity = $(".header-total-quantity").text();
            var price = thiz.parents(".info-product").find('#price').text().replace(/,/gi, "");
            var offprice = thiz.parents(".info-product").find('#offprice').text().replace(/,/gi, "");
            if (offprice == "") offprice = 0;
            var cartInfoPrice = $("#cart-info-price").text().replace(/,/gi, "");
            var cartInfoOff = $("#cart-info-off").text().replace(/,/gi, "");
            if (thiz.parent().find('.count').val() == 1) {
                thiz.parents('.cart-product').fadeOut();
                $(".header-total-quantity,#cart-info-quantity").text(totalQuantity - 1);
            }
            var id = thiz.data('id');
            var action = thiz.attr('class');
            var model = thiz.data('model');
            var cartQuantity = $("#cartContainer").children("a[data-id='" + id + "'][data-moddel='" +
                model + "']").find(".cartQuantity").text();
            var totalQuantity = $("#totalQuantity").text();
            var url = "{{ url('/cart/change/') }}";
            $.post(url, {
                '_token': '<?php echo csrf_token(); ?>',
                'action': action,
                'product': id,
                'model': model
            }, function(data) {
                if (data == "error") {
                    Swal.fire({
                                icon: "error",
                                title: "اتمام موجودی در انبار!",
                                timer: 1500,
                                showConfirmButton: false
                            });
                } else {
                    if (data == "finish")
                        thiz.parents('.cart-product').fadeOut();
                    else
                        thiz.parent().find('.count').text(data.quantity);
                    if (action == 'decrease') {
                        $(".header-total-quantity,#cart_info-quantity,.shopping-cart").text(
                            totalQuantity - 1);

                        $("#cart-info-price").text($.number(cartInfoPrice - price));
                        $("#cart-info-off").text($.number(cartInfoOff - offprice));
                        $("#cart-info-total,#total,#cart-info-sum,#cartTotalPrice").text(
                            $.number(
                                $("#cart-info-price").text().replace(/,/gi, "") -
                                $("#cart-info-off").text().replace(/,/gi, "")
                            )
                        );
                        //Cart icon in top menu
                        $(".shopping-cart-badge").text($(".shopping-cart-badge").text() - 1);
                        totalQuantity--;
                        $("#totalQuantity").text(totalQuantity);
                        cartQuantity--;
                        $("#cartContainer").children("a[data-id='" + id + "'][data-moddel='" +
                            model + "']").find(".cartQuantity").text(cartQuantity);

                    } else if (action == 'increase') {
                        totalQuantity++;
                        $(".header-total-quantity,#cart_info-quantity,.shopping-cart").text(
                            totalQuantity);
                        $("#cart-info-price").text($.number(parseInt(cartInfoPrice) + parseInt(
                            price)));
                        $("#cart-info-off").text($.number(parseInt(cartInfoOff) + parseInt(
                            offprice)));
                        $("#cart-info-total,#total,#cart-info-sum,#cartTotalPrice").text(
                            $.number(
                                parseInt($("#cart-info-price").text().replace(/,/gi, "")) -
                                parseInt($("#cart-info-off").text().replace(/,/gi, ""))
                            )
                        );
                        //Cart icon in top menu
                        $(".shopping-cart-badge").text(parseInt($(".shopping-cart-badge")
                        .text()) + 1);
                        $("#totalQuantity").text(totalQuantity);
                        cartQuantity++;
                        $("#cartContainer").children("a[data-id='" + id + "'][data-moddel='" +
                            model + "']").find(".cartQuantity").text(cartQuantity);
                    }
                }
                $('.loader').hide();
            });
        });

        $(".delete").click(function() {
            event.preventDefault();
            $(".loader").show();
            // event.stopPropagation();
            var thiz = $(this);
            var id = $(this).data('id');
            var model = $(this).data('model');
            var quantity = thiz.parents(".info-product").find('.count').text();
            // var addr = thiz.parents('.del-form').attr('action');
            Swal.fire({
                    title: "آیا از حذف این محصول مطمئن هستید؟",
                    text: "این عملیات منجر به حذف محصول از سبد خرید شما خواهد شد.",
                    icon: "warning",
                    buttons: ["انصراف", "حذف"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('cart.deleteItem') }}",
                            data: {
                                _token: '<?php echo csrf_token(); ?>',
                                id: id,
                                model: model,
                            },
                            success: function(data) {
                                // console.log(data);
                                if (data.status == "error") {
                                    title = "خطا  در اجرای عملیات";
                                } else if (data.status == "success") {
                                    var totalQuantity = $(".header-total-quantity")
                                        .text();
                                    var price = thiz.parents(".info-product").find(
                                        '#price').text().replace(/,/gi, "");
                                    var offprice = thiz.parents(".info-product").find(
                                        '#offprice').text().replace(/,/gi, "");
                                    if (offprice == "") offprice = 0;
                                    var cartInfoPrice = $("#cart-info-price").text()
                                        .replace(/,/gi, "");
                                    var cartInfoOff = $("#cart-info-off").text()
                                        .replace(/,/gi, "");
                                    var id = thiz.data('id');
                                    var model = thiz.data('model');
                                    var cartQuantity = $("#cartContainer").children(
                                        "a[data-id='" + id + "'][data-moddel='" +
                                        model + "']").find(".cartQuantity").text();

                                    $(".header-total-quantity,#cart_info-quantity,.shopping-cart")
                                        .text(totalQuantity - quantity);

                                    $("#cart-info-price").text($.number(cartInfoPrice -
                                        (price * quantity)));
                                    $("#cart-info-off").text($.number(cartInfoOff - (
                                        offprice * quantity)));
                                    $("#cart-info-total,#total,#cart-info-sum,#cartTotalPrice")
                                        .text(
                                            $.number(
                                                $("#cart-info-price").text().replace(
                                                    /,/gi, "") -
                                                $("#cart-info-off").text().replace(
                                                    /,/gi, "")
                                            )
                                        );
                                    //Cart icon in top menu
                                    $(".shopping-cart-badge").text($(
                                            ".shopping-cart-badge").text() -
                                        quantity);
                                    totalQuantity = totalQuantity - quantity;
                                    $("#totalQuantity").text(totalQuantity);
                                    cartQuantity = cartQuantity - quantity;
                                    $("#cartContainer").children("a[data-id='" + id +
                                        "'][data-moddel='" + model + "']").fadeOut(
                                        'slow');
                                    title = "عملیات با موفقیت انجام شد.";
                                }
                                // Swal.fire(title, "", data.status);
                                Swal.fire({
                                icon: "error",
                                title: title,
                                timer: 1500,
                                showConfirmButton: false
                            });

                                // location.reload();
                                thiz.parents('.cart-product').fadeOut();
                                //      	$(".header-total-quantity,#cart-info-quantity").text($(".header-total-quantity").text() - quantity);


                            },
                            complete: function() {
                                $('.loader').hide();
                            }
                        });
                    }
                });

        });

        //-----------------------------------------------------------
        $("#saveDiscountCard").click(function() {
            event.preventDefault();
            $("#code").removeClass("is-invalid");
            var code = $("#code").val();
            if (code == "") {
                Swal.fire({
                    icon: "error",
                    title: "لطفا ابتدا کد تخفیف را وارد کنید!",
                    timer: 1500,
                    showConfirmButton: false
                });
                $("#code").focus().addClass("is-invalid");
            }
            var sum = $("#cart-info-price").data("value");
            var total = $("#cart-info-total").data("value");
            $.ajax({
                type: 'POST',
                url: "{{ route('cart.storeDiscountCard') }}",
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    code: code,
                    sum: sum,
                },
                success: function(data) {
                    if (data.res == "success") {
                        $("#discountCardRow").hide();
                        $('.cart-info table').find("#cart-info-sum").parents("tr").after(
                            "<tr id='discountCardInfo'><td>تخفیف ویژه</td><td>" + $
                            .number(data.message) + " تومان</td></tr>");
                        $("#cart-info-total").text($.number(total - data.message));
                        $("#total").text($.number(total - data.message));
                        $("#cart-info-total").attr("data-value", total - data.message);
                        Swal.fire({
                            icon: "success",
                            title: "کد تخفیف با موفقیت اعمال شد!",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $("#code").val("");
                    } else if (data.res == "error") {
                         Swal.fire({
                            icon: "error",
                            title: "خطا در اجرای عملیات!",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }

                }
            });
        });
    });
</script>
@endpush
