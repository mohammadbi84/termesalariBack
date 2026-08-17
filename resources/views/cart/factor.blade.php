@extends('store-layout')

@push('link')
    <style type="text/css">
        #TopMenuCartIcone {
            display: none;
        }

        .datepicker-grid-view .header {
            background-color: unset !important;
            height: unset !important;
            padding: unset !important;
        }

        #print-header,
        #print-footer {
            display: none;
        }

        @media print {

            #print-header,
            #print-footer {
                display: block;
            }

            #header,
            #footer,
            .back-to-top,
            #buttons {
                display: none !important;
            }

            #print-footer {
                position: fixed;
                bottom: 30px;
                right: 0;
                left: 0;
            }
        }
    </style>
@endpush

@section('title', __('cart.invoice.title'))

@section('main-content')

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="text-center" id="print-header">
                    <img src="{{ asset('storetemplate/dist/img/logo-print.png') }}" alt="Termeh Salari Logo" class="mb-3">
                    <div class="mb-3">
                        <h4 style="display: inline-block;">{{ __('cart.invoice.store_name') }}</h4>
                    </div>
                </div>
                <div class="card" style="clear: both;">
                    <div class="card-header">
                        <div class="card-title">
                            <span>{{ __('cart.invoice.card_title') }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-6 col-sm-12 mb-4 text-right">
                                <b>{{ __('cart.invoice.code_label') }}</b><span>{{ $order->code }}</span>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-4 text-left">
                                <b>{{ __('cart.invoice.date_label') }}</b><span>{{ Verta($order->created_at)->format('%d %B، %Y H:m:s') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table" style="overflow: scroll;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('user.order_detail.items_table.row') }}</th>
                                            <th>{{ __('user.order_detail.items_table.product') }}</th>
                                            <th>{{ __('user.order_detail.items_table.count') }}</th>
                                            <th>{{ __('user.order_detail.items_table.amount') }}</th>
                                            <th>{{ __('user.order_detail.items_table.discount') }}</th>
                                            <th>{{ __('user.order_detail.items_table.payable') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderitems as $orderitem)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @php
                                                        $image = $orderitem->orderitemable->images->first();
                                                    @endphp
                                                    <img src="{{ asset('storage/' . $image['name']) }}"
                                                        alt="" class="img-circle img-size-50 mr-2">
                                                    {{ $orderitem->orderitemable->category->title }}
                                                    {{ __('products.design') }}
                                                    {{ $orderitem->orderitemable->color_design->design->title }}
                                                    {{ __('products.color') }}
                                                    {{ $orderitem->orderitemable->color_design->color->color }}
                                                </td>
                                                <td>{{ $orderitem->count }}</td>
                                                <td>{{ number_format($orderitem->price) }} {{ $order->local }}</td>
                                                <td>{{ number_format($orderitem->offPrice) }} {{ $order->local }}</td>
                                                <td>{{ number_format($orderitem->price - $orderitem->offPrice) }}
                                                    {{ $order->local }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                @php
                                    $sumOff = 0;
                                    $sumPay = 0;
                                    $sumPrice = 0;
                                    foreach ($order->orderitems as $orderitem) {
                                        $sumPay =
                                            $sumPay +
                                            $orderitem->count * ($orderitem->price - $orderitem->offPrice) +
                                            $order->postPrice;
                                        $sumOff = $sumOff + $orderitem->offPrice * $orderitem->count;
                                        $sumPrice = $sumPrice + $orderitem->count * $orderitem->price;
                                    }
                                    if ($order->discount_card_id != '') {
                                        // $sumPay = $sumPay + $order->postPrice - session("discountCardPrice");
                                        if ($order->discountCard->type == 'price') {
                                            $sumPay = $sumPay + $order->postPrice - $order->discountCard->amount;
                                        } elseif ($order->discountCard->type == 'percent') {
                                            $sumPay =
                                                $sumPay +
                                                $order->postPrice -
                                                ($order->discountCard->amount * $sumPrice) / 100;
                                        }
                                    } else {
                                        $sumPay = $sumPay + $order->postPric;
                                    }
                                @endphp
                                <div class="row mt-4">
                                    <div class="col-sm-12 col-md-3 mb-4">
                                        <b>{{ __('user.order_detail.summary.total') }} :
                                        </b>{{ number_format($sumPrice) }} {{ $order->local }}
                                    </div>
                                    <div class="col-sm-12 col-md-3 mb-4">
                                        <b>{{ __('user.order_detail.summary.total_discount') }} :
                                        </b>{{ number_format($sumOff) }} {{ $order->local }}
                                    </div>
                                    @if ($order->discount_card_id != '')
                                        <div class="col-sm-12 col-md-3 mb-4">
                                            <b>{{ __('user.order_detail.summary.special_discount') }} :
                                            </b>{{-- {{ number_format(session("discountCardPrice")) }} {{ $order->local }} --}}
                                            @php
                                                if ($order->discountCard->type == 'price') {
                                                    print number_format($order->discountCard->amount);
                                                } elseif ($order->discountCard->type == 'percent') {
                                                    print number_format(
                                                        ($order->discountCard->amount * $sumPrice) / 100,
                                                    );
                                                }
                                            @endphp
                                            {{ $order->local }}
                                        </div>
                                    @endif
                                    <div class="col-sm-12 col-md-3 mb-4">
                                        <b>{{ __('user.order_detail.summary.total_payable_with_shipping') }} : </b>
                                        {{ number_format($sumPay) }} {{ $order->local }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-header">
                            <div class="card-header"><span>{{ __('user.order_detail.recipient_info.title') }}</span></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <b>{{ __('user.order_detail.recipient_info.name') }} : </b>
                                    {{ $order->recipient->name }}
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <b>{{ __('user.order_detail.recipient_info.family') }} : </b>
                                    {{ $order->recipient->family }}
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <b>{{ __('user.order_detail.recipient_info.national_code') }} : </b>
                                    {{ $order->recipient->nationalCode }}
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <b>{{ __('user.order_detail.recipient_info.mobile') }} : </b>
                                    {{ $order->recipient->mobile }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9 col-sm-12 mb-4">
                                    <b>{{ __('user.order_detail.recipient_info.address') }} : </b>
                                    {{ $order->recipient->city->name }} -
                                    {{ $order->recipient->subcity->name }} - {{ $order->recipient->address }} -
                                    {{ __('user.order_detail.recipient_info.house_number') }}
                                    {{ $order->recipient->houseId }}
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <b>{{ __('user.order_detail.recipient_info.zipcode') }} : </b>
                                    {{ $order->recipient->zipcode }}
                                </div>
                            </div>
                        </div>
                        @php
                            $payment = $order
                                ->payments()
                                ->where(function ($query) {
                                    $query->whereNotNull('tracing_code')->orWhere('res_code', '0');
                                })
                                ->first();
                            //dd($payment);
                        @endphp
                        @isset($payment)
                            <div class="card-header">
                                <div class="card-title"><span>{{ __('user.order_detail.payment_info.title') }}
                                        {{ $payment->payment_method->title }}</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 mb-4">
                                            <b>{{ __('user.order_detail.payment_info.ref_number') }} :
                                            </b><span>{{ $payment->tracing_code ?? $payment->saleReferenceId }}</span>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-4">
                                            <b>{{ __('user.order_detail.payment_info.payment_date') }} :
                                            </b><span>{{ Verta($payment->date)->format('%d %B، %Y H:m:s') }}</span>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-4">
                                            <b>{{ __('user.order_detail.payment_info.amount') }} :
                                            </b><span>{{ number_format($payment->price) }}
                                                {{ $order->local }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endisset

                            <div class="card-header">
                                <div class="card-title"><span>{{ __('user.order_detail.shipping_info.title') }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 mb-4">
                                        <b>{{ __('user.order_detail.shipping_info.method') }} :
                                        </b><span>{{ $order->post->title }}</span>
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-4">
                                        <b>{{ __('user.order_detail.shipping_info.cost') }} :
                                        </b><span>{{ $order->postPrice }} {{ $order->local }}</span>
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-4">
                                        <b>{{ __('user.checkout_step2.shipping.delivery_time') }} :</b><span>
                                            {{ $order->post->delivery_time }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-12" id="print-footer">
                        <div class="float-right">
                            <p style="line-height: 45px">
                                {{ __('cart.invoice.central_store') }}
                                <br>
                                {{ __('cart.invoice.branch_store') }}
                            </p>
                        </div>
                        <div class="float-left text-left" style="direction: ltr">
                            <p>
                                <i class="fas fa-globe-asia"></i> {{ __('cart.invoice.website') }} <br>
                                <i class="far fa-envelope"></i> {{ __('cart.invoice.email') }} <br>
                                <i class="fab fa-instagram"></i> {{ __('cart.invoice.instagram') }} <br>
                                <i class="far fa-paper-plane"></i> <i class="fab fa-whatsapp"></i>
                                {{ __('cart.invoice.whatsapp') }}
                            </p>
                        </div>

                    </div>
                    <div id="buttons" style="margin-bottom: 40px;">
                        <a href="#"
                            class="btn btn-success btn-flat printPage">{{ __('cart.invoice.print_button') }}</a>
                        <a href="{{ route('homeStore.index') }}"
                            class="btn btn-flat btn-primary">{{ __('cart.invoice.home_button') }}</a>
                        <a href="{{ route('user.myOrders') }}"
                            class="btn btn-flat btn-secondary">{{ __('cart.invoice.orders_button') }}</a>
                    </div>



                </div>
            </div>
    </section>
@endsection

@push('js')
    <script type="text/javascript">
        $(function() {
            $('a.printPage').click(function(event) {
                event.preventDefault();
                window.print();
                return false;
            });
        }); //end
    </script>
@endpush
