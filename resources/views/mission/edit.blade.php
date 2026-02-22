@extends('admin-layout')

@section('title', 'تنظیمات رسالت ترمه سالاری')

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
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                @endif

                <div class="card col-md-10 col-sm-12">
                    <div class="card-header">
                        <div class="card-title">تنظیمات بخش رسالت</div>
                    </div>

                    <form action="{{ route('mission.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">

                            {{-- عنوان --}}
                            <div class="form-group">
                                <label>عنوان فارسی</label>
                                <input type="text" name="title_fa" class="form-control"
                                    value="{{ old('title_fa', $mission->title_fa ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label>عنوان انگلیسی</label>
                                <input type="text" name="title_en" class="form-control"
                                    value="{{ old('title_en', $mission->title_en ?? '') }}">
                            </div>

                            {{-- توضیحات --}}
                            <div class="form-group">
                                <label>توضیحات فارسی</label>
                                <textarea name="description_fa" rows="5" class="form-control">{{ old('description_fa', $mission->description_fa ?? '') }}</textarea>
                            </div>
                            {{-- توضیحات --}}
                            <div class="form-group">
                                <label>توضیحات انگلیسی</label>
                                <textarea name="description_en" rows="5" class="form-control">{{ old('description_en', $mission->description_en ?? '') }}</textarea>
                            </div>

                            {{-- کاور --}}
                            <div class="form-group">
                                <label>کاور ویدیو</label>
                                <div class="file-loading">
                                    <input id="video_cover" name="video_cover" type="file">
                                </div>
                            </div>

                            {{-- ویدیو --}}
                            <div class="form-group">
                                <label>ویدیو</label>
                                <div class="file-loading">
                                    <input id="video" name="video" type="file">
                                </div>
                            </div>

                            <hr>

                            <h5>شمارنده‌ها</h5>

                            <div id="counters-wrapper">

                                @if (isset($mission) && $mission->counters)
                                    @foreach ($mission->counters as $index => $counter)
                                        <div class="counter-item border p-3 mb-3">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" name="counters[{{ $index }}][title_fa]"
                                                        class="form-control" placeholder="عنوان"
                                                        value="{{ $counter->title_fa }}">
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="counters[{{ $index }}][title_en]"
                                                        class="form-control" placeholder="عنوان"
                                                        value="{{ $counter->title_en }}">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="number" name="counters[{{ $index }}][number]"
                                                        class="form-control" placeholder="عدد"
                                                        value="{{ $counter->number }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button"
                                                        class="btn btn-danger btn-remove w-100">حذف</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                            <button type="button" id="add-counter" class="btn btn-success mt-2">
                                افزودن شمارنده
                            </button>

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
        let counterIndex = {{ isset($mission) ? $mission->counters->count() : 0 }};

        $('#add-counter').click(function() {

            let html = `
<div class="counter-item border p-3 mb-3">
<div class="row">
<div class="col">
<input type="text" name="counters[${counterIndex}][title_fa]" class="form-control" placeholder="عنوان">
</div>
<div class="col">
<input type="text" name="counters[${counterIndex}][title_en]" class="form-control" placeholder="عنوان">
</div>
<div class="col-md-5">
<input type="number" name="counters[${counterIndex}][number]" class="form-control" placeholder="عدد">
</div>
<div class="col-md-2">
<button type="button" class="btn btn-danger btn-remove w-100">حذف</button>
</div>
</div>
</div>
`;

            $('#counters-wrapper').append(html);
            counterIndex++;

        });

        $(document).on('click', '.btn-remove', function() {
            $(this).closest('.counter-item').remove();
            reIndexCounters();
        });

        function reIndexCounters() {
            counterIndex = 0;
            $('.counter-item').each(function() {
                $(this).find('input').each(function() {
                    let name = $(this).attr('name');
                    if (name.includes('title_fa')) {
                        $(this).attr('name', `counters[${counterIndex}][title_fa]`);
                    }
                    if (name.includes('title_en')) {
                        $(this).attr('name', `counters[${counterIndex}][title_en]`);
                    }
                    if (name.includes('number')) {
                        $(this).attr('name', `counters[${counterIndex}][number]`);
                    }
                });
                counterIndex++;
            });
        }

        $("#video_cover").fileinput({
            theme: "fas",
            language: "fa",
            showUpload: false,
            rtl: true,
            initialPreview: [
                @if (isset($mission) && $mission->video_cover)
                    "{{ asset('storage/' . $mission->video_cover) }}"
                @endif
            ],
            initialPreviewAsData: true,
            initialPreviewFileType: "image",
            allowedFileExtensions: ["jpg", "png", "jpeg"]
        });

        $("#video").fileinput({
            theme: "fas",
            language: "fa",
            showUpload: false,
            rtl: true,
            initialPreview: [
                @if (isset($mission) && $mission->video_path)
                    "{{ asset('storage/' . $mission->video_path) }}"
                @endif
            ],
            initialPreviewAsData: true,
            initialPreviewFileType: "video",
            allowedFileExtensions: ["mp4", "mov", "avi"]
        });
    </script>
@endpush
