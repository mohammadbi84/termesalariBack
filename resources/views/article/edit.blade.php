@extends('admin-layout')

@section('title', 'پنل مدیریت | ویرایش مقاله')

@push('link')
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput.min.css') }}"
        media="all">
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput-rtl.min.css') }}"
        media="all">
    <link href="https://lib.arvancloud.ir/summernote/0.8.9/summernote-lite.css" rel="stylesheet">
    <style>
        .tag-input-wrapper {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            min-height: 45px;
            padding: 7px 10px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            background: #fff;
            cursor: text;
        }

        .tag-input-wrapper:focus-within {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        }

        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .tag-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 9px;
            border-radius: 5px;
            background: #e9ecef;
            color: #212529;
            font-size: 14px;
        }

        .tag-remove {
            border: none;
            background: transparent;
            padding: 0;
            cursor: pointer;
            font-size: 16px;
            line-height: 1;
            color: #6c757d;
        }

        .tag-remove:hover {
            color: #dc3545;
        }

        .tag-input {
            flex: 1;
            min-width: 150px;
            border: none;
            outline: none;
            padding: 5px;
            background: transparent;
        }
    </style>
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
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>عکس مقاله</label>
                            {{-- <input id="image" name="image" type="file"> --}}
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> انتخاب تصویر
                                    </a>
                                </span>
                                <input id="thumbnail" class="form-control" type="text" name="image"
                                    value="{{ old('image', $article->image) }}">
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <img id="holder" style="margin-top:15px;max-height:100px;"
                                src="{{ asset('storage/' . old('image', $article->image)) }}">
                        </div>
                        <div class="form-group @error('title') is-invalid @enderror">
                            <label for="title">عنوان صفحه</label>
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="لطفا عنوان صفحه را وارد کنید." value="{{ old('title', $article->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group @error('e_title') is-invalid @enderror">
                            <label for="e_title">عنوان انگلیسی صفحه</label>
                            <input type="text" name="e_title" id="e_title" class="form-control"
                                placeholder="لطفا عنوان انگلیسی صفحه را وارد کنید."
                                value="{{ old('e_title', $article->e_title) }}">
                            @error('e_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group @error('ar_title') is-invalid @enderror">
                            <label for="ar_title">عنوان عربی صفحه</label>
                            <input type="text" name="ar_title" id="ar_title" class="form-control"
                                placeholder="لطفا عنوان عربی صفحه را وارد کنید."
                                value="{{ old('ar_title', $article->ar_title) }}">
                            @error('ar_title')
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
                        <div class="form-group @error('e_body') is-invalid @enderror">
                            <label for="e_body">محتوای انگلیسی صفحه</label>
                            <textarea name="e_body" id="e_body" class="form-control" rows="5">{{ old('e_body', $article->e_body) }}</textarea>

                            @error('e_body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group @error('ar_body') is-invalid @enderror">
                            <label for="ar_body">محتوای عربی صفحه</label>
                            <textarea name="ar_body" id="ar_body" class="form-control" rows="5">{{ old('ar_body', $article->ar_body) }}</textarea>

                            @error('ar_body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">برچسب‌ها</label>

                            <div class="tag-input-wrapper" id="tagInputWrapper">
                                <div id="tagsContainer" class="tags-container"></div>

                                <input type="text" id="tagInput" class="tag-input"
                                    placeholder="برچسب را بنویسید و Enter بزنید...">
                            </div>

                            <input type="hidden" name="tags" id="tags">

                            <small class="text-muted">
                                برای ثبت هر برچسب Enter بزنید.
                            </small>
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
    <script src="{{ asset('vendor/laravel-filemanager/js/lfm.js') }}"></script>
    <script>
        const tagInput = document.getElementById('tagInput');
        const tagsContainer = document.getElementById('tagsContainer');
        const tagsHiddenInput = document.getElementById('tags');
        const tagInputWrapper = document.getElementById('tagInputWrapper');

        let tags = @json($article->tags->pluck('name')->values());

        function renderTags() {

            tagsContainer.innerHTML = '';

            tags.forEach((tag, index) => {

                const tagElement = document.createElement('span');

                tagElement.className = 'tag-item';

                tagElement.innerHTML = `
                <span>${escapeHtml(tag)}</span>

                <button
                    type="button"
                    class="tag-remove"
                    onclick="removeTag(${index})"
                >
                    ×
                </button>
            `;

                tagsContainer.appendChild(tagElement);
            });

            tagsHiddenInput.value = JSON.stringify(tags);
        }

        tagInput.addEventListener('keydown', function(event) {

            if (event.key === 'Enter') {

                event.preventDefault();

                const tag = this.value.trim();

                if (!tag) {
                    return;
                }

                if (tags.includes(tag)) {
                    this.value = '';
                    return;
                }

                tags.push(tag);

                renderTags();

                this.value = '';
            }

            if (
                event.key === 'Backspace' &&
                this.value === '' &&
                tags.length > 0
            ) {
                tags.pop();

                renderTags();
            }
        });

        function removeTag(index) {

            tags.splice(index, 1);

            renderTags();

            tagInput.focus();
        }

        function escapeHtml(text) {

            const div = document.createElement('div');

            div.textContent = text;

            return div.innerHTML;
        }

        tagInputWrapper.addEventListener('click', function() {
            tagInput.focus();
        });

        // نمایش تگ‌های قبلی مقاله
        renderTags();
    </script>
    <script>
        $('#lfm').filemanager('image');
        $(document).ready(function() {
            $('#body').summernote({
                placeholder: 'محتوای صفحه را اینجا وارد کنید ...',
                tabsize: 2,
                height: 200,
                callbacks: {
                    onImageUpload: function(files) {
                        let data = new FormData();
                        data.append("file", files[0]);

                        $.ajax({
                            url: '/upload-image',
                            method: 'POST',
                            data: data,
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>',
                            },
                            success: function(response) {
                                $('#body').summernote('insertImage', response.url);
                            }
                        });
                    }
                }
            });
            $('#e_body').summernote({
                placeholder: 'محتوای انگلیسی صفحه را اینجا وارد کنید ...',
                tabsize: 2,
                height: 200,
                callbacks: {
                    onImageUpload: function(files) {
                        let data = new FormData();
                        data.append("file", files[0]);

                        $.ajax({
                            url: '/upload-image',
                            method: 'POST',
                            data: data,
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>',
                            },
                            success: function(response) {
                                $('#body').summernote('insertImage', response.url);
                            }
                        });
                    }
                }
            });
            $('#ar_body').summernote({
                placeholder: 'محتوای عربی صفحه را اینجا وارد کنید ...',
                tabsize: 2,
                height: 200,
                callbacks: {
                    onImageUpload: function(files) {
                        let data = new FormData();
                        data.append("file", files[0]);

                        $.ajax({
                            url: '/upload-image',
                            method: 'POST',
                            data: data,
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>',
                            },
                            success: function(response) {
                                $('#ar_body').summernote('insertImage', response.url);
                            }
                        });
                    }
                }
            });
        });
    </script>
@endpush
