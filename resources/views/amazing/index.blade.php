@extends('admin-layout')

@section('title', 'پنل مدیریت | لیست شگفت انگیز ها')

@push('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('storetemplate/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('storetemplate/plugins/datepicker-master/persian-datepicker.min.css') }}">
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
            </div>

            <div class="card col-md-12 col-sm-12">
                <div class="card-header">
                    <button type="button" class="pr-3 pl-3 pt-2 pb-2 btn btn-flat btn-danger float-left " title="طرح جدید"
                        data-toggle="modal" data-target="#createModal">+</button>
                    <div class="modal fade" id="createModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header px-0 pr-3">
                                    <h4 class="modal-title">ساخت بازه شگفت انگیز جدید</h4>
                                    <button type="button" class="close ml-0" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form
                                        action="{{ route('amazing.store', ['model' => substr($product->category->model, 4), 'id' => $product->id]) }}"
                                        method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <div class="form-group">
                                                    <label for="start_date">تاریخ شروع فروش</label>
                                                    <input type="text" name="start_date" id="start_date"
                                                        class="form-control date @error('start_date') is-invalid @enderror"
                                                        placeholder="روز مورد نظر را انتخاب کنید ." autocomplete="false"
                                                        value="{{ old('start_date') }}" autofocus="autofocus">
                                                    @error('start_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="form-group">
                                                    <label for="end_date">تاریخ پایان فروش</label>
                                                    <input type="text" name="end_date" id="end_date"
                                                        class="form-control date @error('end_date') is-invalid @enderror"
                                                        placeholder="روز مورد نظر را انتخاب کنید ." autocomplete="false"
                                                        value="{{ old('end_date') }}" autofocus="autofocus">
                                                    @error('end_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="max_sale">حداکثر تعداد</label>
                                                    <input type="number" name="max_sale" id="max_sale"
                                                        class="form-control @error('max_sale') is-invalid @enderror"
                                                        placeholder="درصورت خالی بودن این قسمت،کل موجودی این کالا بفروش می رسد"
                                                        value="{{ old('max_sale') }}" autofocus="autofocus">
                                                    @error('max_sale')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="discount">درصد تخفیف</label>
                                                    <input type="number" name="discount" id="discount"
                                                        class="form-control @error('discount') is-invalid @enderror"
                                                        placeholder="درصد تخفیف در فروش شگفت انگیز"
                                                        value="{{ old('discount') }}" autofocus="autofocus">
                                                    @error('discount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary btn-sm">ذخیره</button>
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    data-dismiss="modal">انصراف</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-title">
                        <span>لیست شگفت انگیز های محصول
                            {{ $product->category->title . ' طرح ' . $product->color_design->design->title . ' رنگ ' . $product->color_design->color->color }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table text-center" style="width:100%;" cellspacing="0" id="dataTable-table">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>تاریخ شروع فروش</th>
                                <th>تاریخ پایان فروش</th>
                                <th>حداکثر تعداد</th>
                                <th>تعداد فروش رفته</th>
                                <th>درصد تخفیف</th>
                                {{-- <th>ویرایش</th> --}}
                                <th class="no-sort">فعال</th>
                                <th class="no-sort">حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($amazings as $amazing)
                                {{-- @dd($amazing) --}}
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Verta($amazing->start_date)->format('%d %B %Y') }}</td>
                                    <td>{{ Verta($amazing->end_date)->format('%d %B %Y') }}</td>
                                    <td>{{ $amazing->max_sale }}</td>
                                    <td>{{ $amazing->sold }}</td>
                                    <td>{{ $amazing->discount }}</td>
                                    {{-- <td>
										<a href="{{route('amazing.edit',[$amazing])}}" class="btn btn-outline-primary btn-flat btn-sm"><i class="fas fa-edit"></i> ویرایش </a>
									</td> --}}
                                    <td>
											@if($amazing->active == 0)
												<a class="changeActive" href="#" data-id="{{$amazing->id}}"><i class="fas fa-close danger-color"></i></a>
											@else
												<a class="changeActive" href="#" data-id="{{$amazing->id}}"><i class="fas fa-check success-color"></i> </a>
											@endif
										</td>
                                    <td>
                                        @if (now() <= $amazing->start_date)
                                            <form class="del-form" action="{{ route('amazing.destroy', [$amazing]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                {{-- <input type="submit" name="" class="btn btn-outline-danger btn-flat btn-sm delete" value="حذف"> --}}
                                                <a href="#" data-id="{{ $amazing->id }}" data-model="Tablecloth"
                                                    class="btn btn-outline-danger btn-flat btn-sm delete"><i
                                                        class="fas fa-trash-alt"></i> حذف </a>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ردیف</th>
                                <th>تاریخ شروع فروش</th>
                                <th>تاریخ پایان فروش</th>
                                <th>حداکثر تعداد</th>
                                <th>تعداد فروش رفته</th>
                                <th>درصد تخفیف</th>
                                {{-- <th>ویرایش</th> --}}
                                <th>فعال</th>
                                <th>حذف</th>
                            </tr>
                        </tfoot>

                        {{-- @if ($amazings->count() > 0)
							<tr>
								<td colspan="7" style="text-align: center !important;">{{ $amazings->links() }}</td>
							</tr>
						@endif --}}
                    </table>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <!-- DataTables -->
    <script src="{{ asset('storetemplate/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('storetemplate/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('storetemplate/plugins/datepicker-master/persian-date.min.js') }}"></script>
    <script src="{{ asset('storetemplate/plugins/datepicker-master/persian-datepicker.min.js') }}"></script>
    <script>
        $(function() {
            //-----------------------Data Table-------------------
            $('#dataTable-table').DataTable({
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
                        "targets": 4
                    }
                ],
            });

            // date picker
            dateValue = $('.date').val();
            pd = $('.date').pDatepicker({
                onlySelectOnDate: true,
                autoClose: true,
                responsive: true,
                initialValueType: 'gregorian',
                persianDigit: false,
                format: 'YYYY/MM/DD',
                defaultDate: "",
                timePicker: {
                    "enabled": false,
                },
                monthPicker: {
                    "enabled": true,
                    "titleFormat": "YYYY",
                },
                yearPicker: {
                    "enabled": true,
                    "titleFormat": "YYYY",
                },
            });

            $('.date').val(dateValue);
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            @if (old('end_date'))
                $('#end_date').val("{{ old('end_date') }}");
            @endif

            @if (old('start_date'))
                $('#start_date').val("{{ old('start_date') }}");
            @endif

            //-----------------------delete data------------------------------------------
            $(document).on('click', '.delete', function(event) {
                event.preventDefault();
                var id = $(this).data("id");
                var thiz = $(this);
                var addr = $(this).parents(".del-form").attr("action");
                swal({
                        title: "آیا از حذف این طرح مطمئن هستید؟",
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
				var url = "{{ route('amazing.changeActive') }}";
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
        }); //end
    </script>
@endpush
