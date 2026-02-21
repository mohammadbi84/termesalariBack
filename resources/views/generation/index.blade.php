@extends('admin-layout')

@section('title', 'لیست خاندان ترمه سالاری')

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
        <div class="row">
            <div class="col-12">
                @if (session()->has('success') or session()->has('danger'))
                    <div
                        class="alert  @if (session()->has('success')) alert-success @elseif(session()->has('danger')) alert-danger @endif  alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fa fa-check"></i> توجه!</h5>
                        @if (session()->has('success'))
                            {{ session('success') }}
                        @elseif(session()->has('danger'))
                            {{ session('danger') }}
                        @endisset
                </div>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <a href="{{ route('generation.create') }}" class="pr-3 pl-3 pt-2 pb-2 btn btn-flat btn-danger float-left "
                title="">+</a>
            <div class="card-title float-right"><span>خاندان ترمه سالاری</span></div>
        </div>
        <div class="card-body">
            <table id="dataTable-table" class="table table-striped display nowrap dataTable"
                style="width:100%;text-align: center;" cellspacing="0">
                <thead>
                    <tr>
                        <th class="no-sort">
                            <label>
                                <input type="checkbox" data-value = "All" class="flat-red checkAll">
                            </label>
                        </th>
                        <th class="no-sort">ردیف</th>
                        <th>نام</th>
                        <th>عنوان</th>
                        <th>توضیحات</th>
                        <th>تاریخ ثبت</th>
                        <th class="no-sort">ویرایش</th>
                        <th class="no-sort">حذف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($generations as $generation)
                        <tr>
                            <td>
                                <label>
                                    <input type="checkbox" data-value = "{{ $generation->id }}" class="flat-red checkbox">
                                </label>
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $generation->name_fa }}
                            </td>
                            <td>
                                {{ $generation->pretext_fa }}
                            </td>
                            <td>
                                {{ $generation->description_fa }}
                            </td>
                            <td>
                                {{ Verta($generation->created_at)->format('%d %B %Y') }}
                            </td>
                            <td>
                                <a href="{{ route('generation.edit', [$generation]) }}"
                                    class="btn btn-outline-primary btn-flat btn-sm"><i class="fas fa-edit"></i> ویرایش
                                </a>
                            </td>
                            <td>
                                <form class="del-form" action="{{ route('generation.destroy', [$generation]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    {{-- <input type="submit" class="btn btn-outline-danger btn-flat delete" value="حذف " name="submit"> --}}
                                    <a href="#" class="btn btn-outline-danger btn-flat btn-sm delete"><i
                                            class="fas fa-trash-alt"></i> حذف </a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="no-sort">

                        </th>
                        <th class="no-sort">ردیف</th>
                        <th>نام</th>
                        <th>عنوان</th>
                        <th>توضیحات</th>
                        <th>تاریخ ثبت</th>
                        <th class="no-sort">ویرایش</th>
                        <th class="no-sort">حذف</th>
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
    $(function() {
        $(document).on('click', '.delete', function(event) {
            event.preventDefault();
            // event.stopPropagation();
            var $thiz = $(this);
            swal({
                    title: "آیا از حذف این رکورد مطمئن هستید؟",
                    text: "با انجام این کار، این رکورد حذف خواهد شد.",
                    icon: "warning",
                    buttons: ["انصراف", "حذف"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        // title = "عملیات با موفقیت انجام شد.";
                        // swal(title, data.message,data.res);
                        // thiz.closest("tr").fadeOut('slow');
                        // $thiz.unbind('click').click();
                        $thiz.parent('.del-form').submit()
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

    });
</script>
@endpush
