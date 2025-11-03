@extends('auth.layout')

@section('title', 'تغییر رمز عبور')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-6">
            <div>
                @if(session()->has('success') or session()->has('danger'))
                    <div class="alert  @if(session()->has('success')) alert-success @elseif(session()->has('danger')) alert-danger @endif  alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <h5><i class="icon fa fa-check"></i> توجه!</h5>
                      @if(session()->has('success'))
                        {{session('success')}}
                      @elseif(session()->has('danger'))
                        {{session('danger')}}
                      @endisset
                    </div>
                @endif
            </div>
            <div class="card">
                
                <div class="card-body">
                    <form method="POST" action="{{ route('password.updatePassword') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('شماره موبایل') }}</label>

                            <div class="col-md-6">
                                <input id="mobile" type="mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $user->mobile ?? old('mobile') }}" required readonly autofocus>

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('رمز عبور جدید') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('تکرار رمز عبور جدید') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('تغییر رمز عبور') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
{{-- sweetalert --}}
<script src="{{asset('/storetemplate/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script>
  $(function () {

    $("#resendSMS").click(function(){
        event.preventDefault();
        $('.loader').show();
        $.ajax({
            type:'GET',
            url: '{{ route('password.resendSMS') }}',
            // data: {
              {{-- _token: '<?php echo csrf_token() ?>', --}}
              // id : data.id
            // },
            success:function(data){
                if(data.res == "error")
                {
                    title = "خطا  در اجرای عملیات" ;
                }
                else if(data.res == "success")
                {
                    title = "عملیات با موفقیت انجام شد.";
                }
                swal(title, data.message,data.res);
            },
            complete: function(){
                $('.loader').hide();
            }
        });
    });


  })//END
</script>

@endpush
