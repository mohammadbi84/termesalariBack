@extends('admin-layout')

@section('title', 'تنظیمات گواهی‌های ثبت شده')

@push('link')
    <link rel="stylesheet" href="{{ asset('storetemplate/plugins/bootstrap-fileinput-master/css/fileinput.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('storetemplate/plugins/bootstrap-fileinput-master/css/fileinput-rtl.min.css') }}">
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
                                {{-- <div class="file-loading">
                                    <input id="certificates" name="certificates[]" type="file" multiple>
                                </div> --}}
                                <div id="image-repeater" class="mb-2">
                                    <div class="image-picker-row mb-2">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a data-input="thumbnail_1" data-preview="holder_1"
                                                    class="lfm btn btn-primary">
                                                    <i class="fa fa-picture-o"></i> انتخاب تصویر
                                                </a>
                                            </span>
                                            <input id="thumbnail_1" class="form-control" type="text"
                                                name="certificates[]" placeholder="مسیر تصویر را انتخاب کنید">
                                            <button type="button" class="btn btn-danger remove-image-picker"
                                                aria-label="حذف این تصویر">-</button>
                                        </div>
                                        <img id="holder_1" style="margin-top:10px;max-height:100px;display:block;">
                                    </div>
                                </div>
                                <button type="button" id="add-image-picker" class="btn btn-sm btn-outline-primary mb-3">
                                    <i class="fa fa-plus"></i> افزودن تصویر جدید
                                </button>
                                @error('certificates')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
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
    <script src="{{ asset('storetemplate/plugins/bootstrap-fileinput-master/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('storetemplate/plugins/bootstrap-fileinput-master/themes/fas/theme.min.js') }}"></script>
    <script src="{{ asset('storetemplate/plugins/bootstrap-fileinput-master/js/locales/fa.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/lfm.js') }}"></script>
    <script>
        $(function() {
            var imageCounter = 1;

            function initImagePicker(row) {
                if (!row || !row.length) {
                    return;
                }

                row.find('.lfm').filemanager('image');

                row.find('.remove-image-picker').off('click').on('click', function() {
                    var $rows = $('#image-repeater .image-picker-row');
                    if ($rows.length > 1) {
                        $(this).closest('.image-picker-row').remove();
                    } else {
                        var $row = $(this).closest('.image-picker-row');
                        $row.find('input[name="certificates[]"]').val('');
                        $row.find('img').attr('src', '');
                    }
                });
            }

            function addImagePicker() {
                imageCounter++;

                var $row = $(
                    '<div class="image-picker-row mb-2">' +
                    '    <div class="input-group">' +
                    '        <span class="input-group-btn">' +
                    '            <a data-input="thumbnail_' + imageCounter + '" data-preview="holder_' +
                    imageCounter + '" class="lfm btn btn-primary">' +
                    '                <i class="fa fa-picture-o"></i> انتخاب تصویر' +
                    '            </a>' +
                    '        </span>' +
                    '        <input id="thumbnail_' + imageCounter +
                    '" class="form-control" type="text" name="certificates[]" placeholder="مسیر تصویر را انتخاب کنید">' +
                    '        <button type="button" class="btn btn-danger remove-image-picker" aria-label="حذف این تصویر">-</button>' +
                    '    </div>' +
                    '    <img id="holder_' + imageCounter +
                    '" style="margin-top:10px;max-height:100px;display:block;">' +
                    '</div>'
                );

                $('#image-repeater').append($row);
                initImagePicker($row);
            }

            initImagePicker($('#image-repeater .image-picker-row'));
            $('#add-image-picker').on('click', addImagePicker);
        });
    </script>
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
