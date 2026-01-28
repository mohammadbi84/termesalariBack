@extends('admin-layout')

@section('title', 'پنل مدیریت | ویرایش صفحه داخلی')

@push('link')
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput.min.css') }}"
        media="all">
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput-rtl.min.css') }}"
        media="all">
    <link href="https://lib.arvancloud.ir/summernote/0.8.9/summernote-lite.css" rel="stylesheet">

@endpush

@section('main-content')
    <section class="content">
        <div class="row">
            <div class="card col-md-12 col-sm-12">
                <div class="card-header">
                    <div class="card-title">
                        <span>ویرایش {{ $article->title }}</span>
                    </div>
                </div>
                <div class="card-body">
                    {{-- {{ dd($products) }} --}}
                    <form class="form" role="form" action="{{ route('article.update', $article->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group @error('title') is-invalid @enderror">
                            <label for="title">عنوان صفحه</label>
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="لطفا عنوان صفحه را وارد کنید." value="{{ old('title', $article->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group @error('body') is-invalid @enderror">
                            <label for="body">محتوای صفحه</label>
                            <textarea name="body" id="body" class="form-control" rows="5">{{ old('body', $article->body) }}</textarea>

                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

    <script src="https://lib.arvancloud.ir/summernote/0.8.9/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#body').summernote({
                placeholder: 'محتوای صفحه را اینجا وارد کنید ...',
                tabsize: 2,
                height: 200
            });
        });
    </script>
@endpush
