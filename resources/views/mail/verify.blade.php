<!DOCTYPE html>
<html>
<head>

</head>
<body class="container" style="direction: rtl;font-family: system-ui">
	<table align="center" cellspacing="0" width="95%" border="0" style="direction: rtl;font-family: system-ui ; text-align: right;">
		<tr>
			<td colspan="3">
				<h1 style="text-align: center;" ><img style="border-left: 3px solid #18d26e;padding-left: 10px;vertical-align: middle;" src="{{ asset('/hometemplate/img/logo.png') }}">
					<span style="padding-right: 20px">فروشگاه ترمه سالاری </span>
				</h1>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="font-size: 122%;text-align: center;">
				نمایشگاهی بزرگ و جذاب از ترمه های نفیس یزد
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<p><span style="font-weight: 500;"> {{ $data['name'] }} {{ $data['family'] }}</span> عزیز</p>
			</td>
		</tr>
		<tr>
			<td colspan="3"><p>باسلام</p></td>
		</tr>
		<tr>
			<td colspan="3"><p>ورود شما را به خانواده ی بزرگ مشتریان ترمه سالاری گرامی می داریم.</p></td>
		</tr>
		<tr>
			<td colspan="3"><p>اطلاعات حساب کاربری شما به صورت زیر می باشد :</p></td>
		</tr>
		<tr style="background-color: lightgreen;">
			<td colspan="3">
				<p><b>نام کاربری (شماره موبایل )  : </b><span>{{ $data['mobile'] }}</span></p>
			</td>
		</tr>
		<tr style="background-color: lightgreen;">
			<td colspan="3">
				<p><b>آدرس  ورود به فروشگاه : </b><span class="en">http://TermehSalari.com/shop</span></p>
			</td>
		</tr>
		<tr>
			<td colspan="3"><p>در صورت داشتن هر گونه سوال و یا راهنمایی، می توانید با ما در ارتباط باشید.</p></td>
		</tr>
		<tr style="direction: ltr; height: 30px;text-align: left;">
			<td>
				<img src="{{ asset('storetemplate/dist/img/phone.png') }}" style="vertical-align: middle;">
				<span> 035 3622 38 80</span>
			</td>
			<td>
				<img src="{{ asset('storetemplate/dist/img/instagram.png') }}" style="vertical-align: middle;">
				<span> https://www.instagram.com/termehsalari</span>
			</td>
			<td>
				<img src="{{ asset('storetemplate/dist/img/telegram.png') }}" style="vertical-align: middle;">
				<span> https://telegram.me/termeh_salari</span>
			</td>
		</tr>
		<tr style="direction: ltr; height: 30px;text-align: left;">
			<td></td>
			<td>
				<img src="{{ asset('storetemplate/dist/img/whatsApp.png') }}" style="vertical-align: middle;">
				<span> 0913 457 7500</span>
			</td>
			<td>
				<img src="{{ asset('storetemplate/dist/img/mail.png') }}" style="vertical-align: middle;">
				<span> Info@TermehSalari.com</span>
			</td>
		</tr>
	</table>
	
	
</body>
</html>