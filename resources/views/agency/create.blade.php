@extends('admin-layout')

@section('title', 'ایجاد نمایندگی')

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
                        <div class="card-title">ایجاد نمایندگی جدید</div>
                    </div>

                    <form action="{{ route('agency.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>نام نماینده (فارسی)</label>
                                    <input type="text" name="name_fa" class="form-control" value="{{ old('name_fa') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Agent Name (English)</label>
                                    <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}">
                                </div>
                                <div class="form-group col-12">
                                    <label>آدرس کامل (فارسی)</label>
                                    <textarea name="address_fa" class="form-control">{{ old('address_fa') }}</textarea>
                                </div>

                                <div class="form-group col-12">
                                    <label>Full Address (English)</label>
                                    <textarea name="address_en" class="form-control">{{ old('address_en') }}</textarea>
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
                                                data-lng="{{ $city->longitude ?? '' }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>شهر</label>
                                    <select name="city_id" id="city-select" class="form-control select2">
                                        <option value="">انتخاب شهر</option>
                                    </select>
                                </div>
                            </div>

                            {{-- نقشه --}}
                            <div class="form-group">
                                <label>موقعیت روی نقشه</label>
                                <div id="map"></div>
                            </div>

                            {{-- فیلدهای مخفی مختصات --}}
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                            {{-- نمایش مختصات انتخابی (اختیاری) --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>عرض جغرافیایی</label>
                                        <input type="text" class="form-control" id="lat-display" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>طول جغرافیایی</label>
                                        <input type="text" class="form-control" id="lng-display" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>تلفن</label>
                                        <input type="text" name="phone" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>موبایل</label>
                                        <input type="text" name="mobile" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- شبکه‌های اجتماعی داینامیک --}}
                            <h5>شبکه‌های اجتماعی</h5>
                            <div id="social-container">
                                {{-- آیتم‌ها با js اضافه میشن --}}
                            </div>
                            <button type="button" class="btn btn-sm btn-success" id="add-social">+ افزودن شبکه
                                اجتماعی</button>

                            <hr>

                            {{-- عکس اصلی --}}
                            <div class="form-group">
                                <label>عکس اصلی نماینده</label>
                                <input id="image" name="image" type="file">
                            </div>

                            {{-- تصاویر اسلایدر --}}
                            <div class="form-group">
                                <label>تصاویر اسلایدر</label>
                                <input id="slider_images" name="slider_images[]" type="file" multiple>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">ذخیره</button>
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

            // --- file inputs ---
            $('.select2').select2();

            $("#image").fileinput({
                theme: 'fas',
                showUpload: false,
                allowedFileTypes: ["image"],
                maxFileCount: 1,
                rtl: true,
                language: "fa"
            });

            $("#slider_images").fileinput({
                theme: 'fas',
                showUpload: false,
                allowedFileTypes: ["image"],
                rtl: true,
                language: "fa"
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

            // --- نقشه ---
            // مختصات پیش‌فرض (تهران)
            const defaultLat = 35.6892;
            const defaultLng = 51.3890;

            // ایجاد نقشه
            const map = L.map('map').setView([defaultLat, defaultLng], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // نشانگر (marker)
            let marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            // فیلدهای مخفی و نمایشی
            const latHidden = $('#latitude');
            const lngHidden = $('#longitude');
            const latDisplay = $('#lat-display');
            const lngDisplay = $('#lng-display');

            // به‌روزرسانی فیلدها با مختصات نشانگر
            function updateCoordFields(lat, lng) {
                latHidden.val(lat);
                lngHidden.val(lng);
                latDisplay.val(lat);
                lngDisplay.val(lng);
            }

            // مقداردهی اولیه اگر از قبل مقداری وجود داشته باشد
            if (latHidden.val() && lngHidden.val()) {
                const lat = parseFloat(latHidden.val());
                const lng = parseFloat(lngHidden.val());
                map.setView([lat, lng], 15);
                marker.setLatLng([lat, lng]);
                updateCoordFields(lat, lng);
            } else {
                // پیش‌فرض
                updateCoordFields(defaultLat, defaultLng);
            }

            // رویداد کلیک روی نقشه
            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                marker.setLatLng([lat, lng]);
                updateCoordFields(lat, lng);
            });

            // رویداد کشیدن نشانگر
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
                } else {
                    // در صورت نبودن مختصات برای شهر، می‌توان اخطار داد یا کاری نکرد
                    console.warn('این شهر مختصات ندارد.');
                }
            });

            // --- شبکه‌های اجتماعی داینامیک ---
            const socialContainer = $('#social-container');
            let socialIndex = 0;

            // تابع ساخت یک آیتم جدید
            function addSocialItem(platform = '', url = '') {
                const item = $(`
                    <div class="social-item">
                        <div class="row">
                            <div class="col-md-5">
                                <select name="social[${socialIndex}][platform]" class="form-control">
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
                                <input type="url" name="social[${socialIndex}][url]" class="form-control" placeholder="آدرس پروفایل" value="${url}">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-sm btn-danger remove-social">حذف</button>
                            </div>
                        </div>
                    </div>
                `);

                // دکمه حذف
                item.find('.remove-social').click(function() {
                    item.remove();
                });

                socialContainer.append(item);
                socialIndex++;
            }

            // دکمه افزودن
            $('#add-social').click(function() {
                addSocialItem();
            });

            // در صورت وجود داده‌های قبلی (مثلاً در حالت ویرایش)، آن‌ها را اضافه کنید.
            // در اینجا فقط نمونه ساده برای شروع است.
            // اگر بخواهید پیش‌فرض چند تا خالی باشد:
            addSocialItem(); // یک ردیف خالی اضافه می‌کند

        });
    </script>
@endpush
