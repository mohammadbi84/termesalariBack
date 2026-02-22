@extends('admin-layout')

@section('title', 'تنظیمات نشان اصالت محصول')

@push('link')
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput-rtl.min.css') }}">
@endpush

@section('main-content')
    <section class="content">
        <div class="row">
            <div class="col-12">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('danger'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session('danger') }}
                    </div>
                @endif

                <div class="card col-md-10 col-sm-12">
                    <div class="card-header">
                        <div class="card-title">تنظیمات بخش نشان اصالت محصول</div>
                    </div>

                    <form action="{{ route('product-authenticity.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">

                            {{-- ================= فارسی ================= --}}
                            <h5 class="mb-3 text-primary">محتوای فارسی</h5>

                            <div class="form-group">
                                <label>عنوان (فارسی)</label>
                                <input type="text" name="title_fa" class="form-control"
                                    value="{{ old('title_fa', $section->title_fa ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label>توضیحات (فارسی)</label>
                                <textarea name="description_fa" rows="4" class="form-control">{{ old('description_fa', $section->description_fa ?? '') }}</textarea>
                            </div>

                            <hr>

                            {{-- ================= انگلیسی ================= --}}
                            <h5 class="mb-3 text-primary">محتوای انگلیسی</h5>

                            <div class="form-group">
                                <label>Title (English)</label>
                                <input type="text" name="title_en" class="form-control"
                                    value="{{ old('title_en', $section->title_en ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label>Description (English)</label>
                                <textarea name="description_en" rows="4" class="form-control">{{ old('description_en', $section->description_en ?? '') }}</textarea>
                            </div>

                            <hr>

                            {{-- تصویر اصلی --}}
                            <div class="form-group">
                                <label>تصویر اصلی</label>
                                <div class="file-loading">
                                    <input id="image" name="image" type="file">
                                </div>
                            </div>

                            {{-- بک گراند --}}
                            <div class="form-group">
                                <label>تصویر بک‌گراند</label>
                                <div class="file-loading">
                                    <input id="background_image" name="background_image" type="file">
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/themes/fas/theme.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/js/locales/fa.js') }}"></script>

    <script>
        $("#image").fileinput({
            theme: "fas",
            language: "fa",
            showUpload: false,
            rtl: true,
            initialPreview: [
                @if (isset($section) && $section->image)
                    "{{ asset('storage/' . $section->image) }}"
                @endif
            ],
            initialPreviewAsData: true,
            initialPreviewFileType: "image",
            allowedFileExtensions: ["jpg", "png", "jpeg", "webp"]
        });

        $("#background_image").fileinput({
            theme: "fas",
            language: "fa",
            showUpload: false,
            rtl: true,
            initialPreview: [
                @if (isset($section) && $section->background_image)
                    "{{ asset('storage/' . $section->background_image) }}"
                @endif
            ],
            initialPreviewAsData: true,
            initialPreviewFileType: "image",
            allowedFileExtensions: ["jpg", "png", "jpeg", "webp"]
        });
    </script>
@endpush
