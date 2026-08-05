@extends('user.user-layout')

@push('link')
    <style type="text/css">
        @media (min-width: 992px) {
            .modal-dialog {
                max-width: 90% !important;
            }
        }
    </style>
@endpush

@section('card-title', __('user.comments.card_title'))
@section('user-content')

    @isset($comments)
        <div class="row">
            @foreach ($comments->groupby('commentable_type') as $comment)
                @foreach ($comment->groupby('commentable_id') as $com)
                    <div class=" col-sm-12 col-md-6 col-lg-4 conversationBox ">
                        <div class="card card-primary card-outline ml-3" data-class="commentCard">
                            <div class="card-body box-profile">
                                {{-- -{{ $com[0]->commentable_type }} --}}
                                <div class="text-center" style="height: 150px">
                                    @php $image = $com[0]->commentable->images->first(); @endphp
                                    <img class=" img-fluid" src="{{ asset('storage/images/thumbnails/' . $image['name']) }}"
                                        alt="{{ $image['name'] }}">
                                </div>

                                {{-- <h3 class="profile-username text-center">فاطمه برهمند</h3> --}}

                                <p class="text-muted text-center pt-2" style="line-height: 1.7rem;height: 4rem;">
                                    {{ app()->getLocale() == 'fa' ? $com[0]->commentable->category->title : $com[0]->commentable->category->e_title }} {{ __('user.comments.design') }}
                                    {{ app()->getLocale() == 'fa' ? $com[0]->commentable->color_design->design->title : $com[0]->commentable->color_design->design->e_title }} {{ __('user.comments.color') }}
                                    {{ app()->getLocale() == 'fa' ? $com[0]->commentable->color_design->color->color : $com[0]->commentable->color_design->color->e_color }}
                                </p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>{{ __('user.comments.fields.date') }}</b>
                                        <span>{{ verta($com[0]->created_at)->format('%d %B، %Y') }}</span>
                                    </li>
                                    @if ($com->count() == 1)
                                        <li class="list-group-item">
                                            <b>{{ __('user.comments.fields.status') }}</b>
                                            <span>
                                                @if ($com[0]->status == 0)
                                                    <span>{{ __('user.comments.statuses.approved') }}</span>
                                                @elseif($com[0]->status == 1)
                                                    <span>{{ __('user.comments.statuses.pending') }}</span>
                                                @endif
                                            </span>
                                        </li>
                                    @endif
                                    @if ($com->count() > 1)
                                        <li class="list-group-item">
                                            <b>{{ __('user.comments.fields.count') }}</b>
                                            <span>{{ $com->count() }}</span>
                                        </li>
                                    @endif

                                </ul>

                                <a href="#" data-id="{{ $com[0]->commentable->id }}"
                                    class="btn btn-outline-success btn-flat btn-sm float-right detail" data-toggle="modal"
                                    data-target="#commentText{{ $com[0]->id }}">
                                    <i class="fa fa-comment"></i> {{ __('user.comments.buttons.view') }}
                                </a>

                                <div class="modal fade row" id="commentText{{ $com[0]->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="commentTextLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered col-12" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="commentTextLabel">
                                                    {{ app()->getLocale() == 'fa' ? $com[0]->commentable->category->title : $com[0]->commentable->category->e_title }}
                                                    {{ __('user.comments.design') }}
                                                    {{ app()->getLocale() == 'fa' ? $com[0]->commentable->color_design->design->title : $com[0]->commentable->color_design->design->e_title }}
                                                    {{ __('user.comments.color') }}
                                                    {{ app()->getLocale() == 'fa' ? $com[0]->commentable->color_design->color->color : $com[0]->commentable->color_design->color->e_color }}
                                                </h6>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table text-center">
                                                    <tr>
                                                        <th>{{ __('user.comments.modal.columns.row') }}</th>
                                                        <th>{{ __('user.comments.modal.columns.date') }}</th>
                                                        <th>{{ __('user.comments.modal.columns.text') }}</th>
                                                        <th>{{ __('user.comments.modal.columns.status') }}</th>
                                                        <th>{{ __('user.comments.modal.columns.delete') }}</th>
                                                    </tr>

                                                    @foreach ($com as $key => $memo)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                {{ verta($memo->created_at)->format('%d %B، %Y') }}
                                                            </td>
                                                            <td>
                                                                {{ $memo->text }}
                                                            </td>
                                                            <td>
                                                                @if ($memo->status == 0)
                                                                    <span
                                                                        class="text-success">{{ __('user.comments.statuses.approved') }}</span>
                                                                @elseif($memo->status == 1)
                                                                    <span
                                                                        class="text-danger">{{ __('user.comments.statuses.pending') }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="#" data-id="{{ $memo->id }}"
                                                                    data-model="{{ $memo->commentable_type }}"
                                                                    data-parent="{{ $memo->commentable_id }}"
                                                                    class="deleteComment"><i class="far fa-trash-alt"></i></a>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{ __('user.comments.buttons.close') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <a href="#" data-id="{{ $com[0]->commentable->id }}"
                                    data-model="{{ $com[0]->commentable_type }}"
                                    class="btn btn-outline-danger btn-flat btn-sm float-left deleteComments">
                                    <i class="far fa-trash-alt"></i> {{ __('user.comments.buttons.delete') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    @endisset
@endsection


@push('js')
    <script type="text/javascript">
        $(function() {
            // console.log("ll",$('#16'));
            $(document).on('click', '.deleteComment', function(event) {
                event.preventDefault();
                var $thiz = $(this);
                var id = $(this).data("id");
                var model = $(this).data("model");
                var parentId = $(this).data("parent");
                var url = document.location.origin + "/user/comments/deleteComment/";

                swal({
                        title: "{{ __('user.comments.js.confirm_delete_single_title') }}",
                        text: "{{ __('user.comments.js.confirm_delete_single_text') }}",
                        icon: "warning",
                        buttons: [
                            "{{ __('user.comments.js.cancel') }}",
                            "{{ __('user.comments.js.confirm') }}"
                        ],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: 'GET',
                                url: url,
                                data: {
                                    id: id,
                                    model: model,
                                    parentId: parentId,
                                },
                                success: function(data) {
                                    console.log(data);
                                    title = "";
                                    if (data.res == "error") {
                                        title = "{{ __('user.comments.js.error_title') }}";
                                    } else if (data.res == "success") {
                                        $thiz.parents('tr').hide("slow");
                                        title = "{{ __('user.comments.js.success_title') }}";
                                        if (data.count == 0) {
                                            $thiz.parents('.modal').modal('hide');
                                            $thiz.parents("[id^=card]").fadeOut("fast");
                                        }
                                    }
                                    swal(title, data.message, data.res);
                                }
                            })
                        }
                    })
            });


            $(document).on('click', '.deleteComments', function(event) {
                event.preventDefault();
                var $thiz = $(this);
                var id = $(this).data("id");
                var model = $(this).data("model");
                var url = document.location.origin + "/user/comments/deleteComments/";
                swal({
                        title: "{{ __('user.comments.js.confirm_delete_single_title') }}",
                        text: "{{ __('user.comments.js.confirm_delete_all_text') }}",
                        icon: "warning",
                        buttons: ["{{ __('user.comments.js.cancel') }}", "{{ __('user.comments.js.confirm') }}"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: 'GET',
                                url: url,
                                data: {
                                    id: id,
                                    model: model,
                                },
                                success: function(data) {
                                    // console.log(data);
                                    title = "";
                                    if (data.res == "error") {
                                        title = "{{ __('user.comments.js.error_title') }}";
                                    } else if (data.res == "success") {
                                        title = "{{ __('user.comments.js.success_title') }}";
                                        $thiz.parents(".conversationBox").fadeOut("fast");
                                    }
                                    swal(title, data.message, data.res);
                                }
                            })
                        }
                    })
            });






        }); //end
    </script>
@endpush
