@extends('store-layout')

@push('linkLast')
    
	<style type="text/css">

		.card-primary.card-outline {
		    border-top: 3px solid #18d26e !important;
		}

		.nav-side-menu li{
			padding: 10px 0 10px 0 ;
			transition: all 500ms;
			-webkit-transition: all 500ms;
			-moz-transition: all 500ms;

		}

		.nav-side-menu li:hover{
			padding-right: 15px;

		}

		.nav-side-menu li:hover i{
			color: #18d26e !important;
		}

		.nav-side-menu li a{
			color: gray !important;
		}

		.nav-side-menu li i{
			padding-left: 10px;
			/*font-size: 0.8rem;*/
			color: gray !important;
		}

        .ui-chat-container .btn_chat_lancher span.open_me {
          bottom: -11px !important;
        }


	</style>
@endpush

@stack('user-link')


@section("main-content")

<div class="row mt-4 mb-4">

    <aside class="col-md-3" >

    	<div class="card card-primary card-outline">
    		<div class="card-body box-profile">
                <div class="text-center">
                    <a href="#" data-toggle="modal" data-target="#profileImages"><img class="profile-user-img img-fluid img-circle" src="@if(isset(Auth::user()->image)) {{ asset('storetemplate/dist/img/' . Auth::user()->image) }} @else {{ asset('/storetemplate/dist/img/user.png') }} @endif " alt="User profile picture"></a>
                </div>
                <div class="modal fade row" id="profileImages" tabindex="-1" role="dialog" aria-labelledby="profileImagesLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered col-12" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="commentTextLabel">تغییر نمایه کاربری شما</h6>
                            </div>
                            <div class="modal-body row">
                                @for($i=1 ; $i<=6 ; $i++)
                                    <div class="col-4 mb-3">
                                        <a href="{{ route('user.changeImage',["avatar".$i.".png"]) }}" class=""><img class="profile-user-img img-fluid img-circle" src="{{ asset('/storetemplate/dist/img/avatar'.$i.'.png') }} " alt="User profile picture"></a>
                                    </div>
                                    
                                @endfor
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="profile-username text-center">@if (Auth::check()) {{Auth::user()->name}} {{Auth::user()->family}} @endif</h3>
                <p class="text-muted text-center">@if (Auth::check()) {{Auth::user()->mobile}} @endif</p>
            </div>
    	</div>

    	<div class="card">
    		<div class="card-body">
    			<nav class="nav-side-menu">
    				<ul class="sf-js-enabled sf-arrows" style="touch-action: pan-y;">
    					<li class="myOrders"><i class="fa  fa-shopping-cart"></i><a href="{{ route('user.myOrders') }}">سفارش های من</a></li>
                        <li class="myPayments"><i class="fa  fa-credit-card"></i><a href="{{ route('user.myPayments') }}">پرداخت های من</a></li>
    					<li><a href="{{ route('user.favorites') }}"><i class="fa fa-heart" ></i> علاقه مندی ها</a></li>
    					<li><a href="{{ route('user.comments') }}"><i class="fa fa-comments"></i> نظرات</a></li>
    					<li><a href="{{ route('user.recipients') }}"><i class="fa fa-map-signs"></i>گیرندگان</a></li>
    					<li><a href="{{ route('user.messages') }}"><i class="fa fa-envelope"></i> پیغام ها</a></li>
                        <li><a href="{{ route("user.profile") }}"><i class="fa fa-address-card"></i> پروفایل کاربری</a></li>
    					<li><i class="fa fa-key"></i><a href="{{ route('user.changePassword') }}">تغییر رمز عبور</a></li>
    					<li>
                            <a href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> خروج</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                            </form>
                        </li>
    				</ul>
    			</nav>

    		</div>
    	</div>


    </aside>

    <div class="col-md-9 card">
        @if(Auth::user()->email != "" and Auth::user()->email_verified_at == "")
            <div class="row">
                <div class="alert alert-warning alert-dismissible col-12">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h6><i class="icon fa fa-warning"></i> توجه!</h6>
                    <div style="font-size: .9rem;">
                     شما آدرس ایمیل خود را تایید نکرده‌اید. <br>
                    ایمیل حاوی لینک تأیید پست الکترونیک برای شما ارسال شده است. لطفاً ایمیل دریافتی را باز کرده و روی لینک مربوطه کلیک کنید.
                    <a id="verificationResend" href="{{ route('verification.resend') }}" class="btn btn-sm btn-flat btn-success mt-2"  style="text-decoration: none; color: white !important;">ارسال مجدد تاییدیه ایمیل</a>
                    </div>
                     
                </div>

            </div>
        @endif
        
        <div class="row card">
            <div class="col-12">
            	<div class="card-header"><div class="card-title"><span> @yield("card-title") </span></div></div>
            	<div class="card-body" id="page-content">
                	@yield("user-content") 
                </div>
            </div>
        </div>

    </div>


<!-- LOADING... -->
<div class="loader">
  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="24px" height="24px" viewBox="0 0 24 24" style="enable-background:new 0 0 50 50;" xml:space="preserve">
    <rect x="0" y="0" width="4" height="7" fill="#333">
      <animateTransform  attributeType="xml"
        attributeName="transform" type="scale"
        values="1,1; 1,3; 1,1"
        begin="0s" dur="0.6s" repeatCount="indefinite" />       
    </rect>

    <rect x="10" y="0" width="4" height="7" fill="#333">
      <animateTransform  attributeType="xml"
        attributeName="transform" type="scale"
        values="1,1; 1,3; 1,1"
        begin="0.2s" dur="0.6s" repeatCount="indefinite" />       
    </rect>
    <rect x="20" y="0" width="4" height="7" fill="#333">
      <animateTransform  attributeType="xml"
        attributeName="transform" type="scale"
        values="1,1; 1,3; 1,1"
        begin="0.4s" dur="0.6s" repeatCount="indefinite" />       
    </rect>
  </svg>
</div>


@endsection

@push('js')
    <script type="text/javascript">
        $(function () {
            $("#verificationResend").click(function(event){
                event.preventDefault();
                $.ajax({
                    type:'get',
                    url: "{{ route('verification.resend') }}",
                    data: {
                    },
                    success:function(data){
                        swal("عملیات با موفقیت انجام شد.", "مجدداً ایمیل حاوی لینک تأیید پست الکترونیک برای شما ارسال شد.لطفاً وارد صندوق پستی خود شوید.","success");
                    }
                });
            });
        })//End
    </script>


@endpush