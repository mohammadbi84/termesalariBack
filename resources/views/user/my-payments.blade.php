@extends('user.user-layout')

@push('user-link')
    <style type="text/css">
        a.nav-link.active {
            border: 0;
            border-bottom: 1px solid #aaaaaa !important;
            color: #aaaaaa !important;
        }

        a.nav-link.active>i {
            color: #aaaaaa;
        }

        .nav-tabs .nav-link:focus,
        .nav-tabs .nav-link:hover {
            border: 0px !important;
        }

        .nav-side-menu li a.myOrders,
        {
        color: red !important;
        }
    </style>
@endpush

@section('title', __('user.payments.title'))
@section('card-title', __('user.payments.card_title'))



@push('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@section('user-content')
    {{-- <section class="content">
      	<div class="row">
	        <div class="col-12">
				<div class="card">
		            <div class="card-header">
		              	<h3 class="card-title float-right">
		              		<span>
		              			لیست پرداخت ها
		              		</span>
		              	</h3>
		            </div>

		            <div class="card-body"> --}}
    <table id="dataTable-table" class="table table-striped display nowrap dataTable" style="width:100%;text-align: center;"
        cellspacing="0">
        <thead>
            <tr>
                <th class="no-sort">{{ __('user.payments.columns.row') }}</th>
                <th>{{ __('user.payments.columns.method') }}</th>
                <th>{{ __('user.payments.columns.ref_number') }}</th>
                <th>{{ __('user.payments.columns.amount') }} ({{ __('user.order_summary.currency') }})</th>
                <th>{{ __('user.payments.columns.date') }}</th>
                <th>{{ __('user.payments.columns.invoice_code') }}</th>
                <th>{{ __('user.payments.columns.description') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($listPayments as $key => $payment)
                {{-- {{ dd($payment) }} --}}
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $payment->payment_method->title }}</td>
                    <td>{{ $payment->tracing_code ?? $payment->saleReferenceId }}</td>
                    <td>{{ number_format($payment->price) }}</td>
                    <td>{{ Verta($payment->date)->format('%d %B %Y H:m:s') }}</td>
                    <td><a href="{{ route('user.myOrder', [$payment->order]) }}">{{ $payment->order->code }}</a></td>
                    <td>{{ $payment->description }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <th class="no-sort">{{ __('user.payments.columns.row') }}</th>
                <th>{{ __('user.payments.columns.method') }}</th>
                <th>{{ __('user.payments.columns.ref_number') }}</th>
                <th>{{ __('user.payments.columns.amount') }}</th>
                <th>{{ __('user.payments.columns.date') }}</th>
                <th>{{ __('user.payments.columns.invoice_code') }}</th>
                <th>{{ __('user.payments.columns.description') }}</th>
            </tr>
        </tfoot>
    </table>
    {{-- </div> --}}
    <!-- /.card-body -->
    {{-- </div> --}}
    <!-- /.card -->
    {{-- </div> --}}
    <!-- /.col -->
    {{-- </div> --}}
    <!-- /.row -->
    {{-- </section> --}}
    <!-- /.content -->
@endsection

@push('js')
    <!-- DataTables -->
    <script src="{{ asset('/storetemplate/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script>
        $(function() {

            $('#dataTable-table').DataTable({
                "language": {
                    "paginate": {
                        "next": "{{ __('user.payments.datatable.next') }}",
                        "previous": "{{ __('user.payments.datatable.previous') }}"
                    },
                    "decimal": ",",
                    "thousands": ".",
                    "search": "{{ __('user.payments.datatable.search') }}",
                    "lengthMenu": "{{ __('user.payments.datatable.length_menu') }}",
                    "info": "{{ __('user.payments.datatable.info') }}",
                    "infoEmpty": "{{ __('user.payments.datatable.info_empty') }}",
                    "infoFiltered": "{{ __('user.payments.datatable.info_filtered') }}",
                    "zeroRecords": "{{ __('user.payments.datatable.zero_records') }}",
                    "loadingRecords": "{{ __('user.payments.datatable.loading_records') }}"
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
                }, ],
            });
        }) //End
    </script>
@endpush
