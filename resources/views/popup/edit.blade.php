@extends('admin-layout')

@section('title', 'ویرایش پاپ‌آپ')

@push('linkLast')
    <style>
        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .image-preview-item {
            position: relative;
            width: 150px;
            height: 150px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s;
        }

        .image-preview-item:hover {
            border-color: #007bff;
        }

        .image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-info {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            margin-top: 10px;
            border-left: 4px solid #007bff;
        }

        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.8;
            transition: opacity 0.3s;
        }

        .remove-image:hover {
            opacity: 1;
        }

        .existing-image-item {
            border: 2px solid #28a745;
        }

        .new-image-item {
            border: 2px dashed #ffc107;
        }

        .sortable-handle {
            position: absolute;
            top: 5px;
            left: 5px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: move;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-actions {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            padding: 5px;
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .image-actions button {
            background: none;
            border: 1px solid #fff;
            color: white;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 12px;
            cursor: pointer;
        }

        .image-number {
            position: absolute;
            top: 5px;
            left: 5px;
            background: #007bff;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .form-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .section-title {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #343a40;
            font-size: 16px;
        }

        .toast {
            min-width: 300px;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .toast-success {
            background-color: #28a745 !important;
        }

        .toast-error {
            background-color: #dc3545 !important;
        }

        .toast-warning {
            background-color: #ffc107 !important;
            color: #212529;
        }

        .toast-info {
            background-color: #17a2b8 !important;
        }

        .file-drop-zone .file-preview-thumbnails {
            display: flex;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput.min.css') }}"
        media="all">
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput-rtl.min.css') }}"
        media="all">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.css') }}">
@endpush

@section('main-content')
    <section class="content">
        <div class="card col-md-12">
            <div class="card-header p-3">
                <h3 class="card-title">
                    <i class="fas fa-edit ml-2"></i>
                    ویرایش پاپ‌آپ: {{ $popup->title_fa }}
                </h3>
                <div class="card-tools">
                    <a href="{{ route('popup.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-list ml-1"></i>
                        بازگشت به لیست
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('popup.update', $popup->id) }}" enctype="multipart/form-data"
                id="popupEditForm">
                @csrf
                @method('PUT')

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> خطا!</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> موفق!</h5>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- بخش اطلاعات اصلی -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle ml-2"></i>
                            اطلاعات اصلی پاپ‌آپ
                        </h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title_fa" class="font-weight-bold">
                                        عنوان فارسی
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="title_fa" id="title_fa"
                                        class="form-control @error('title_fa') is-invalid @enderror"
                                        placeholder="عنوان فارسی را وارد کنید"
                                        value="{{ old('title_fa', $popup->title_fa) }}" required>
                                    @error('title_fa')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title_en" class="font-weight-bold">عنوان انگلیسی</label>
                                    <input type="text" name="title_en" id="title_en"
                                        class="form-control @error('title_en') is-invalid @enderror"
                                        placeholder="Title (English)" value="{{ old('title_en', $popup->title_en) }}">
                                    @error('title_en')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description_fa" class="font-weight-bold">توضیحات فارسی</label>
                                    <textarea name="description_fa" id="description_fa" class="form-control @error('description_fa') is-invalid @enderror"
                                        rows="3" placeholder="توضیحات فارسی را وارد کنید">{{ old('description_fa', $popup->description_fa) }}</textarea>
                                    @error('description_fa')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description_en" class="font-weight-bold">توضیحات انگلیسی</label>
                                    <textarea name="description_en" id="description_en" class="form-control @error('description_en') is-invalid @enderror"
                                        rows="3" placeholder="Description (English)">{{ old('description_en', $popup->description_en) }}</textarea>
                                    @error('description_en')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="link" class="font-weight-bold">لینک</label>
                                    <select class="form-control select2" name="link" id="link"
                                        data-placeholder="لطفا صفحه مورد نظر خود را انخاب کنید"
                                        style="width: 100%;text-align: right">
                                        @foreach ($articles as $article)
                                            <option value="{{ $article->id }}"
                                                {{ $popup->link == $article->id ? 'selected' : '' }}>
                                                {{ $article->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('link')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold d-block">وضعیت فعلی</label>
                                    <div
                                        class="alert alert-{{ $popup->is_currently_active ? 'success' : 'warning' }} mb-0">
                                        <i
                                            class="fas {{ $popup->is_currently_active ? 'fa-check-circle' : 'fa-exclamation-triangle' }} ml-2"></i>
                                        {{ $popup->is_currently_active ? '✅ پاپ‌آپ فعال و در حال نمایش' : '⚠️ پاپ‌آپ غیرفعال یا خارج از بازه زمانی' }}
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <!-- بخش تصاویر موجود -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-images ml-2"></i>
                            تصاویر موجود ({{ $popup->images->count() }} تصویر)
                        </h4>

                        @if ($popup->images->count() > 0)
                            <div class="row">
                                @foreach ($popup->images as $image)
                                    <div class="col-md-3 mb-3" data-image-id="{{ $image->id }}">
                                        <div class="image-info p-2">
                                            <img src="{{ asset($image->image) }}" class="img-fluid mb-2" alt="">

                                            <div class="form-group">
                                                <label>ترتیب نمایش</label>
                                                <input type="number" name="images_order[{{ $image->id }}]"
                                                    value="{{ old('images_order.' . $image->id, $image->order ?? 0) }}"
                                                    class="form-control" placeholder="مثلاً 1">
                                            </div>

                                            <div class="form-group">
                                                <label>زمان نمایش (ثانیه)</label>
                                                <input type="number" name="images_delay[{{ $image->id }}]"
                                                    value="{{ old('images_delay.' . $image->id, $image->duration / 1000 ?? 3) }}"
                                                    class="form-control" placeholder="مثلاً 3">
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-danger btn-sm remove-existing-image"
                                                    data-id="{{ $image->id }}"
                                                    data-url="{{ route('popup.deleteImage', $image->id) }}">
                                                    <i class="fas fa-trash-alt ml-1"></i>
                                                    حذف تصویر
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle ml-2"></i>
                                هیچ تصویری برای این پاپ‌آپ وجود ندارد.
                            </div>
                        @endif
                    </div>

                    <!-- بخش افزودن تصاویر جدید -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-plus-circle ml-2"></i>
                            افزودن تصاویر جدید
                        </h4>

                        <div class="form-group">
                            <label for="image" class="font-weight-bold">تصاویر جدید</label>
                            <div class="custom-file">
                                <input type="file" name="images[]" id="image"
                                    class="custom-file-input d-none @error('images') is-invalid @enderror" multiple
                                    accept="image/*">
                                {{-- <label class="custom-file-label" for="image">انتخاب تصاویر جدید...</label> --}}
                            </div>
                            <small class="form-text text-muted">
                                حداکثر حجم هر تصویر: ۲ مگابایت | فرمت‌های مجاز: jpg, png, gif, webp
                            </small>
                            @error('images')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                            @error('images.*')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- پیش‌نمایش تصاویر جدید -->
                        <div id="newImagesPreviewContainer" class="image-preview-container"></div>

                        <!-- اطلاعات تصاویر جدید -->
                        <div id="newImagesInfoContainer" class="image-info-container mt-3"></div>
                    </div>

                    <!-- بخش تنظیمات زمان -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-clock ml-2"></i>
                            تنظیمات زمان نمایش
                        </h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="popup_sort" class="font-weight-bold">ترتیب نمایش پاپ‌آپ</label>
                                    <input type="number" name="sort" id="popup_sort"
                                        class="form-control @error('sort') is-invalid @enderror"
                                        value="{{ old('sort', $popup->sort ?? 0) }}"
                                        placeholder="عدد بزرگتر = بعدی نمایش داده شود">
                                    @error('sort')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_at" class="font-weight-bold">تاریخ و زمان شروع</label>
                                    <input type="text" name="start_at" id="start_at"
                                        class="form-control date @error('start_at') is-invalid @enderror"
                                        value="{{ old('start_at', $popup->start_at ? $popup->start_at->format('Y/m/d H:i:s') : '') }}">
                                    @error('start_at')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">در صورت خالی بودن، از همین لحظه نمایش داده می‌شود</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_at" class="font-weight-bold">تاریخ و زمان پایان</label>
                                    <input type="text" name="end_at" id="end_at"
                                        class="form-control date @error('end_at') is-invalid @enderror"
                                        value="{{ old('end_at', $popup->end_at ? $popup->end_at->format('Y/m/d H:i:s') : '') }}">
                                    @error('end_at')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">در صورت خالی بودن، همیشه نمایش داده می‌شود</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="is_active" id="is_active" value="1"
                                    class="custom-control-input"
                                    {{ old('is_active', $popup->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="is_active">
                                    پاپ‌آپ فعال باشد
                                </label>
                            </div>
                            <small class="text-muted">در صورت غیرفعال بودن، پاپ‌آپ نمایش داده نمی‌شود حتی اگر در بازه زمانی
                                باشد</small>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light">
                    <div class="row">
                        <div class="col-md-8 align-items-center">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle ml-2"></i>
                                آخرین ویرایش:
                                {{ verta($popup->updated_at)->format('Y/m/d H:i') }}
                                | ایجاد شده در:
                                {{ verta($popup->created_at)->format('Y/m/d H:i') }}
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center justify-content-end">
                            <button type="submit" class="btn btn-success ml-2">
                                <i class="fas fa-save ml-2"></i>
                                ذخیره تغییرات
                            </button>
                            <a href="{{ route('popup.index') }}" class="btn btn-outline-secondary mr-2">
                                <i class="fas fa-times ml-2"></i>
                                انصراف
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('js')
    <!-- SortableJS برای مرتب‌سازی -->
    <script src="https://lib.arvancloud.ir/Sortable/1.9.0/Sortable.min.js"></script>
    <script src="https://lib.arvancloud.ir/sweetalert2/9.17.4/sweetalert2.all.js"></script>
    <script src="{{ asset('../storetemplate/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/piexif.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/purify.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/themes/fas/theme.min.js') }}"></script>
    <script src="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/js/locales/fa.js') }}"></script>

    <script src="{{ asset('/storetemplate/plugins/datepicker-master/persian-date.min.js') }}"></script>
    <script src="{{ asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.js') }}"></script>
    <script>
        $('.select2').select2();
    </script>
    <script>
        $(document).ready(function() {
            // برای start_at
            var startVal = $('#start_at').val();
            $('#start_at').pDatepicker({
                onlySelectOnDate: true,
                autoClose: true,
                responsive: true,
                initialValueType: 'gregorian',
                persianDigit: false,
                format: 'YYYY/MM/DD H:m:s',
                timePicker: {
                    enabled: true
                },
                monthPicker: {
                    enabled: true,
                    titleFormat: "YYYY"
                },
                yearPicker: {
                    enabled: true,
                    titleFormat: "YYYY"
                },
            });
            $('#start_at').val(startVal);

            // برای end_at
            var endVal = $('#end_at').val();
            $('#end_at').pDatepicker({
                onlySelectOnDate: true,
                autoClose: true,
                responsive: true,
                initialValueType: 'gregorian',
                persianDigit: false,
                format: 'YYYY/MM/DD H:m:s',
                timePicker: {
                    enabled: true
                },
                monthPicker: {
                    enabled: true,
                    titleFormat: "YYYY"
                },
                yearPicker: {
                    enabled: true,
                    titleFormat: "YYYY"
                },
            });
            $('#end_at').val(endVal);


            $("#image").fileinput({
                // initialPreview: popupImages,
                initialPreviewAsData: true,
                initialPreviewShowDelete: false,
                previewTemplates: {
                    // ما از پیش‌نمایش پیش‌فرض استفاده میکنیم و فقط info اضافه میکنیم
                    image: `
                    <div class="file-preview-frame kv-preview-thumb">
                        <div class="kv-file-content">
                            <img src="{data}" class="file-preview-image" style="width:auto;height:120px;">
                        </div>
                        <div class="file-thumbnail-footer">
                            <div class="file-caption-name">{caption}</div>
                            <div class="image-extra-fields mt-1">
                                <input type="number" name="new_images_order[]" placeholder="ترتیب" class="form-control mb-1" style="width: 80px; display:inline-block;">
                                <input type="number" name="new_images_delay[]" placeholder="زمان (ثانیه)" class="form-control" style="width: 80px; display:inline-block;">
                            </div>
                        </div>
                    </div>`
                },

                uploadAsync: false,
                initialPreviewFileType: 'image',

                overwriteInitial: false, // ❗ خیلی مهم (چند عکس)
                enableResumableUpload: true,

                showCaption: false,
                maxFileCount: 10, // یا هر تعدادی که میخوای
                showCancel: false,
                showUpload: false,

                browseOnZoneClick: true,
                allowedFileTypes: ["image"],
                allowedFileExtensions: ["jpg", "png", "jpeg"],

                browseLabel: "انتخاب تصاویر پاپ آپ",
                theme: 'fas',
                browseClass: "btn btn-primary",
                rtl: true,
                language: "fa",

                layoutTemplates: {
                    main1: "{preview}\n" +
                        "<div class='input-group {class}'>\n" +
                        "   <div class='input-group-btn input-group-prepend'>\n" +
                        "       {browse}\n" +
                        "   </div>\n" +
                        "   {caption}\n" +
                        "</div>"
                },
            });



            $(document).on('click', '.remove-existing-image', function(e) {
                e.preventDefault();

                const imageId = $(this).data('id');
                const url = $(this).data('url');
                const imageElement = $(`[data-image-id="${imageId}"]`);

                if (confirm('آیا از حذف این تصویر اطمینان دارید؟ این عمل قابل بازگشت نیست.')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                // حذف از DOM
                                imageElement.remove();
                                $(`#info_${imageId}`).remove();
                            }
                        },
                        error: function(xhr) {
                            const error = xhr.responseJSON?.message || 'خطا در حذف تصویر';
                            showToast('error', error);
                        }
                    });
                }
            });
        });
    </script>
@endpush
