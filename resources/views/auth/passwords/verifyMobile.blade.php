@extends('auth.layout')

@section('title', 'تایید شماره موبایل')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-4">
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
                    <form method="POST" action="{{ route('forgetPasswordMobile.verify') }}">
                        @csrf
                        <div class="input-group mb-4">
                            <input name="verify_code" id="verify_code" type="text" maxlength="11" class="form-control @error('verify_code') is-invalid @enderror" placeholder="کد تائید " value="{{ old('verify_code') }}"  >

                            @error('verify_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mt-2">
                           <input type="submit" class="btn btn-danger btn-flat btn-sm" value="ثبت کد تایید" id="verify">   
                            <a href="#" class="btn btn-success btn-flat btn-sm" id="resendSMS" >ارسال مجدد کد </a>   
                            <a href="{{ route('password.request') }}" class="btn btn-secondary btn-flat btn-sm" >بازگشت و ویرایش</a> 
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
