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
    </style>
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/select2/select2.min.css') }}">

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
                            <div id="existingImagesContainer" class="image-preview-container">
                                @foreach ($popup->images->sortBy('order') as $index => $image)
                                    <div class="image-preview-item existing-image-item"
                                        data-image-id="{{ $image->id }}">
                                        <div class="image-number">{{ $index + 1 }}</div>
                                        <img src="{{ asset($image->image) }}" class="image-preview"
                                            alt="تصویر {{ $index + 1 }}">

                                        <div class="image-actions">
                                            <button type="button" class="btn-delete-image" data-id="{{ $image->id }}"
                                                data-url="{{ route('popup.deleteImage', $image->id) }}"
                                                title="حذف تصویر">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- اطلاعات مخفی برای فرم -->
                                        <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                                        <input type="hidden" name="existing_orders[]" value="{{ $image->order }}"
                                            id="order_{{ $image->id }}">
                                        <input type="hidden" name="existing_durations[]" value="{{ $image->duration }}"
                                            id="duration_{{ $image->id }}">
                                    </div>
                                @endforeach
                            </div>

                            <!-- فرم ویرایش اطلاعات تصاویر موجود -->
                            <div class="mt-4">
                                <h5><i class="fas fa-edit ml-2"></i> ویرایش اطلاعات تصاویر موجود</h5>
                                <div id="existingImagesInfo" class="mt-3">
                                    @foreach ($popup->images->sortBy('order') as $index => $image)
                                        <div class="image-info mb-3" id="info_{{ $image->id }}">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>تصویر {{ $index + 1 }}</label>
                                                    <div class="text-center">
                                                        <img src="{{ asset($image->image) }}"
                                                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                                        <p class="small text-muted mt-1">{{ basename($image->image) }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>ترتیب نمایش</label>
                                                    <input type="number" class="form-control order-input"
                                                        data-image-id="{{ $image->id }}" value="{{ $image->order }}"
                                                        min="0">
                                                    <small class="text-muted">عدد کمتر = نمایش زودتر</small>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>مدت نمایش (میلی‌ثانیه)</label>
                                                    <input type="number" class="form-control duration-input"
                                                        data-image-id="{{ $image->id }}"
                                                        value="{{ $image->duration ?? 5000 }}" min="1000"
                                                        step="500">
                                                    <small class="text-muted">1000 = 1 ثانیه</small>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>عملیات</label>
                                                    <div class="mt-2">
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger btn-block btn-delete-image"
                                                            data-id="{{ $image->id }}"
                                                            data-url="{{ route('popup.deleteImage', $image->id) }}">
                                                            <i class="fas fa-trash ml-1"></i>
                                                            حذف تصویر
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
                            <label for="new_images" class="font-weight-bold">تصاویر جدید</label>
                            <div class="custom-file">
                                <input type="file" name="images[]" id="new_images"
                                    class="custom-file-input @error('images') is-invalid @enderror" multiple
                                    accept="image/*">
                                <label class="custom-file-label" for="new_images">انتخاب تصاویر جدید...</label>
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
                                    <label for="start_at" class="font-weight-bold">تاریخ و زمان شروع</label>
                                    <input type="datetime-local" name="start_at" id="start_at"
                                        class="form-control @error('start_at') is-invalid @enderror"
                                        value="{{ old('start_at', $popup->start_at ? $popup->start_at->format('Y-m-d\TH:i') : '') }}">
                                    @error('start_at')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">در صورت خالی بودن، از همین لحظه نمایش داده می‌شود</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_at" class="font-weight-bold">تاریخ و زمان پایان</label>
                                    <input type="datetime-local" name="end_at" id="end_at"
                                        class="form-control @error('end_at') is-invalid @enderror"
                                        value="{{ old('end_at', $popup->end_at ? $popup->end_at->format('Y-m-d\TH:i') : '') }}">
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
    <script>
        $('.select2').select2();

    </script>

    <script>
        $(document).ready(function() {
            let newImageCount = 0;

            // مرتب‌سازی تصاویر موجود
            const existingImagesContainer = document.getElementById('existingImagesContainer');
            if (existingImagesContainer) {
                new Sortable(existingImagesContainer, {
                    animation: 150,
                    handle: '.image-preview-item',
                    onEnd: function(evt) {
                        updateExistingImagesOrder();
                    }
                });
            }

            // به‌روزرسانی ترتیب تصاویر موجود
            function updateExistingImagesOrder() {
                $('.existing-image-item').each(function(index) {
                    const imageId = $(this).data('image-id');
                    $(`#order_${imageId}`).val(index);
                    $(`.order-input[data-image-id="${imageId}"]`).val(index);
                    $(this).find('.image-number').text(index + 1);
                });
            }

            // نمایش نام فایل‌های جدید
            $('#new_images').on('change', function(e) {
                let files = e.target.files;
                let fileNames = [];

                for (let i = 0; i < files.length; i++) {
                    fileNames.push(files[i].name);
                }

                $(this).next('.custom-file-label').html(fileNames.join(', ') || 'انتخاب تصاویر جدید...');

                // نمایش پیش‌نمایش تصاویر جدید
                showNewImagePreviews(files);
            });

            // نمایش پیش‌نمایش تصاویر جدید
            function showNewImagePreviews(files) {
                const previewContainer = $('#newImagesPreviewContainer');
                const infoContainer = $('#newImagesInfoContainer');

                previewContainer.empty();
                infoContainer.empty();

                const existingImageCount = $('.existing-image-item').length;

                Array.from(files).forEach((file, index) => {
                    const reader = new FileReader();
                    const imageId = 'new_image_' + newImageCount++;

                    reader.onload = function(e) {
                        // پیش‌نمایش تصویر
                        const previewHtml = `
                        <div class="image-preview-item new-image-item" id="preview_${imageId}">
                            <div class="image-number">${existingImageCount + index + 1}</div>
                            <img src="${e.target.result}" class="image-preview" alt="Preview">
                            <button type="button" class="remove-image" onclick="removeNewImage('${imageId}')">
                                ×
                            </button>
                        </div>
                    `;

                        previewContainer.append(previewHtml);

                        // فرم اطلاعات تصویر جدید
                        const infoHtml = `
                        <div class="image-info mb-3" id="info_${imageId}">
                            <h6>تصویر جدید ${index + 1}: ${file.name}</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>ترتیب نمایش</label>
                                    <input type="number"
                                           name="orders[]"
                                           class="form-control"
                                           min="0"
                                           value="${existingImageCount + index}"
                                           required>
                                    <small class="text-muted">ترتیب نسبت به تمام تصاویر</small>
                                </div>
                                <div class="col-md-4">
                                    <label>مدت نمایش (میلی‌ثانیه)</label>
                                    <input type="number"
                                           name="durations[]"
                                           class="form-control"
                                           min="1000"
                                           value="5000"
                                           required>
                                    <small class="text-muted">پیش‌فرض: 5000 (5 ثانیه)</small>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>اطلاعات فایل</label>
                                        <input type="text"
                                               class="form-control"
                                               value="${(file.size / 1024).toFixed(2)} KB"
                                               readonly>
                                        <small class="text-muted">${file.type}</small>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="images[]" value="${index}">
                        </div>
                    `;

                        infoContainer.append(infoHtml);
                    }

                    reader.readAsDataURL(file);
                });
            }

            // حذف تصویر جدید
            window.removeNewImage = function(imageId) {
                $(`#preview_${imageId}`).remove();
                $(`#info_${imageId}`).remove();
                updateNewImagesOrder();
            }

            // به‌روزرسانی ترتیب تصاویر جدید
            function updateNewImagesOrder() {
                const existingImageCount = $('.existing-image-item').length;
                $('.new-image-item').each(function(index) {
                    $(this).find('.image-number').text(existingImageCount + index + 1);
                    const infoId = $(this).attr('id').replace('preview_', 'info_');
                    $(`#${infoId} input[name="orders[]"]`).val(existingImageCount + index);
                });
            }

            // بروزرسانی اطلاعات تصاویر موجود
            $(document).on('change', '.order-input, .duration-input', function() {
                const imageId = $(this).data('image-id');
                const value = $(this).val();

                if ($(this).hasClass('order-input')) {
                    $(`#order_${imageId}`).val(value);
                } else {
                    $(`#duration_${imageId}`).val(value);
                    alert($(`#duration_${imageId}`).val());
                }
            });

            // حذف تصویر موجود با Ajax
            $(document).on('click', '.btn-delete-image', function(e) {
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

                                // به‌روزرسانی ترتیب
                                updateExistingImagesOrder();
                                updateNewImagesOrder();

                                // نمایش پیام موفقیت
                                showToast('success', response.message);
                            }
                        },
                        error: function(xhr) {
                            const error = xhr.responseJSON?.message || 'خطا در حذف تصویر';
                            showToast('error', error);
                        }
                    });
                }
            });

            // اعتبارسنجی فرم
            $('#popupEditForm').on('submit', function(e) {
                const startAt = $('#start_at').val();
                const endAt = $('#end_at').val();

                // بررسی تاریخ‌ها
                if (startAt && endAt && new Date(startAt) > new Date(endAt)) {
                    e.preventDefault();
                    showToast('error', 'تاریخ پایان باید بعد از تاریخ شروع باشد.');
                    return false;
                }

                // بررسی حداقل یک تصویر
                const existingCount = $('.existing-image-item').length;
                const newCount = $('.new-image-item').length;

                if (existingCount + newCount === 0) {
                    e.preventDefault();
                    showToast('warning', 'حداقل یک تصویر برای پاپ‌آپ الزامی است.');
                    return false;
                }

                // بررسی حجم تصاویر جدید
                const files = $('#new_images')[0].files;
                

                return true;
            });

            // نمایش Toast
            function showToast(type, message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end', // مشابه bottom-right
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: type, // success | error | warning | info
                    title: message
                });
            }


            // تنظیم حداقل تاریخ برای end_at
            $('#start_at').on('change', function() {
                const startDate = $(this).val();
                if (startDate) {
                    $('#end_at').attr('min', startDate);
                }
            });
        });
    </script>
@endpush
