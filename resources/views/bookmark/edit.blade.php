@extends('admin-layout')

@section('title', 'پنل مدیریت | ایجاد صفحه داخلی')

@push('link')
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput.min.css') }}"
        media="all">
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput-rtl.min.css') }}"
        media="all">
    <link href="https://lib.arvancloud.ir/summernote/0.8.9/summernote-lite.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.css') }}">
@endpush

@section('main-content')
    <section class="content">
        <div class="row">
            <div class="card col-md-12 col-sm-12">
                <div class="card-header">
                    <div class="card-title">
                        <span>ویرایش صفحه داخلی</span>
                    </div>
                </div>
                @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <div class="card-body">
                    {{-- {{ dd($products) }} --}}
                    <form class="form" role="form" action="{{ route('bookmark.update',['bookmark'=>$bookmark->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-4 mb-3">
                                <div class="form-group @error('title_fa') is-invalid @enderror">
                                    <label for="title_fa">عنوان فارسی</label>
                                    <input type="text" name="title_fa" id="title_fa" class="form-control"
                                        placeholder="لطفا عنوان صفحه را وارد کنید." value="{{ old('title_fa',$bookmark->title_fa ) }}">
                                    @error('title_fa')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="form-group @error('title_en') is-invalid @enderror">
                                    <label for="title_en">عنوان انگلیسی</label>
                                    <input type="text" name="title_en" id="title_en" class="form-control"
                                        placeholder="لطفا عنوان صفحه را وارد کنید." value="{{ old('title_en', $bookmark->title_en ) }}">
                                    @error('title_en')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="show_title" id="show_title" value="1"
                                            class="custom-control-input" {{ $bookmark->show_title ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="show_title">
                                            عنوان فعال باشد
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group @error('body_fa') is-invalid @enderror">
                            <label for="body_fa">محتوای فارسی</label>
                            <textarea name="body_fa" id="body_fa" class="form-control" rows="5">{{ old('body_fa', $bookmark->body_fa) }}</textarea>

                            @error('body_fa')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('body_en') is-invalid @enderror">
                            <label for="body_en">محتوای انگلیسی</label>
                            <textarea name="body_en" id="body_en" class="form-control" rows="5">{{ old('body_en', $bookmark->body_en) }}</textarea>

                            @error('body_en')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sort" class="font-weight-bold">ترتیب نمایش بوکمارک</label>
                                    <input type="number" name="sort" id="sort"
                                        class="form-control @error('sort') is-invalid @enderror"
                                        value="{{ old('sort', $bookmark->sort) }}" placeholder="عدد بزرگتر = بعدی نمایش داده شود">
                                    @error('sort')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="duration" class="font-weight-bold">زمان نمایش بوکمارک <small>( میلی ثانیه
                                            )</small></label>
                                    <input type="number" name="duration" id="duration"
                                        class="form-control @error('duration') is-invalid @enderror"
                                        value="{{ old('duration', $bookmark->duration) }}">
                                    @error('duration')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_at">تاریخ و زمان شروع</label>
                                    <div class="position-relative">
                                        <input type="text" name="start_at" id="start_at"
                                            class="form-control date @error('start_at') is-invalid @enderror"
                                            value="{{ old('start_at') }}">
                                        <button type="button" id="Clearstart_at" class="clear-date-btn"
                                            style="display: none;" onclick="clearDate('start_at')">×</button>
                                    </div>
                                    @error('start_at')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_at">تاریخ و زمان پایان</label>
                                    <div class="position-relative">
                                        <input type="text" name="end_at" id="end_at"
                                            class="form-control date @error('end_at') is-invalid @enderror"
                                            value="{{ old('end_at') }}">
                                        <button type="button" id="Clearend_at" class="clear-date-btn"
                                            style="display: none;" onclick="clearDate('end_at')">×</button>
                                    </div>
                                    @error('end_at')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="active" id="active" value="1"
                                    class="custom-control-input" {{ $bookmark->active ? 'checked' : '' }}>
                                <label class="custom-control-label" for="active">
                                    بوکمارک فعال باشد
                                </label>
                            </div>
                        </div>



                        <button type="submit" class="btn btn-flat btn-primary">ثبت اطلاعات</button>
                        <a href="{{ route('bookmark.index') }}" class="btn btn flat btn-secondary">بازگشت</a>
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
    <script src="{{ asset('/storetemplate/plugins/datepicker-master/persian-date.min.js') }}"></script>
    <script src="{{ asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.js') }}"></script>

    <script src="https://lib.arvancloud.ir/summernote/0.8.9/summernote-lite.min.js"></script>
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
                onSelect: function(unix) {
                    const btn = $('#start_at').next('.clear-date-btn')[0];
                    btn.style.display = 'block';
                }
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
                onSelect: function(unix) {
                    const btn = $('#end_at').next('.clear-date-btn')[0];
                    btn.style.display = 'block';
                }
            });
            $('#end_at').val(endVal);
            $('#body_fa').summernote({
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
                                $('#body_fa').summernote('insertImage', response.url);
                            }
                        });
                    }
                }
            });
            $('#body_en').summernote({
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
                                $('#body_fa').summernote('insertImage', response.url);
                            }
                        });
                    }
                }
            });
        });
    </script>
@endpush
