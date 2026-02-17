{{-- resources/views/agency/edit.blade.php --}}
@extends('admin-layout')

@section('title', 'ویرایش نمایندگی')

@push('link')
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput-rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/select2/select2.min.css') }}">
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-top: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            z-index: 1;
        }

        .social-item {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            border: 1px solid #e9ecef;
        }

        .social-item .row {
            align-items: center;
        }

        .existing-images {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .image-box {
            position: relative;
            width: 100px;
            height: 100px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .delete-image-btn {
            position: absolute;
            top: 2px;
            left: 2px;
            background: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 16px;
            line-height: 1;
            cursor: pointer;
            z-index: 10;
        }

        .delete-image-btn:hover {
            background: red;
        }
    </style>
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

                <div class="card col-md-11 col-sm-12">
                    <div class="card-header">
                        <div class="card-title">ویرایش نمایندگی: {{ $agency->name_fa }}</div>
                    </div>

                    <form action="{{ route('agency.update', $agency->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>نام نماینده (فارسی)</label>
                                    <input type="text" name="name_fa" class="form-control"
                                        value="{{ old('name_fa', $agency->name_fa) }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Agent Name (English)</label>
                                    <input type="text" name="name_en" class="form-control"
                                        value="{{ old('name_en', $agency->name_en) }}">
                                </div>
                                <div class="form-group col-12">
                                    <label>آدرس کامل (فارسی)</label>
                                    <textarea name="address_fa" class="form-control">{{ old('address_fa', $agency->address_fa) }}</textarea>
                                </div>

                                <div class="form-group col-12">
                                    <label>Full Address (English)</label>
                                    <textarea name="address_en" class="form-control">{{ old('address_en', $agency->address_en) }}</textarea>
                                </div>
                            </div>

                            <hr>

                            {{-- شهر --}}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>استان</label>
                                    <select name="state_id" id="state-select" class="form-control select2">
                                        <option value="">انتخاب استان</option>
                                        @foreach ($cities as $city)
                                            {{-- در صورت داشتن مختصات شهر، data-lat و data-lng رو پر کن --}}
                                            <option value="{{ $city->id }}" data-lat="{{ $city->latitude ?? '' }}"
                                                data-lng="{{ $city->longitude ?? '' }}"
                                                {{ $agency->state_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>شهر</label>
                                    <select name="city_id" id="city-select" class="form-control select2">
                                        <option value="{{ $agency->city_id }}">
                                            {{ $agency->city->name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            {{-- نقشه --}}
                            <div class="form-group">
                                <label>موقعیت روی نقشه</label>
                                <div id="map"></div>
                            </div>

                            <input type="hidden" name="latitude" id="latitude"
                                value="{{ old('latitude', $agency->latitude) }}">
                            <input type="hidden" name="longitude" id="longitude"
                                value="{{ old('longitude', $agency->longitude) }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>عرض جغرافیایی</label>
                                        <input type="text" class="form-control" id="lat-display"
                                            value="{{ $agency->latitude }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>طول جغرافیایی</label>
                                        <input type="text" class="form-control" id="lng-display"
                                            value="{{ $agency->longitude }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>تلفن</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ old('phone', $agency->phone) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>موبایل</label>
                                        <input type="text" name="mobile" class="form-control"
                                            value="{{ old('mobile', $agency->mobile) }}">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- شبکه‌های اجتماعی داینامیک --}}
                            <h5>شبکه‌های اجتماعی</h5>
                            <div id="social-container">
                                {{-- آیتم‌ها با js از روی داده‌های موجود ساخته می‌شن --}}
                            </div>
                            <button type="button" class="btn btn-sm btn-success" id="add-social">+ افزودن شبکه
                                اجتماعی</button>

                            <hr>

                            {{-- عکس اصلی --}}
                            <div class="form-group">
                                <label>عکس اصلی نماینده</label>
                                <input id="image" name="image" type="file" accept="image/*">
                                @if ($agency->image)
                                    <div class="existing-images">
                                        <div class="image-box" data-id="{{ $agency->id }}" data-type="main">
                                            <img src="{{ asset('storage/' . $agency->image) }}" alt="main image">
                                            <button type="button" class="delete-image-btn"
                                                data-image-id="{{ $agency->id }}" data-type="main">×</button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- تصاویر اسلایدر --}}
                            <div class="form-group">
                                <label>تصاویر اسلایدر</label>
                                <input id="slider_images" name="slider_images[]" type="file" multiple
                                    accept="image/*">
                                @if ($agency->images->count())
                                    <div class="existing-images">
                                        @foreach ($agency->images as $sliderImage)
                                            <div class="image-box" data-id="{{ $sliderImage->id }}" data-type="slider">
                                                <img src="{{ asset('storage/images/' . $sliderImage->name) }}"
                                                    alt="slider image">
                                                <button type="button" class="delete-image-btn"
                                                    data-image-id="{{ $sliderImage->id }}" data-type="slider">×</button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">به‌روزرسانی</button>
                            <a href="{{ route('agency.index') }}" class="btn btn-secondary">بازگشت</a>
                        </div>

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
    <!-- Select2 -->
    <script src="{{ asset('../storetemplate/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Leaflet -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        $(function() {

            // --- select2 و file inputها ---
            $('.select2').select2();

            // پیکربندی fileinput برای عکس اصلی (با قابلیت حذف فایل جدید، اما فعلاً غیرفعالش می‌کنیم چون دکمه‌های حذف اختصاصی داریم)
            $("#image").fileinput({
                theme: 'fas',
                showUpload: false,
                allowedFileTypes: ["image"],
                maxFileCount: 1,
                rtl: true,
                language: "fa",
                showRemove: false, // دکمه حذف داخلی رو غیرفعال می‌کنیم تا با دکمه‌های اختصاصی تداخل نداشته باشه
                showClose: false
            });

            $("#slider_images").fileinput({
                theme: 'fas',
                showUpload: false,
                allowedFileTypes: ["image"],
                rtl: true,
                language: "fa",
                showRemove: false,
                showClose: false
            });

            $(document).ready(function() {
                // وقتی استان تغییر می‌کند
                $('#state-select').on('change', function() {
                    var provinceId = $(this).val();
                    var citySelect = $('#city-select');

                    citySelect.html('<option value="">در حال بارگذاری...</option>').prop('disabled',
                        true);

                    if (provinceId) {
                        $.ajax({
                            url: '{{ route('get.cities.by.province', '') }}/' + provinceId,
                            type: 'GET',
                            success: function(data) {
                                citySelect.prop('disabled', false).empty().append(
                                    '<option value="">انتخاب شهر</option>');
                                $.each(data, function(key, city) {
                                    citySelect.append('<option value="' + city
                                        .id + '">' + city.name + '</option>'
                                    );
                                });

                                // اگر در حالت ویرایش هستیم و شهر قبلاً انتخاب شده، آن را انتخاب کن
                                @if (isset($agency) && $agency->city_id)
                                    citySelect.val({{ $agency->city_id }});
                                @endif
                            },
                            error: function() {
                                citySelect.prop('disabled', false).html(
                                    '<option value="">خطا در بارگذاری</option>');
                            }
                        });
                    } else {
                        citySelect.prop('disabled', false).html(
                            '<option value="">ابتدا استان را انتخاب کنید</option>');
                    }
                });

                // اگر در ویرایش استان قبلاً انتخاب شده، رویداد change را فعال کن تا شهرها بارگذاری شوند
                @if (isset($agency) && $agency->city_id)
                    $('#province-select').trigger('change');
                @endif
            });

            // --- نقشه (با مختصات فعلی) ---
            const defaultLat = {{ $agency->latitude ?? 35.6892 }};
            const defaultLng = {{ $agency->longitude ?? 51.389 }};

            const map = L.map('map').setView([defaultLat, defaultLng], 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            let marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            const latHidden = $('#latitude');
            const lngHidden = $('#longitude');
            const latDisplay = $('#lat-display');
            const lngDisplay = $('#lng-display');

            function updateCoordFields(lat, lng) {
                latHidden.val(lat);
                lngHidden.val(lng);
                latDisplay.val(lat);
                lngDisplay.val(lng);
            }

            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                marker.setLatLng([lat, lng]);
                updateCoordFields(lat, lng);
            });

            marker.on('dragend', function(e) {
                const {
                    lat,
                    lng
                } = e.target.getLatLng();
                updateCoordFields(lat, lng);
            });

            // --- انتخاب شهر و حرکت نقشه ---
            $('#state-select').on('change', function() {
                const selected = $(this).find('option:selected');
                const lat = selected.data('lat');
                const lng = selected.data('lng');
                if (lat && lng) {
                    const latNum = parseFloat(lat);
                    const lngNum = parseFloat(lng);
                    map.setView([latNum, lngNum], 12);
                    marker.setLatLng([latNum, lngNum]);
                    updateCoordFields(latNum, lngNum);
                }
            });

            // --- شبکه‌های اجتماعی داینامیک (پرشده با مقادیر فعلی) ---
            const socialContainer = $('#social-container');
            let socialIndex = 0;

            // تابع ساخت آیتم
            function addSocialItem(platform = '', url = '', index = null) {
                if (index === null) index = socialIndex;
                const item = $(`
                    <div class="social-item">
                        <div class="row">
                            <div class="col-md-5">
                                <select name="social[${index}][platform]" class="form-control">
                                    <option value="">انتخاب پلتفرم</option>
                                    <option value="instagram" ${platform === 'instagram' ? 'selected' : ''}>اینستاگرام</option>
                                    <option value="telegram" ${platform === 'telegram' ? 'selected' : ''}>تلگرام</option>
                                    <option value="whatsapp" ${platform === 'whatsapp' ? 'selected' : ''}>واتساپ</option>
                                    <option value="twitter" ${platform === 'twitter' ? 'selected' : ''}>توییتر</option>
                                    <option value="facebook" ${platform === 'facebook' ? 'selected' : ''}>فیسبوک</option>
                                    <option value="linkedin" ${platform === 'linkedin' ? 'selected' : ''}>لینکدین</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="url" name="social[${index}][url]" class="form-control" placeholder="آدرس پروفایل" value="${url}">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-sm btn-danger remove-social">حذف</button>
                            </div>
                        </div>
                    </div>
                `);

                item.find('.remove-social').click(function() {
                    item.remove();
                });

                socialContainer.append(item);
                socialIndex = Math.max(socialIndex, index + 1);
            }

            // بارگذاری شبکه‌های اجتماعی موجود
            const existingSocial = @json($agency->social_links ?? []);
            if (Array.isArray(existingSocial) && existingSocial.length) {
                existingSocial.forEach((item, idx) => {
                    addSocialItem(item.platform, item.url, idx);
                });
            } else {
                // یک ردیف خالی برای شروع
                addSocialItem();
            }

            $('#add-social').click(function() {
                addSocialItem();
            });

            // --- حذف تصاویر با AJAX ---
            $('.delete-image-btn').click(function(e) {
                e.preventDefault();
                const btn = $(this);
                const imageId = btn.data('image-id');
                const type = btn.data('type'); // 'main' یا 'slider'
                const box = btn.closest('.image-box');

                if (!confirm('آیا از حذف این تصویر اطمینان دارید؟')) return;

                // تعیین آدرس براساس نوع
                let url = '';
                if (type === 'main') {
                    url = '/agency/delete-main-image/' + imageId; // مثال
                } else {
                    url = '/agency/delete-slider-image/' + imageId; // مثال
                }

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            box.remove();
                            alert('تصویر با موفقیت حذف شد.');
                        } else {
                            alert('خطا در حذف تصویر');
                        }
                    },
                    error: function() {
                        alert('خطا در ارتباط با سرور');
                    }
                });
            });

        });
    </script>
@endpush
