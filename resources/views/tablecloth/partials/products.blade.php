@foreach ($tablecloths as $key => $tablecloth)

    <div class="col-12 col-sm-6 col-lg-4 col-item">

        <div class="product-card {{ $tablecloth->quantity <= 0 ? 'out-of-stock' : '' }}">

            <a href="{{ route('tablecloth.show', [$tablecloth]) }}">
                <div class="product-img-wrapper">

                    @if ($tablecloth->quantity <= 0)
                        <div class="out-of-stock-badge">ناموجود</div>
                    @endif

                    <img src="{{ asset('/storage/images/thumbnails/'.$tablecloth->images->sortby('ordering')->first()->name) }}" alt="">

                </div>
            </a>

            <div class="card-body">

                <h5 class="product-title">
                    {{ $tablecloth->category->title }} طرح
                    {{ $tablecloth->color_design->design->title }} رنگ
                    {{ $tablecloth->color_design->color->color }}
                </h5>

                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center w-100 mt-auto">

                    <span class="product-price">
                        @php
                            $prices = $tablecloth->prices->where('local', 'تومان')->first();
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

                    <button class="btn btn-custom btn-sm product-action"
                        {{ $tablecloth->quantity <= 0 ? 'disabled' : '' }}>
                        <i class="fas fa-cart-plus"></i>
                        {{ $tablecloth->quantity <= 0 ? 'ناموجود' : 'خرید' }}
                    </button>

                </div>

            </div>

        </div>

    </div>
@endforeach


{{-- pagination --}}
<div class="col-12 d-flex justify-content-center mt-4">
    {!! $tablecloths->withQueryString()->links() !!}
</div>
