@extends('user.user-layout')


@push('link')
@endpush

@section('card-title', __('user.favorites.card_title'))
@section('title', __('user.favorites.title'))

@section('user-content')
    <div class="row">
        @isset($favorites)
            @foreach ($favorites as $favorite)
                <div class="media mb-4 col-md-12 col-sm-12 col-lg-6">
                    @php $image = $favorite->favoriteable->images->first(); @endphp
                    <a href="{{ route('tablecloth.show', [$favorite->favoriteable->id]) }}">
                        <img class="media-left pl-3" style="width: 200px" alt="Image"
                            src="{{ asset('storage/images/thumbnails/' . $image['name']) }}">
                    </a>
                    <div class="media-body">
                        <a
                            href="
               @switch($favorite->favoriteable_type)
                  @case('App\Tablecloth')
                    {{ route('tablecloth.show', [$favorite->favoriteable->id]) }}
                    @break
                  @case('App\Shoe')
                    {{ route('shoe.show', [$favorite->favoriteable->id]) }}
                    @break
              @endswitch
            ">
                            <h6 class="pb-2" style="color:black; line-height: 2rem;">
                                {{ app()->getLocale() == 'fa' ? $favorite->favoriteable->category->title : $favorite->favoriteable->category->e_title }} {{ __('user.favorites.design') }}
                                {{ app()->getLocale() == 'fa' ? $favorite->favoriteable->color_design->design->title : $favorite->favoriteable->color_design->design->e_title }} {{ __('user.favorites.color') }}
                                {{ app()->getLocale() == 'fa' ? $favorite->favoriteable->color_design->color->color : $favorite->favoriteable->color_design->color->e_color }}
                            </h6>
                        </a>
                        <p>
                            @if ($favorite->favoriteable->quantity > 0)
                                @php $price = $favorite->favoriteable->prices->where('local', 'تومان')->first(); @endphp
                                @if ($price->offPrice > 0)
                                    <div class="row">
                                        <div class="col-6"><del>{{ number_format($price->price) }}</del></div>
                                        <div class="col-6">
                                            @if ($price->offType == 'مبلغ')
                                                <span>{{ number_format($price->price - $price->offPrice) }}</span>
                                                {{ __('user.favorites.product.price_unit') }}
                                            @elseif($price->offType == 'درصد')
                                                <span>{{ number_format($price->price - $price->price * ($price->offPrice / 100)) }}</span>
                                                {{ __('user.favorites.product.price_unit') }}
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span>{{ number_format($price->price) }}</span>
                                    {{ __('user.favorites.product.price_unit') }}
                                @endif
                            @else
                                {{ __('user.favorites.product.out_of_stock') }}
                            @endif
                        </p>
                        <div class="row">
                            <a class="small col-6" href="{{ route('tablecloth.show', [$favorite->favoriteable->id]) }}">
                                {{ __('user.favorites.product.view_product') }} <i class="fa fa-chevron-left"
                                    style="font-size: 0.7rem;"></i>
                            </a>
                            <a href="" class="small col-6 removeFromFavorites" data-id="{{ $favorite->id }}">
                                <i class="far fa-trash-alt" style="font-size: 0.8rem;"></i>
                                {{ __('user.favorites.product.remove_from_list') }}
                            </a>
                        </div>

                    </div>

                </div>
            @endforeach
        @endisset
    </div>

@endsection


@push('js')
    <script src="{{ asset('/storetemplate/dist/js/favorite.js') }}"></script>
@endpush
