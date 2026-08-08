@extends('admin-layout')

@section('title', 'پنل مدیریت | ثبت شیوه ارسال جدید')

@push('link')
@endpush

@section('main-content')
    <section class="content">
        <div class="row">

            <div class="card col-md-12 col-sm-12">
                <div class="card-header">
                    <div class="card-title">
                        <span>ثبت شیوه ارسال جدید</span>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form" role="form" action="{{ route('post.update',[$post]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
						@method('put')
                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="لطفا عنوان را وارد کنید." value="{{ old('title', $post->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">هزینه ارسال <small>( تومان )</small></label>
                            <input type="text" name="price" id="price"
                                class="form-control @error('price') is-invalid @enderror"
                                placeholder="لطفا هزینه ارسال را وارد کنید." value="{{ old('price', $post->price) }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="delivery_time">زمان ارسال</label>
                            <input type="text" name="delivery_time" id="delivery_time"
                                class="form-control @error('delivery_time') is-invalid @enderror"
                                placeholder="لطفا زمان ارسال را وارد کنید."
                                value="{{ old('delivery_time', $post->delivery_time) }}">
                            @error('delivery_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-flat btn-primary">ثبت اطلاعات</button>
                        <a href="{{ route('post.index') }}" class="btn btn flat btn-secondary">بازگشت</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        $(function() {

        }) //End
    </script>
@endpush
