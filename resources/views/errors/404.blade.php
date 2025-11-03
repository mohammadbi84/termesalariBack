<!DOCTYPE html>
<html lang="fa">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>404 Error</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Kanit:200" rel="stylesheet">

	<!-- Font Awesome Icon -->
  	<link href="{{asset('/hometemplate/lib/fontawesome-free-5.12.0/css/all.min.css')}}" rel="stylesheet">

  	<link rel="stylesheet" href="{{asset('/storetemplate/dist/fonts/font-face-FD-WOL.css')}}">

	<!-- Custom stlylesheet -->
  	<link rel="stylesheet" href="{{asset('/storetemplate/dist/css/ErrorPagesStyle.css')}}">

</head>

<body>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>404</h1>
			</div>
			<h2>متاسفم! صفحه مورد نظر یافت نشد.</h2>
			<p>ممکن است آدرس صفحه ای که به دنبال آن هستید تغییرکرده و یا به طور موقت در دسترس نباشد. 
				<br><br><a href="{{ route('homeStore.index') }}" class="pt-2">می تونید به صفحه اصلی فروشگاه  برگردید.</a></p>
			<div class="notfound-social">
				<a href="https://www.instagram.com/termehsalari/"><i class="fab fa-instagram"></i></a>
				<a href="https://telegram.me/termeh_salari"><i class="fab fa-telegram-plane"></i></a>
				<a href="#" title="09134577500"><i class="fab fa-whatsapp"></i></a>
				<a href="mailto:Info@TermehSalari.com"><i class="far fa-envelope"></i></a>
			</div>
		</div>
	</div>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
