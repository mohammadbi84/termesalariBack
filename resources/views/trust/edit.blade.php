@extends('admin-layout')

@section('title', 'تنظیمات بخش اعتماد به ما')

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
                        <div class="card-title">تنظیمات بخش اعتماد به ما</div>
                    </div>

                    <form action="{{ route('trust.update') }}" method="POST">
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

                            {{-- ================= شمارنده‌ها ================= --}}
                            <h5 class="mb-3 text-success">شمارنده‌ها</h5>

                            <div id="counters-container">
                                @if (isset($section) && $section->counters->count())
                                    @foreach ($section->counters as $i => $counter)
                                        <div class="counter-item border p-3 mb-2">
                                            <div class="form-row">
                                                <div class="col">
                                                    <input type="text" name="counters[{{ $i }}][title_fa]"
                                                        class="form-control mb-1" placeholder="عنوان فارسی"
                                                        value="{{ $counter->title_fa }}">
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="counters[{{ $i }}][title_en]"
                                                        class="form-control mb-1" placeholder="Title English"
                                                        value="{{ $counter->title_en }}">
                                                </div>
                                                <div class="col">
                                                    <input type="number" name="counters[{{ $i }}][number]"
                                                        class="form-control mb-1" placeholder="عدد"
                                                        value="{{ $counter->number }}">
                                                </div>
                                                <div class="col-auto">
                                                    <button type="button"
                                                        class="btn btn-danger btn-remove-counter">حذف</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <button type="button" class="btn btn-success mb-3" id="add-counter">افزودن شمارنده</button>

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
    <script>
        let counterIndex = {{ isset($section) ? $section->counters->count() : 0 }};

        // اضافه کردن شمارنده جدید
        $('#add-counter').click(function() {
            let html = `<div class="counter-item border p-3 mb-2">
        <div class="form-row">
            <div class="col">
                <input type="text" name="counters[${counterIndex}][title_fa]" class="form-control mb-1" placeholder="عنوان فارسی">
            </div>
            <div class="col">
                <input type="text" name="counters[${counterIndex}][title_en]" class="form-control mb-1" placeholder="Title English">
            </div>
            <div class="col">
                <input type="number" name="counters[${counterIndex}][number]" class="form-control mb-1" placeholder="عدد">
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger btn-remove-counter">حذف</button>
            </div>
        </div>
    </div>`;
            $('#counters-container').append(html);
            counterIndex++;
        });

        // حذف شمارنده
        $(document).on('click', '.btn-remove-counter', function() {
            $(this).closest('.counter-item').remove();
        });
    </script>
@endpush
