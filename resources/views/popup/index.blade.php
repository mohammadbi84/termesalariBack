@extends('admin-layout')

@section('title', 'لیست پاپ آپ‌ها')

@section('main-content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('popup.create') }}" class="btn btn-danger btn-flat float-left">+</a>
                <div class="card-title float-right">پاپ آپ‌ها</div>
            </div>

            <div class="card-body">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان فارسی</th>
                            <th>بازه زمانی</th>
                            <th>ترتیب نمایش</th>
                            <th>وضعیت</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($popups as $popup)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $popup->title_fa }}</td>

                                <td>
                                    <span>{{ $popup->start_at ? Verta($popup->start_at)->format('%d %B %Y H:m:s') : '—' }}</span>
                                    تا
                                    <span>{{ $popup->end_at ? Verta($popup->end_at)->format('%d %B %Y H:m:s') : '—' }}</span>
                                </td>

                                <td>
                                    {{ $popup->sort }}
                                </td>
                                <td>
                                    <a href="#" class="changeVisibility" id="changeVisibility"
                                        data-id="{{ $popup->id }}">
                                        @if ($popup->is_active)
                                            فعال
                                        @else
                                            غیرفعال
                                        @endif
                                    </a>
                                </td>

                                <td>
                                    <a href="{{ route('popup.edit', $popup) }}"
                                        class="btn btn-outline-primary btn-sm">ویرایش</a>
                                </td>

                                <td>
                                    <form method="POST" action="{{ route('popup.destroy', $popup) }}">
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
            var url = "{{ route('popup.changeVisibility') }}";
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
                        document.getElementById("changeVisibility").textContent = `فعال`;
                        // $("#changeVisibility").textContent = 'فعال';
                    } else {
                        // alert('غیرفعال شد')
                        document.getElementById("changeVisibility").textContent = `غیر فعال`;
                        // $("#changeVisibility").textContent = 'غیر فعال';
                    }
                }
            });
        });
    </script>
@endpush
