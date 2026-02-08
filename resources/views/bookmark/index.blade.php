@extends('admin-layout')

@section('title', 'لیست بوکمارک ها')

@section('main-content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('bookmark.create') }}" class="btn btn-danger btn-flat float-left">+</a>
                <div class="card-title float-right">بوکمارک ها</div>
            </div>

            <div class="card-body">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ترتیب نمایش</th>
                            <th>عنوان فارسی</th>
                            <th>تاریخ ثبت</th>
                            <th>تاریخ شروع انتشار</th>
                            <th>تاریخ پایان انتشار</th>
                            <th>مدت نمایش <small>( ثانیه )</small></th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($bookmarks as $bookmark)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bookmark->sort }}</td>
                                <td>{{ $bookmark->title_fa }}</td>

                                <td>
                                    {{ Verta($bookmark->created_at)->format('%d %B %Y') }}
                                </td>
                                <td>
                                    <span>{{ $bookmark->start_at ? Verta($bookmark->start_at)->format('%d %B %Y H:m:s') : '—' }}</span>
                                </td>
                                <td>
                                    <span>{{ $bookmark->end_at ? Verta($bookmark->end_at)->format('%d %B %Y H:m:s') : '—' }}</span>
                                </td>
                                <td>
                                    {{ $bookmark->duration / 1000 }} ثانیه
                                </td>

                                <td>
                                    <a href="#" class="changeVisibility" id="changeVisibility"
                                        data-id="{{ $bookmark->id }}">
                                        @if ($bookmark->active)
                                            فعال
                                        @else
                                            غیرفعال
                                        @endif
                                    </a>
                                </td>

                                <td>
                                    <a href="{{ route('bookmark.edit', $bookmark) }}"
                                        class="btn btn-outline-primary btn-sm">ویرایش</a>
                                    <form method="POST" action="{{ route('bookmark.destroy', $bookmark) }}">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">
                                            حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).on('click', '.changeVisibility', function(event) {
            event.preventDefault();
            var url = "{{ route('bookmark.changeVisibility') }}";
            var id = $(this).data("id");
            var $thiz = $(this);
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _token: '<?php echo csrf_token(); ?>',
                    id: id,
                },
                success: function(data) {
                    // $("body").html(data);
                    console.log(data);

                    if (data.is_active) {
                        // alert('فعال شد')
                        $thiz.text('فعال');
                        // $("#changeVisibility").textContent = 'فعال';
                    } else {
                        // alert('غیرفعال شد')
                        $thiz.text('غیر فعال');
                        // $("#changeVisibility").textContent = 'غیر فعال';
                    }
                }
            });
        });
    </script>
@endpush
