@extends('shop.layouts.master')
@section('title','صفحه داخلی ترمه سالاری')
@section('content')
    <div class="container mb-5" style="margin-top: 120px">
        <div class="row">
            <div class="col-md-12" style="margin: 0 auto;">
                <div class="card rounded-4 shadow">
                    <div class="card-header rounded-4 bg-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ $article->title }}</h3>
                        <p class="mb-0">{{ Verta($article->created_at)->format('%d %B %Y H:m') }}</p>
                    </div>
                    <div class="card-body">
                        <div>{!! $article->body !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
@endsection
