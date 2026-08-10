@extends('admin-layout')

@section('title', 'پنل مدیریت | لیست شیوه های ارسال')

@push('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('storetemplate/plugins/datatables/dataTables.bootstrap4.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('storetemplate/plugins/iCheck/all.css') }}">
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
                        @endif
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('post.create') }}" class="pr-3 pl-3 pt-2 pb-2 btn btn-flat btn-danger float-left "
                            title="محصول جدید">+</a>
                        <h3 class="card-title float-right">
                            <span>
                                لیست شیوه های ارسال
                            </span>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="dataTable-postTable" class="table table-striped display nowrap dataTable "
                            style="width:100%;text-align: center;" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <label>
                                            <input type="checkbox" data-value = "All" class="flat-red checkAll">
                                        </label>
                                    </th>
                                    <th class="no-sort">ردیف</th>
                                    <th>عنوان</th>
                                    <th>هزینه ارسال</th>
                                    <th>زمان ارسال</th>
                                    <th class="no-sort">فعال</th>
                                    <th class="no-sort">ویرایش</th>
                                    <th class="no-sort">حذف</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>
                                            <label>
                                                <input type="checkbox" data-value = "{{ $post->id }}"
                                                    class="flat-red checkbox">
                                            </label>
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ number_format($post->price) }} تومان</td>
                                        <td>{{ $post->delivery_time }}</td>

                                        <td>
                                            @if ($post->active == 0)
                                                <a class="changeActive" href="#" data-id="{{ $post->id }}"><i
                                                        class="fas fa-close danger-color"></i></a>
                                            @else
                                                <a class="changeActive" href="#" data-id="{{ $post->id }}"><i
                                                        class="fas fa-check success-color"></i> </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('post.edit', [$post]) }}"
                                                class="btn btn-outline-primary btn-flat btn-sm"><i class="fas fa-edit"></i>
                                                ویرایش </a>
                                        </td>
                                        <td>
                                            <form class="del-form" action="{{ route('post.destroy', [$post]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <a href="#" data-id="{{ $post->id }}"
                                                    class="btn btn-outline-danger btn-flat btn-sm delete"><i
                                                        class="fas fa-trash-alt"></i> حذف </a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="no-sort">ردیف</th>
                                    <th>عنوان</th>
                                    <th>هزینه ارسال</th>
                                    <th>زمان ارسال</th>
                                    <th class="no-sort">فعال</th>
                                    <th class="no-sort">ویرایش</th>
                                    <th class="no-sort">حذف</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <!-- DataTables -->
    <script src="{{ asset('storetemplate/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('storetemplate/dist/js/dataTable.js') }}"></script>
    <script src="{{ asset('storetemplate/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('storetemplate/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('storetemplate/dist/js/iCheck-custom.js') }}"></script>
    <!-- page script -->
    <script>
        $(function() {
            //-----------------------Data Table-------------------
            $('#dataTable-postTable').DataTable({
                "language": {
                    "paginate": {
                        "next": "بعدی",
                        "previous": "قبلی",
                    },
                    // "decimal": ",",
                    // "thousands": ".",
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
                    {
                        "width": "30%",
                        "targets": 3
                    }
                ],
            });
            //--------------Delete post-----------------------
            $(document).on('click', '.delete', function(event) {
                event.preventDefault();
                var id = $(this).data("id");
                var thiz = $(this);
                var addr = $(this).parents(".del-form").attr("action");
                swal({
                        title: "آیا از حذف این رنگ مطمئن هستید؟",
                        text: "این عمل غیرقابل بازگشت  می باشد.",
                        icon: "warning",
                        buttons: ["انصراف", "حذف"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $(".loader").show();
                            $.ajax({
                                type: 'POST',
                                url: addr,
                                data: {
                                    _token: '<?php echo csrf_token(); ?>',
                                    _method: 'DELETE',
                                    id: id,
                                },
                                success: function(data) {
                                    title = ''
                                    if (data.res == "error") {
                                        title = "خطا  در اجرای عملیات";
                                    } else if (data.res == "success") {
                                        title = "عملیات با موفقیت انجام شد.";
                                        thiz.closest("tr").fadeOut('slow');
                                    }
                                    swal(title, data.message, data.res);
                                    $(".loader").hide();
                                }
                            });
                        }
                    });

            });


            //-----------------------change Statuse---------------------------
			$(".changeActive").click(function(event){
				event.preventDefault();
				$(".loader").show();
				var id = $(this).data("id");
				var url = "{{ route('post.changeActive') }}";
				var $thiz = $(this);
				$.ajax({
				    type: 'POST',
				    url: url,
				    data: {
		              _token: '<?php echo csrf_token() ?>',
		              id: id,
		            },
				    success: function(data){
				        var $i = $thiz.children("i");
				        if($i.hasClass("fa-check"))
				        {
				        	$i.removeClass("fa-check success-color");
				        	$i.addClass("fa-close danger-color");
				        }
				        else if ($i.hasClass("fa-close"))
				        {
				        	$i.removeClass("fa-close danger-color");
				        	$i.addClass("fa-check success-color");
				        }

				        if(data.res == "error")
				        {
				        	title = "خطا  در اجرای عملیات" ;
				        }
				        else if(data.res == "success")
				        {
				        	title = "عملیات با موفقیت انجام شد.";
				        }
				        swal(title, data.message,data.res);
				        $(".loader").hide();

				    }
				});
			});



        }) //End
    </script>
@endpush
