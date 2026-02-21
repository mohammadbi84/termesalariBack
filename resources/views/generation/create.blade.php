@extends('admin-layout')

@section('title', 'پنل مدیریت | ایجاد خاندان ترمه سالاری')

@push('link')
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput.min.css') }}"
        media="all">
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput-rtl.min.css') }}"
        media="all">
@endpush

@section('main-content')
    <section class="content">
        <div class="row">
            <div class="card col-md-12 col-sm-12">
                <div class="card-header">
                    <div class="card-title">
                        <span>ایجاد خاندان ترمه سالاری</span>
                    </div>
                </div>
                <div class="card-body">
                    {{-- {{ dd($products) }} --}}
                    <form class="form" role="form" action="{{ route('generation.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 @error('name_fa') is-invalid @enderror">
                                <label for="name_fa">نام (فارسی)</label>
                                <input type="text" name="name_fa" id="name_fa" class="form-control"
                                    placeholder="لطفا نام فارسی را وارد کنید." value="{{ old('name_fa') }}">
                                @error('name_fa')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 @error('name_en') is-invalid @enderror">
                                <label for="name_en">نام (انگلیسی)</label>
                                <input type="text" name="name_en" id="name_en" class="form-control"
                                    placeholder="لطفا نام انگلیسی را وارد کنید." value="{{ old('name_en') }}">
                                @error('name_en')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 @error('pretext_fa') is-invalid @enderror">
                                <label for="pretext_fa">عنوان (فارسی)</label>
                                <input type="text" name="pretext_fa" id="pretext_fa" class="form-control"
                                    placeholder="لطفا عنوان فارسی را وارد کنید." value="{{ old('pretext_fa') }}">
                                @error('pretext_fa')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 @error('pretext_en') is-invalid @enderror">
                                <label for="pretext_en">عنوان (انگلیسی)</label>
                                <input type="text" name="pretext_en" id="pretext_en" class="form-control"
                                    placeholder="لطفا عنوان انگلیسی را وارد کنید." value="{{ old('pretext_en') }}">
                                @error('pretext_en')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 @error('description_fa') is-invalid @enderror">
                                <label for="description_fa">توضیحات (فارسی)</label>
                                <textarea class="form-control" name="description_fa" id="description_fa" rows="3">{{ old('description_fa') }}</textarea>
                                @error('description_fa')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 @error('description_en') is-invalid @enderror">
                                <label for="description_en">توضیحات (انگلیسی)</label>
                                <textarea class="form-control" name="description_en" id="description_en" rows="3">{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 @error('image') is-invalid @enderror">
                                <label for="image">عکس</label>
                                <input type="file" name="image" id="image" class="form-control" data-show-upload="false" data-show-caption="true"
                                    data-msg-placeholder="انتخاب عکس" accept="image/*">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <button type="submit" class="btn btn-flat btn-primary">ثبت اطلاعات</button>
                        <a href="{{ route('article.index') }}" class="btn btn flat btn-secondary">بازگشت</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/piexif.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/purify.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/themes/fas/theme.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/js/locales/fa.js') }}"></script>
@endpush
