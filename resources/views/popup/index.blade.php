@extends('admin-layout')

@section('title','لیست پاپ آپ‌ها')

@section('main-content')
<section class="content">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('popup.create') }}"
               class="btn btn-danger btn-flat float-left">+</a>
            <div class="card-title float-right">پاپ آپ‌ها</div>
        </div>

        <div class="card-body">
            <table class="table table-striped text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان فارسی</th>
                    <th>بازه زمانی</th>
                    <th>وضعیت</th>
                    <th>ویرایش</th>
                    <th>حذف</th>
                </tr>
                </thead>

                <tbody>
                @foreach($popups as $popup)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $popup->title_fa }}</td>

                        <td>
                            <span>{{ $popup->start_at ? $popup->start_at->format('Y-m-d') : '—' }}</span>
                            تا
                            <span>{{ $popup->end_at ? $popup->end_at->format('d-m-Y') : '—' }}</span>
                        </td>

                        <td>
                            <a href="#" class="changeVisibility"
                               data-id="{{ $popup->id }}">
                                @if($popup->is_active)
                                    فعال
                                @else
                                    غیرفعال
                                @endif
                            </a>
                        </td>

                        <td>
                            <a href="{{ route('popup.edit',$popup) }}"
                               class="btn btn-outline-primary btn-sm">ویرایش</a>
                        </td>

                        <td>
                            <form method="POST"
                                  action="{{ route('popup.destroy',$popup) }}">
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
