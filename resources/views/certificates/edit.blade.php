@extends('admin-layout')

@section('title', 'تنظیمات گواهی‌های ثبت شده')

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
                        <div class="card-title">تنظیمات بخش گواهی‌ها</div>
                    </div>

                    <form action="{{ route('certificate.update') }}" method="POST" enctype="multipart/form-data">
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

                            {{-- ================= تصاویر موجود ================= --}}
                            <h5 class="mb-3 text-success">گواهی‌های فعلی</h5>

                            <div class="row">
                                @if (isset($section) && $section->certificates->count())
                                    @foreach ($section->certificates as $certificate)
                                        <div class="col-md-3 mb-3 text-center certificate-item">
                                            <img src="{{ asset('storage/' . $certificate->image) }}" class="img-fluid mb-2"
                                                style="height:150px;object-fit:contain;border:1px solid #ddd;padding:5px;">

                                            <button type="button" class="btn btn-sm btn-danger btn-remove-certificate"
                                                data-id="{{ $certificate->id }}">
                                                حذف
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 text-muted">گواهی‌ای ثبت نشده است.</div>
                                @endif
                            </div>

                            <hr>

                            {{-- ================= آپلود جدید ================= --}}
                            <div class="form-group">
                                <label>افزودن گواهی جدید</label>
                                <div class="file-loading">
                                    <input id="certificates" name="certificates[]" type="file" multiple>
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
        $("#certificates").fileinput({
            theme: "fas",
            language: "fa",
            showUpload: false,
            rtl: true,
            allowedFileExtensions: ["jpg", "png", "jpeg", "webp"],
            maxFileCount: 20
        });


        // حذف تکی گواهی (AJAX)
        $('.btn-remove-certificate').click(function() {

            let button = $(this);
            let id = button.data('id');

            if (!confirm('آیا مطمئن هستید؟')) return;

            $.ajax({
                url: '/certificates/delete/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    button.closest('.certificate-item').remove();
                }
            });

        });
    </script>
@endpush
