@extends('admin-layout')

@section('title', 'ثبت پاپ آپ')

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
        }

        .image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-info {
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            margin-top: 10px;
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
        }
    </style>
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/select2/select2.min.css') }}">
@endpush

@section('main-content')
    <section class="content">
        <div class="card col-md-12">
            <div class="card-header p-3">
                <h3 class="card-title">ایجاد پاپ آپ جدید</h3>
                <div class="card-tools">
                    <a href="{{ route('popup.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-right ml-1"></i>
                        بازگشت به لیست
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('popup.store') }}" enctype="multipart/form-data" id="popupForm">
                @csrf

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title_fa">عنوان فارسی <span class="text-danger">*</span></label>
                                <input type="text" name="title_fa" id="title_fa"
                                    class="form-control @error('title_fa') is-invalid @enderror"
                                    placeholder="عنوان فارسی را وارد کنید" value="{{ old('title_fa') }}" required>
                                @error('title_fa')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title_en">عنوان انگلیسی</label>
                                <input type="text" name="title_en" id="title_en"
                                    class="form-control @error('title_en') is-invalid @enderror"
                                    placeholder="Title (English)" value="{{ old('title_en') }}">
                                @error('title_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description_fa">توضیحات فارسی</label>
                                <textarea name="description_fa" id="description_fa" class="form-control @error('description_fa') is-invalid @enderror"
                                    rows="3" placeholder="توضیحات فارسی را وارد کنید">{{ old('description_fa') }}</textarea>
                                @error('description_fa')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description_en">توضیحات انگلیسی</label>
                                <textarea name="description_en" id="description_en" class="form-control @error('description_en') is-invalid @enderror"
                                    rows="3" placeholder="Description (English)">{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="link">لینک</label>
                        {{-- <input type="url" name="link" id="link"
                            class="form-control @error('link') is-invalid @enderror" placeholder="https://example.com"
                            value="{{ old('link') }}"> --}}
                        <select class="form-control select2" name="link" id="link"
                            data-placeholder="لطفا صفحه مورد نظر خود را انخاب کنید" style="width: 100%;text-align: right">
                            @foreach ($articles as $article)
                                <option value="{{ $article->id }}" {{ old('link') == $article->id ? 'selected' : '' }}>
                                    {{ $article->title }}</option>
                            @endforeach
                        </select>
                        @error('link')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="images">تصاویر پاپ‌آپ</label>
                        <div class="custom-file">
                            <input type="file" name="images[]" id="images"
                                class="custom-file-input @error('images') is-invalid @enderror" multiple accept="image/*">
                            <label class="custom-file-label" id="customFileLabel" for="images">انتخاب تصاویر...</label>
                        </div>
                        <small class="form-text text-muted">
                            حداکثر حجم هر تصویر: ۲ مگابایت | فرمت‌های مجاز: jpg, png, gif
                        </small>
                        @error('images')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                        @error('images.*')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3 text-center" id="imagePreviewContainer">
                            <!-- پیش‌نمایش تصاویر -->
                            {{-- <div  class="image-preview-container"></div> --}}
                        </div>
                        <div class="col-md-9 mb-3" id="imageInfoContainer">
                            <!-- اطلاعات تصاویر -->
                            {{-- <div  class="image-info-container mt-3"></div> --}}
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_at">تاریخ و زمان شروع</label>
                                <input type="datetime-local" name="start_at" id="start_at"
                                    class="form-control @error('start_at') is-invalid @enderror"
                                    value="{{ old('start_at') }}">
                                @error('start_at')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_at">تاریخ و زمان پایان</label>
                                <input type="datetime-local" name="end_at" id="end_at"
                                    class="form-control @error('end_at') is-invalid @enderror"
                                    value="{{ old('end_at') }}">
                                @error('end_at')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                class="custom-control-input" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">
                                پاپ‌آپ فعال باشد
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save ml-1"></i>
                        ذخیره پاپ‌آپ
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-redo ml-1"></i>
                        بازنشانی فرم
                    </button>
                    <a href="{{ route('popup.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times ml-1"></i>
                        انصراف
                    </a>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('../storetemplate/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $('.select2').select2();
        $(document).ready(function() {
            let imageCount = 0;
            let fileNames = [];

            // نمایش نام فایل‌های انتخاب شده
            $('#images').on('change', function(e) {
                let files = e.target.files;

                for (let i = 0; i < files.length; i++) {
                    fileNames.push(files[i].name);
                }

                $(this).next('.custom-file-label').html(fileNames.join(', ') || 'انتخاب تصاویر...');

                // نمایش پیش‌نمایش تصاویر
                showImagePreviews(files);
            });

            // نمایش پیش‌نمایش تصاویر
            function showImagePreviews(files) {
                const previewContainer = $('#imagePreviewContainer');
                const infoContainer = $('#imageInfoContainer');

                previewContainer.empty();
                infoContainer.empty();

                Array.from(files).forEach((file, index) => {
                    const reader = new FileReader();
                    const imageId = 'image_' + imageCount++;

                    reader.onload = function(e) {
                        // پیش‌نمایش تصویر
                        const previewHtml = `
                        <div class="image-preview-item" id="preview_${imageId}">
                            <img src="${e.target.result}" class="image-preview" alt="Preview">
                            <button type="button" class="remove-image" onclick="removeImage('${imageId}')">
                                ×
                            </button>
                        </div>
                    `;

                        previewContainer.append(previewHtml);

                        // فرم اطلاعات تصویر
                        const infoHtml = `
                        <div class="image-info mb-3" id="info_${imageId}">
                            <h6>تصویر ${index + 1}: ${file.name}</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>ترتیب نمایش</label>
                                    <input type="number"
                                           name="orders[]"
                                           class="form-control"
                                           min="0"
                                           value="${index}"
                                           required>
                                </div>
                                <div class="col-md-4">
                                    <label>مدت نمایش (میلی‌ثانیه)</label>
                                    <input type="number"
                                           name="durations[]"
                                           class="form-control"
                                           min="1000"
                                           value="3000"
                                           required>
                                    <small class="text-muted">پیش‌فرض: 3000 (3 ثانیه)</small>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>حجم فایل</label>
                                        <input type="text"
                                               class="form-control"
                                               value="${(file.size / 1024).toFixed(2)} KB"
                                               readonly>
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

            // حذف تصویر از لیست
            window.removeImage = function(imageId) {
                $(`#preview_${imageId}`).remove();
                $(`#info_${imageId}`).remove();

                // به‌روزرسانی input فایل
                updateFileInput();
            }

            // به‌روزرسانی input فایل
            function updateFileInput() {
                const input = document.getElementById('images');
                const dataTransfer = new DataTransfer();

                $("#customFileLabel").html(fileNames.join(', ') || 'انتخاب تصاویر...');

                // اینجا می‌توانید منطق پیچیده‌تری برای حذف فایل‌ها از input اضافه کنید
                // یا از کتابخانه‌هایی مانند Dropzone.js استفاده کنید
            }

            // اعتبارسنجی فرم
            $('#popupForm').on('submit', function(e) {
                const files = $('#images')[0].files;
                const maxSize = 2 * 1024 * 1024; // 2MB

                // بررسی حجم تصاویر
                for (let i = 0; i < files.length; i++) {
                    if (files[i].size > maxSize) {
                        e.preventDefault();
                        alert(`حجم تصویر ${files[i].name} بیش از ۲ مگابایت است.`);
                        return false;
                    }
                }

                // بررسی تاریخ‌ها
                const startAt = $('#start_at').val();
                const endAt = $('#end_at').val();

                if (startAt && endAt && new Date(startAt) > new Date(endAt)) {
                    e.preventDefault();
                    alert('تاریخ پایان باید بعد از تاریخ شروع باشد.');
                    return false;
                }

                return true;
            });

            // فارسی‌سازی datetime-local
            if ($('#start_at').val()) {
                $('#start_at').val($('#start_at').val().replace('T', ' '));
            }
            if ($('#end_at').val()) {
                $('#end_at').val($('#end_at').val().replace('T', ' '));
            }
        });
    </script>
@endpush
