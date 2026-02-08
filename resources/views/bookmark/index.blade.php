@extends('admin-layout')

@section('title', 'لیست بوکمارک ها')
@push('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/datatables/dataTables.bootstrap4.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/iCheck/all.css') }}">
    <style>
        .dataTable tr td{
            text-align: center;
        }
    </style>
@endpush
@section('main-content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('bookmark.create') }}" class="btn btn-danger btn-flat float-left">+</a>
                <div class="card-title float-right"><span>بوکمارک ها</span></div>
            </div>

            <div class="card-body">
                <table id="dataTable-table" class="table table-striped display nowrap dataTable" style="width:100%;text-align: center;" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="no-sort">
                                <label>
                                    <input type="checkbox" data-value = "All" class="flat-red checkAll">
                                </label>
                            </th>
                            <th>ردیف</th>
                            <th>چیدمان</th>
                            <th>عنوان</th>
                            <th>تاریخ و ساعت ایجاد</th>
                            <th>تاریخ و ساعت انتشار</th>
                            <th>تاریخ و ساعت انقضا</th>
                            <th class="">تایمر</th>
                            <th class="no-sort">وضعیت</th>
                            <th class="no-sort">عمل ها</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($bookmarks as $bookmark)
                            <tr>
                                <td>
                                    <label>
                                        <input type="checkbox" data-value = "{{ $bookmark->id }}"
                                            class="flat-red checkbox">
                                    </label>
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bookmark->sort }}</td>
                                <td>{{ $bookmark->title_fa }}</td>

                                <td>
                                    {{ Verta($bookmark->created_at)->format('%d %B %Y H:m:s') }}
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

                                <td class="d-flex justify-content-end">
                                    <a href="{{ route('bookmark.edit', $bookmark) }}"
                                        class="btn btn-outline-primary btn-sm ml-2">ویرایش</a>
                                        <form method="POST" action="{{ route('bookmark.destroy', $bookmark) }}">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm mr-2">
                                                حذف
                                            </button>
                                        </form>
                                </td>
                                {{-- <td>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="no-sort"></th>
                            <th>ردیف</th>
                            <th>چیدمان</th>
                            <th>عنوان</th>
                            <th>تاریخ و ساعت ایجاد</th>
                            <th>تاریخ و ساعت انتشار</th>
                            <th>تاریخ و ساعت انقضا</th>
                            <th class="no-sort">تایمر</th>
                            <th class="no-sort">وضعیت</th>
                            <th class="no-sort">عمل ها</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <!-- DataTables -->
    <script src="{{ asset('/storetemplate/plugins/datatables/jquery.dataTables.js') }}"></script>
    {{-- <script src="{{asset('/storetemplate/dist/js/dataTable.js')}}"></script> --}}
    <script src="{{ asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('/storetemplate/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('/storetemplate/dist/js/iCheck-custom.js') }}"></script>
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
        $('#dataTable-table').DataTable({
            "language": {
                "paginate": {
                    "next": "بعدی",
                    "previous": "قبلی",
                },
                // "searchPanes":{
                // 	"count":'{total} found',
                // 	"countFiltered": '{shown} ({total})',
                // },
                "decimal": ",",
                "thousands": ".",
                "search": "جستجو : ",
                "lengthMenu": 'نمایش   <select>' +
                    '<option value="10">10</option>' +
                    '<option value="20">20</option>' +
                    '<option value="30">30</option>' +
                    '<option value="40">40</option>' +
                    '<option value="50">50</option>' +
                    '<option value="-1">همه</option>' +
                    '</select> سطر',

            },
            "info": false,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "autoWidth": true,
            "scrollX": true,
            "responsive": true,
            "order": [],
            "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                },
                // { "width": "10%", "targets": 9 }
            ],
            // "saerchPanes":{
            // 	"viewTotal":true,
            // },
            // "dom":'Pfrtip'


        });
    </script>
@endpush
