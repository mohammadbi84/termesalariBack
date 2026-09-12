@extends('admin-layout')

@section('title', 'تنظیمات ویدیو اصلی')

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
                        <div class="card-title">تنظیمات ویدیو اصلی</div>
                    </div>

                    <form action="{{ route('video.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">

                            {{-- عنوان --}}
                            <div class="form-group">
                                <label>عنوان ویدیو</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $video->title ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label>عنوان انگلیسی ویدیو</label>
                                <input type="text" name="e_title" class="form-control"
                                    value="{{ old('e_title', $video->e_title ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label>عنوان عربی ویدیو</label>
                                <input type="text" name="ar_title" class="form-control"
                                    value="{{ old('ar_title', $video->ar_title ?? '') }}">
                            </div>

                            {{-- کاور --}}
                            <div class="form-group">
                                <label>کاور ویدیو</label>
                                <div class="file-loading">
                                    <input id="cover" name="cover" type="file">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>کاور انگلیسی ویدیو</label>
                                <div class="file-loading">
                                    <input id="e_cover" name="e_cover" type="file">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>کاور عربی ویدیو</label>
                                <div class="file-loading">
                                    <input id="ar_cover" name="ar_cover" type="file">
                                </div>
                            </div>

                            {{-- ویدیو --}}
                            <div class="form-group">
                                <label>ویدیو</label>
                                <div class="file-loading">
                                    <input id="video" name="video" type="file">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>ویدیو انگلیسی</label>
                                <div class="file-loading">
                                    <input id="e_video" name="e_video" type="file">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>ویدیو عربی</label>
                                <div class="file-loading">
                                    <input id="ar_video" name="ar_video" type="file">
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
        $("#cover").fileinput({
            theme: "fas",
            language: "fa",
            showUpload: false,
            rtl: true,
            initialPreview: [
                @if (isset($video) && $video->cover)
                    "{{ asset('storage/' . $video->cover) }}"
                @endif
            ],
            initialPreviewAsData: true,
            initialPreviewFileType: "image",
            allowedFileExtensions: ["jpg", "png", "jpeg"]
        });
        $("#e_cover").fileinput({
            theme: "fas",
            language: "fa",
            showUpload: false,
            rtl: true,
            initialPreview: [
                @if (isset($video) && $video->e_cover)
                    "{{ asset('storage/' . $video->e_cover) }}"
                @endif
            ],
            initialPreviewAsData: true,
            initialPreviewFileType: "image",
            allowedFileExtensions: ["jpg", "png", "jpeg"]
        });
        $("#ar_cover").fileinput({
            theme: "fas",
            language: "fa",
            showUpload: false,
            rtl: true,
            initialPreview: [
                @if (isset($video) && $video->ar_cover)
                    "{{ asset('storage/' . $video->ar_cover) }}"
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
                @if (isset($video) && $video->video)
                    "{{ asset('storage/' . $video->video) }}"
                @endif
            ],
            initialPreviewAsData: true,
            initialPreviewFileType: "video",
            allowedFileExtensions: ["mp4", "mov", "avi"]
        });
        $("#e_video").fileinput({
            theme: "fas",
            language: "fa",
            showUpload: false,
            rtl: true,
            initialPreview: [
                @if (isset($video) && $video->e_video)
                    "{{ asset('storage/' . $video->e_video) }}"
                @endif
            ],
            initialPreviewAsData: true,
            initialPreviewFileType: "video",
            allowedFileExtensions: ["mp4", "mov", "avi"]
        });
        $("#ar_video").fileinput({
            theme: "fas",
            language: "fa",
            showUpload: false,
            rtl: true,
            initialPreview: [
                @if (isset($video) && $video->ar_video)
                    "{{ asset('storage/' . $video->ar_video) }}"
                @endif
            ],
            initialPreviewAsData: true,
            initialPreviewFileType: "video",
            allowedFileExtensions: ["mp4", "mov", "avi"]
        });
    </script>
@endpush
