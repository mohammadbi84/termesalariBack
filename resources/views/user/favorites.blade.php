@extends('user.user-layout')


@push('link')
@endpush

@section('card-title', 'علاقه مندی ها')
@section('title', 'علاقه مندی ها')

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
                                {{ $favorite->favoriteable->category->title }} طرح
                                {{ $favorite->favoriteable->color_design->design->title }} رنگ
                                {{ $favorite->favoriteable->color_design->color->color }}
                            </h6>
                        </a>
                        <p>
                            @if ($favorite->favoriteable->quantity > 0)
                                @php
                                    $price = $favorite->favoriteable->prices->where('local', 'تومان')->first();
                                @endphp
                                @if ($price->offPrice > 0)
                                    <div class="row">
                                        <div class="col-6">
                                            <del>{{ number_format($price->price) }}</del>
                                        </div>
                                        <div class="col-6">
                                            @if ($price->offType == 'مبلغ')
                                                <span
                                                    id="{{ $price->price - $price->offPrice }}">{{ number_format($price->price - $price->offPrice) }}</span>
                                                تومان
                                            @elseif($price->offType == 'درصد')
                                                <span
                                                    id="{{ $price->price - $price->price * ($price->offPrice / 100) }}">{{ $price->price - $price->price * ($price->offPrice / 100) }}</span>
                                                تومان
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span id="{{ $price->price }}">{{ number_format($price->price) }}</span> تومان
                                @endif
                            @else
                                ناموجود
                            @endif
                        </p>
                        <div class="row">
                            <a class="small col-6" href="{{ route('tablecloth.show', [$favorite->favoriteable->id]) }}">مشاهده
                                محصول <i class="fa fa-chevron-left" style="font-size: 0.7rem;"></i></a>
                            <a href="" class="small col-6 removeFromFavorites" data-id="{{ $favorite->id }}"><i
                                    class="far fa-trash-alt" style="font-size: 0.8rem;"></i> حذف از لیست </a>
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
