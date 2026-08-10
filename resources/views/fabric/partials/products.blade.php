@foreach ($fabrics as $key => $fabric)
    <div class="col-12 col-sm-6 col-lg-4 col-item">

        <div class="product-card">
            @if ($fabric->quantity <= 0)
                <div class="discount-squer discount-squer-front"
                    style="position: absolute;top: -7px;left: 20px;z-index:1;">
                    <img src="{{ asset('shop/assets/svgs/outofstock.svg') }}" width="100" alt="discount">
                    <span class="d-flex"
                        style="font-size: 12px;font-weight: 800;position: absolute;right: 11px;top: 7px;">
                        <span class="me-1" style="font-size: 13px;">{{ __('products.out_of_stock') }}</span>
                    </span>
                </div>
            @endif
            <a href="{{ route('fabric.show', [$fabric]) }}">
                <div class="product-img-wrapper">
                    <img src="{{ asset('/storage/images/thumbnails/' . $fabric->images->sortby('ordering')->first()->name) }}"
                        alt="">

                </div>
            </a>

            <div class="card-body">

                <h5 class="product-title">
                    @php
                        $name =
                            (app()->getLocale() == 'fa'
                                ? $fabric->category->title
                                : $fabric->category->e_title) .
                            ' ' .
                            __('products.design') .
                            ' ' .
                            (app()->getLocale() == 'fa'
                                ? $fabric->color_design->design->title
                                : $fabric->color_design->design->e_title) .
                            ' ' .
                            __('products.color') .
                            ' ' .
                            (app()->getLocale() == 'fa'
                                ? $fabric->color_design->color->color
                                : $fabric->color_design->color->e_color);
                    @endphp
                    {{ Str::limit($name, 35) }}
                    {{-- {{ $fabric->category->title }} طرح
                    {{ $fabric->color_design->design->title }} رنگ
                    {{ $fabric->color_design->color->color }} --}}
                </h5>

                <div class="stars text-end">
                    <small class="text-muted ms-2">
                        {{ app()->getLocale() == 'fa' ? $fabric->category->title : $fabric->category->e_title }}
                    </small>
                </div>
                @php
                    $prices = $fabric->prices->where('local', 'تومان')->first();
                @endphp
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
                <small class="text-danger ms-2 mb-2 fs-16">
                    @if ($fabric->quantity > 0 and $fabric->quantity <= 5)
                        <i class="fas fa-bell" style="color: #ef3a4e"></i>
                    @endif
                    @if ($fabric->quantity == 0)
                        <span class="text-white">ا</span>
                    @elseif($fabric->quantity <= 5)
                        {{ __('products.less_than_5') }} .
                    @else
                        <span class="text-white">ا</span>
                    @endif
                </small>
                <div class="product-price w-100 d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex flex-grow-1 align-items-center justify-content-start gap-1">
                        <div class="text-center cell-div">
                            <span class="sell-count d-block">{{ $fabric->orderitems->sum('count') }}</span>
                            <span class="sell-text">{{ __('products.sales') }}</span>
                        </div>
                        <div class="text-center">
                            @php
                                $score =
                                    $fabric->comments()->sum('score') /
                                    ($fabric->comments()->count() > 0 ? $fabric->comments()->count() : 1);
                            @endphp
                            <span class="rate-count d-block">{{ ($score * 100) / 5 }}%</span>
                            <span class="rate-text">{{ __('products.satisfaction') }}</span>
                        </div>
                        <div class="text-center">
                            <span class="rate-count d-block text-success">A</span>
                            <span class="rate-text">{{ __('products.guarantee') }}</span>
                        </div>
                    </div>
                    <div class="d-flex flex-column border-end border-2 pe-2 price-flex-col">
                        @if ($fabric->quantity != 0)
                            @if ($prices->offPrice > 0)
                                <div class="row g-0 ">
                                    <div class="col-8 text-primary text-start ps-1">
                                        <del class="product-price-off">{{ number_format($prices->price) }}</del>
                                    </div>
                                    <div class="col-4"><span class="badge bg-primary product-off">
                                            @if ($prices->offType == 'مبلغ')
                                                {{ round(($prices->offPrice * 100) / $prices->price, 0) }}%
                                            @elseif($prices->offType == 'درصد')
                                                {{ $prices->offPrice }}%
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="row g-0 ">
                                    <div class="col-9 product-price text-start ps-1">
                                        @if ($prices->offType == 'مبلغ')
                                            {{ number_format($prices->price - $prices->offPrice) }}
                                        @elseif($prices->offType == 'درصد')
                                            {{ $prices->price - $prices->price * ($prices->offPrice / 100) }}
                                        @endif
                                    </div>
                                    <div class="col-3 fs-small">
                                        @if (app()->getLocale() == 'fa')
                                            <img src="{{ asset('shop/assets/svgs/price.svg') }}" alt="Price"
                                                width="20px" height="20px">
                                        @else
                                            <img src="{{ asset('shop/assets/svgs/price_e.svg') }}" alt="Price"
                                                width="20px" height="20px">
                                        @endif
                                    </div>
                                </div>
                            @else
                                <span class="price">{{ number_format($prices->price) }}
                                    @if (app()->getLocale() == 'fa')
                                        <img src="{{ asset('shop/assets/svgs/price.svg') }}" alt="Price"
                                            width="20px" height="20px">
                                    @else
                                        <img src="{{ asset('shop/assets/svgs/price_e.svg') }}" alt="Price"
                                            width="20px" height="20px">
                                    @endif
                                </span>
                            @endif
                        @else
                            <a href="#" class="btn btn-tell px-3">{{ __('products.notify_me') }}</a>
                        @endif
                    </div>
                </div>

                {{-- <div class="d-flex justify-content-between align-items-center w-100 mt-auto mb-2">
                    <span class="product-price">
                        @if ($prices->offPrice > 0)
                            <span class="price-down">
                                @if ($prices->offType == 'مبلغ')
                                    {{ number_format(round(($prices->offPrice * 100) / $prices->price, 1)) }}%-
                                @elseif($prices->offType == 'درصد')
                                    {{ number_format($prices->offPrice) }}%-
                                @endif
                            </span>
                        @endif
                        @if ($fabric->quantity > 0)
                            @if ($prices->offPrice > 0)
                                @if ($prices->offType == 'مبلغ')
                                    {{ number_format($prices->price - $prices->offPrice) }}
                                @elseif($prices->offType == 'درصد')
                                    {{ number_format($prices->price - $prices->price * ($prices->offPrice / 100)) }}
                                @endif
                            @else
                                {{ number_format($prices->price) }}
                            @endif
                            تومان
                        @else
                            ناموجود
                        @endif
                    </span>
                </div> --}}
                <div class="row footer_row">
                    <div class="col-7 p-0 pe-2 py-2 pb-3 bg-white">
                        <div class="row g-0">
                            <div class="col-3 d-flex justify-content-start align-items-center">
                                <button
                                    class="buy-button add-to-cart favorites-btn @if ($fabric->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="{{ __('products.add_to_favorites') }}"
                                    data-image="{{ asset('/storage/images/thumbnails/' . $fabric->images->first()->name) }}"
                                    data-moddel="{{ substr($fabric->category->model, 4) }}"
                                    data-design="{{ app()->getLocale() == 'fa' ? $fabric->color_design->design->title : $fabric->color_design->design->e_title ?? '' }}"
                                    data-color="{{ app()->getLocale() == 'fa' ? $fabric->color_design->color->color : $fabric->color_design->color->e_color ?? '' }}"
                                    data-title="{{ app()->getLocale() == 'fa' ? $fabric->category->title : $fabric->category->e_title }}"
                                    data-price="{{ $prices->price }}" data-pay="{{ $price }}"
                                    data-off="{{ $off }}" data-offType="{{ $prices->offType }}"
                                    data-local="{{ $prices->local }}" data-id="{{ $fabric->id }}"
                                    data-model="{{ substr($fabric->category->model, 4) }}"><i
                                        class="fa-regular fa-heart text-danger"></i></button>
                            </div>
                            <div class="col-3 d-flex justify-content-start align-items-center">
                                <button class="buy-button add-to-cart compare" id="" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="{{ __('products.compare_tooltip') }}"
                                    data-image="{{ asset('/storage/images/thumbnails/' . $fabric->images->first()->name) }}"
                                    data-moddel="{{ substr($fabric->category->model, 4) }}"
                                    data-design="{{ app()->getLocale() == 'fa' ? $fabric->color_design->design->title : $fabric->color_design->design->e_title ?? '' }}"
                                    data-color="{{ app()->getLocale() == 'fa' ? $fabric->color_design->color->color : $fabric->color_design->color->e_color ?? '' }}"
                                    data-title="{{ app()->getLocale() == 'fa' ? $fabric->category->title : $fabric->category->e_title }}"
                                    data-price="{{ $prices->price }}" data-pay="{{ $price }}"
                                    data-off="{{ $off }}" data-offType="{{ $prices->offType }}"
                                    data-local="{{ $prices->local }}" data-id="{{ $fabric->id }}"
                                    data-model="{{ substr($fabric->category->model, 4) }}"><i
                                        class="fa-solid fa-shuffle"></i></button>
                            </div>
                            <div class="col-3 d-flex justify-content-start align-items-center">
                                <a href="{{ route('fabric.show', [$fabric->id]) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="{{ __('products.view_product') }}"
                                    class="buy-button add-to-cart d-flex justify-content-center align-items-center text-decoration-none">
                                    <i class="fa-solid fa-eye" style="top: -1px"></i>
                                </a>
                            </div>
                            <div class="col-3 d-flex justify-content-start align-items-center">
                                <button data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="{{ __('products.add_to_cart') }}"
                                    class="buy-button add-to-cart @if ($fabric->quantity != 0) addToCart @endif"
                                    data-image="{{ asset('/storage/images/thumbnails/' . $fabric->images->first()->name) }}"
                                    data-id="{{ $fabric->id }}" data-moddel="Tablecloth"
                                    data-design="{{ app()->getLocale() == 'fa' ? $fabric->color_design->design->title : $fabric->color_design->design->e_title ?? '' }}"
                                    data-color="{{ app()->getLocale() == 'fa' ? $fabric->color_design->color->color : $fabric->color_design->color->e_color ?? '' }}"
                                    data-title="{{ app()->getLocale() == 'fa' ? $fabric->category->title : $fabric->category->e_title }}"
                                    data-price="{{ $prices->price }}" data-pay="{{ $price }}"
                                    data-off="{{ $off }}" data-offType="{{ $prices->offType }}"
                                    data-local="{{ $prices->local }}"><i class="fa-solid fa-cart-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endforeach


{{-- pagination --}}
<div class="col-12 d-flex justify-content-center mt-4">
    {!! $fabrics->withQueryString()->links() !!}
</div>
