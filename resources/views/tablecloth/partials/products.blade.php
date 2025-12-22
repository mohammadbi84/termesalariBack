@foreach ($tablecloths as $key => $tablecloth)
    <div class="col-12 col-sm-6 col-lg-4 col-item">

        <div class="product-card {{ $tablecloth->quantity <= 0 ? 'out-of-stock' : '' }}">

            <a href="{{ route('tablecloth.show', [$tablecloth]) }}">
                <div class="product-img-wrapper">

                    @if ($tablecloth->quantity <= 0)
                        <div class="out-of-stock-badge">ناموجود</div>
                    @endif

                    <img src="{{ asset('/storage/images/thumbnails/' . $tablecloth->images->sortby('ordering')->first()->name) }}"
                        alt="">

                </div>
            </a>

            <div class="card-body">

                <h5 class="product-title">
                    {{ $tablecloth->category->title }} طرح
                    {{ $tablecloth->color_design->design->title }} رنگ
                    {{ $tablecloth->color_design->color->color }}
                </h5>

                <div class="stars text-start">
                    @php
                        $score =
                            $tablecloth->comments()->sum('score') /
                            ($tablecloth->comments()->count() > 0 ? $tablecloth->comments()->count() : 1);
                    @endphp
                    @for ($i = 0; $i < 5; $i++)
                        @if ($i < $score ?? 0)
                            <i class="fa-solid fa-star"></i>
                        @else
                            <i class="fa-regular fa-star"></i>
                        @endif
                    @endfor
                    {{-- <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i> --}}
                </div>

                <div class="d-flex justify-content-between align-items-center w-100 mt-auto mb-2">

                    <span class="product-price">
                        @php
                            $prices = $tablecloth->prices->where('local', 'تومان')->first();
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
                        @if ($prices->offPrice > 0)
                            <span class="price-down">
                                @if ($prices->offType == 'مبلغ')
                                    {{ number_format(round(($prices->offPrice * 100) / $prices->price, 1)) }}%-
                                @elseif($prices->offType == 'درصد')
                                    {{ number_format($prices->offPrice) }}%-
                                @endif
                            </span>
                        @endif
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
                    </span>

                    {{-- <button class="btn btn-custom btn-sm product-action"
                        {{ $tablecloth->quantity <= 0 ? 'disabled' : '' }}>
                        <i class="fas fa-cart-plus"></i>
                        {{ $tablecloth->quantity <= 0 ? 'ناموجود' : 'خرید' }}
                    </button> --}}

                </div>
                <div class="row g-0 w-100">
                    <div class="col-3 ps-2">
                        <button class="buy-button add-to-cart @if ($tablecloth->quantity != 0) addToCart @endif"
                            data-image="{{ asset('/storage/images/thumbnails/' . $tablecloth->images->first()->name) }}"
                            data-id="{{ $tablecloth->id }}" data-moddel="Tablecloth"
                            data-design="{{ $tablecloth->color_design->design->title ?? '' }}"
                            data-color="{{ $tablecloth->color_design->color->color ?? '' }}"
                            data-title="{{ $tablecloth->title }}" data-price="{{ $prices->price }}"
                            data-pay="{{ $price }}" data-off="{{ $off }}"
                            data-offType="{{ $prices->offType }}" data-local="{{ $prices->local }}"><i
                                class="fa-solid fa-cart-plus"></i></button>
                    </div>
                    <div class="col-9 pe-2">
                        <a href="{{ route('tablecloth.show', [$tablecloth->id]) }}"
                            class="buy-button text-decoration-none">مشاهده</a>
                        <span class="fs-10 p-0">
                            @if ($tablecloth->quantity == 0)
                                اتمام موجودی در انبار
                            @elseif($tablecloth->quantity <= 5)
                                کمتر از 5 عدد موجود می باشد .
                            @endif
                        </span>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endforeach


{{-- pagination --}}
<div class="col-12 d-flex justify-content-center mt-4">
    {!! $tablecloths->withQueryString()->links() !!}
</div>
