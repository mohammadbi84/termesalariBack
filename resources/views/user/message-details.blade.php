@extends('user.user-layout')

@push('user-link')
    <style type="text/css">


    </style>
@endpush

@section('card-title', __('user.message_detail.card_title'))
@section('user-content')
    <div class="card">
        <div class="card-body">
            <p>{{ __('user.message_detail.info.date') }} {{ Verta($messageStart->created_at)->format('%d %B، %Y') }}</p>
            <p>{{ __('user.message_detail.info.subject') }} {{ $messageStart->subject }}</p>
            <p>{{ __('user.message_detail.info.message') }} {{ $messageStart->message }}</p>
            <a href="{{ route('user.messages') }}" class="float-left">{{ __('user.message_detail.back_link') }} <i
                    class="fa fa-chevron-left"></i></a>
        </div>
    </div>

    @if ($messageDetails->count() > 0)
        <table class="table border-less text-center">
            <tr>
                <th>{{ __('user.message_detail.table.columns.row') }}</th>
                <th>{{ __('user.message_detail.table.columns.date') }}</th>
                <th>{{ __('user.message_detail.table.columns.message') }}</th>
                <th>{{ __('user.message_detail.table.columns.view') }}</th>
                <th>{{ __('user.message_detail.table.columns.delete') }}</th>
            </tr>

            @foreach ($messageDetails as $key => $message)
                <tr class="@if ($message->isRead == 0 and $message->user_id != Auth::id()) text-bold @endif messageDetail  @if ($message->user_id != Auth::id()) text-success @endif"
                    data-id="{{ $message->id }}" style="cursor: pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ Verta($message->created_at)->format('%d %B، %Y') }}</td>
                    <td>
                        <p>
                            {{ Str::limit($message->message, 30) }}
                        </p>
                    </td>
                    <td>
                        <a href="" class="messageRead text-success" data-id="{{ $message->id }}"><i
                                class="far @if ($message->user_id != Auth::id()) @if ($message->isRead == 0) fa-envelope  @else fa-envelope-open @endif
@else
fa-envelope-open @endif"
                                data-toggle="modal" data-target="#messagetText{{ $key }}"></i></a>
                    </td>
                    <td>
                        <a href="#" title="{{ __('user.message_detail.table.delete_tooltip') }}"
                            style="font-size: 1.2rem" class="del-message" data-id="{{ $message->id }}"><i
                                class="far fa-trash-alt"></i></a>
                    </td>
                </tr>

                <div class="modal fade row text-regular" id="messagetText{{ $key }}" tabindex="-1" role="dialog"
                    aria-labelledby="messagetTextLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered col-12" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="messagetTextLabel">
                                    {{ __('user.message_detail.modal.date_label') }} :
                                    {{ verta($message->created_at)->format('%d %B، %Y') }}
                                </h6>
                            </div>
                            <div class="modal-body">
                                {{-- <p>عنوان پیام : {{ $message->subject }}</p> --}}
                                <p>{{ $message->message }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('user.message_detail.modal.close_button') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </table>
    @endif
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('user.saveAnswer', $messageStart) }}">
                @csrf
                <div class="form-group">
                    <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror"
                        placeholder="{{ __('user.message_detail.reply_form.textarea_placeholder') }}" autofocus>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <input type="submit" class="btn btn-flat btn-primary"
                    value="{{ __('user.message_detail.reply_form.submit_button') }}" name="storeAnswer">
            </form>
        </div>
    </div>


@endsection


@push('js')
    <script type="text/javascript">
        $(function() {

            $(document).on('click', '.messageRead', function(event) {
                event.preventDefault();
                var message_id = $(this).data('id');
                var url = document.location.origin + "/user/message/detail/read/";
                var $child = $(this).children('i');
                $(this).parents('tr').removeClass('text-bold');
                if ($child.hasClass('fa-envelope')) {
                    $child.removeClass('fa-envelope');
                    $child.addClass('fa-envelope-open');
                }
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        message_id: message_id,
                        _token: '<?php echo csrf_token(); ?>',
                    },
                    success: function(data) {

                    }
                })
            });


            $(document).on('click', '.del-message', function(event) {
                event.preventDefault();
                var id = $(this).data("id");
                var thiz = $(this);
                var addr = "{{ route('user.delMessage') }}";
                swal({
                        title: "{{ __('user.message_detail.js.confirm_delete_title') }}",
                        text: "{{ __('user.message_detail.js.confirm_delete_text') }}",
                        icon: "warning",
                        buttons: [
                            "{{ __('user.message_detail.js.cancel') }}",
                            "{{ __('user.message_detail.js.confirm') }}"
                        ],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: 'POST',
                                url: addr,
                                data: {
                                    _token: '<?php echo csrf_token(); ?>',
                                    id: id,
                                },
                                success: function(data) {
                                    var title = '';
                                    if (data.res == "error") {
                                        title =
                                            "{{ __('user.message_detail.js.error_title') }}";
                                    } else if (data.res == "success") {
                                        title =
                                            "{{ __('user.message_detail.js.success_title') }}";
                                        thiz.closest("tr").fadeOut('slow');
                                    }
                                    swal(title, data.message, data.res);
                                }
                            });
                        }
                    });

            });


        }) //END
    </script>
@endpush
