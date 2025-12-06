<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('email/resend', 'UserController@resendVerifyEmail')->name('verification.resend');

Route::resource('slideshow','SlideshowController');
route::post('/slideshow/changeVisibility','SlideshowController@changeVisibility')->name('slideshow.changeVisibility');
route::post('/slideshow/changeVisibilityGroup','SlideshowController@changeVisibilityGroup')->name('slideshow.changeVisibilityGroup');

Route::get('/register/step-one','Auth\RegisterController@registerStepOne')->name('register.stepOne');

Route::post('/register/sendSMS','Auth\RegisterController@registerSendSMS')->name('register.sendSMS');
Route::get('/register/resendSMS','Auth\RegisterController@registerResendSMS')->name('register.resendSMS');
Route::post('/register/checkVerifyCode','Auth\RegisterController@checkVerifyCode')->name('register.checkVerifyCode');

Route::get('/register/checkVerifyCode',function(){
	return view('auth.verify-phone-number');
})->name('register.backToCheckVerifyCode');

Route::post('/password/forget','Auth\ForgetPasswordMobileController@sendVerifyCode')->name('forgetPasswordMobile.sendVerifyCode');
Route::post('/password/verify','Auth\ForgetPasswordMobileController@verify')->name('forgetPasswordMobile.verify');
Route::get('/password/resendSMS','Auth\ForgetPasswordMobileController@resendSMS')->name('password.resendSMS');
Route::get('/password/reciveVerifyCode',function(){
	return view('auth.passwords.verifyMobile');
})->name('register.backToReciveVerifyCode');
Route::get('/password/resetPassword','Auth\ForgetPasswordMobileController@resetPassword')->name('password.resetPassword')->middleware('signed');
Route::post('/password/updatePassword','Auth\ForgetPasswordMobileController@updatePassword')->name('password.updatePassword');


Route::get('/store','HomestoreController@index')->name('homeStore.index');
Route::get('/store3','HomestoreController@index3')->name('etc.storeIndex');

Route::post('/shop/filter/', 'homestoreController@filter')->name('homestore.filter');
Route::get('/shop/privacy-and-policy',function(){
	return view('privacy-policy');
})->name('privacy-policy');
Route::get('/shop/terms',function(){
	return view('terms');
})->name('terms');


Route::Post("/home/sendMessage","MessageController@store")->name("message.store");

Route::get('/api/tags','TagController@selectTag')->name('api.tags');

Route::resource('tag','TagController');


Route::resource('tablecloth','TableclothController');
route::post('/tablecloth/changeVisibility','TableclothController@changeVisibility')->name('tablecloth.changeVisibility');
route::post('/tablecloth/changeVisibilityGroup','TableclothController@changeVisibilityGroup')->name('tablecloth.changeVisibilityGroup');
Route::get('/store/tablecloths/','TableclothController@storeIndex')->name('tablecloth.storeIndex');
Route::get('/store/tablecloths/filter', 'TableclothController@storeFilter')->name('tablecloth.storeFilter');

Route::get('/tablecloth/duplicate/{tablecloth}','TableclothController@duplicate')->name('tablecloth.duplicate');


Route::resource('comment','CommentController');
// Route::post('/comment/store/', 'CommentController@store')->name('comment.store');
Route::get('/comment/product/{model}/{product}', 'CommentController@showProductComments')->name('comment.product');
Route::get('/comment/changeStatus/{comment}','CommentController@changeStatus')->name('comment.changeStatuse');
route::POST('/comment/chnageStatusGroup/','CommentController@chnageStatusGroup')->name('comment.chnageStatusGroup');

Route::resource('newsletter','NewsletterController');
Route::get('/export/newsletter/emails','NewsletterController@exportEmails')->name('newsletter.emails.export');
Route::get('/export/newsletter/mobiles','NewsletterController@exportMobiles')->name('newsletter.mobiles.export');
Route::post('/sendMail/newsletter/','NewsletterController@sendMail')->name('newsletter.sendMail');

Route::get('/cart/add/{product}/{controller}/{quantity?}', 'CartController@add')->name('cart.add');
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart/change/', 'CartController@change')->name('cart.change');
// Route::delete('/cart/{product}', 'CartController@destroy')->name('cart.destroy');
Route::POST('/cart/deleteItem','CartController@cartDeleteItem')->name('cart.deleteItem');
Route::get('/cart/cartlevel2', 'CartController@cartlevel2')->name('cart.cartlevel2');
Route::Post('/cart/cartfinal', 'CartController@cartfinal')->name('cart.cartfinal');
Route::get('/cart/payment', 'CartController@payment')->name('cart.payment');
Route::get('/cart/factor/{order}','CartController@factor')->name('cart.factor');
Route::Post('/cart/storeDiscountCard', 'CartController@storeDiscountCard')->name('cart.storeDiscountCard');

// Route::resource('cardPayment','CardPaymentController');

// Route::resource('internetPayment','InternetPaymentController');


// Route::get('/pay/error',function(){
// 	// dd('123');
// 	return view('payment.payment-error')
//         ->with('error','پرداخت نا موفق');
// });

Route::resource('recipient','RecipientController');
Route::post('/recipient/selectSubcity','RecipientController@selectSubcity')->name('recipient.selectSubcity');

Route::get('/grade/store', 'GradeController@store')->name('grade.store');

Route::resource('favorite','FavoriteController');

Route::delete('/image/delete','ImageController@delOneImage')->name('image.delOneImage');
Route::post('/image/ordering','ImageController@ordering')->name('image.ordering');

Route::resource('message','MessageController');
Route::post('/message/delMessageGroup', 'MessageController@delMessageGroup')->name('message.delMessageGroup');
// Route::post('/message/showMessage','MessageController@showMessage')->name('');

Route::resource('userMessage','UserMessageController');
Route::post('/userMessage/delUserMessageGroup', 'UserMessageController@delUserMessageGroup')->name('userMessage.delUserMessageGroup');
Route::post('/userMessage/detail/delMessage', 'UserMessageController@delMessage')->name('userMessage.delMessage');

Route::resource('order','OrderController');
Route::POST('/order/setStatus','OrderController@setStatus')->name('order.setStatus');
// Route::POST('/order/confirm','OrderController@confirmOrder')->name('order.confirm');
// Route::POST('/order/reject','OrderController@rejectOrder')->name('order.reject');
Route::POST('/order/changeStatusGroup','OrderController@changeStatusGroup')->name('order.changeStatusGroup');
Route::post('/order/getPostInfo','OrderController@getPostInfo')->name('order.getPostInfo');
Route::POST('/order/savePostInfo','OrderController@savePostInfo')->name('order.savePostInfo');
Route::get('/order/printAddresses/{items?}','OrderController@printAddresses')->name('order.printAddresses');
Route::get('/order/printAddress/{id?}','OrderController@printAddress')->name('order.printAddress');
Route::get('/orders/unsuccess/','OrderController@unsuccessOrders')->name('order.unsuccess.index');

Route::get('/user/profile/', 'UserController@profile')->name('user.profile');
Route::get('/user/my-orders/', 'UserController@myOrders')->name('user.myOrders');
Route::get('/user/my-order/{id}', 'UserController@myOrder')->name('user.myOrder');
Route::get('/user/my-payments/', 'UserController@myPayments')->name('user.myPayments');
Route::get('/user/change-password/', 'UserController@changePassword')->name('user.changePassword');
Route::get('/user/favorites/', 'UserController@favorites')->name('user.favorites');
Route::get('/user/remove-favorite/', 'FavoriteController@removeFavorite')->name('user.removeFavorite');
Route::get('/user/add-favorite/', 'FavoriteController@addFavorite')->name('user.addFavorite');
Route::post('/user/update-myPassword/', 'UserController@updatePassword')->name('user.updatePassword');
Route::get('/user/comments/', 'UserController@comments')->name('user.comments');
Route::get('/user/comments/deleteComment', 'UserController@deleteComment')->name('user.deleteComment');
Route::get('/user/comments/deleteComments', 'UserController@deleteComments')->name('user.deleteComments');
Route::get('user/recipients/', 'UserController@recipients')->name('user.recipients');
Route::get('/user/messages/', 'UserController@messages')->name('user.messages');
Route::post('/user/messages/store', 'UserController@messageStore')->name('user.messageStore');
Route::get('/user/message/detail/{id}', 'UserController@messageDetail')->name('user.messageDetail');
Route::post('/user/message/detail/read', 'UserController@messageRead')->name('user.messageRead');
Route::post('/user/message/detail/saveAnswer/{messageStart}', 'UserController@saveAnswer')->name('user.saveAnswer');
Route::post('/user/message/detail/delConversation', 'UserController@delConversation')->name('user.delConversation');
Route::post('/user/message/detail/delMessage', 'UserController@delMessage')->name('user.delMessage');
// Route::post('/user/message/detail/delMessage', 'UserController@delMessage')->name('user.delMessage');
Route::get('/user/profile/changeImage/{image}', 'UserController@changeImage')->name('user.changeImage');
Route::resource('user', 'UserController');
Route::get('/user/changeStatus/{user}', 'UserController@changeStatus')->name('user.changeStatus');
Route::post('/user/changeStatusGroup/','UserController@changeStatusGroup')->name('user.changeStatusGroup');
Route::put('/user/saveChange/{user}','UserController@saveChange')->name('user.saveChange');
Route::get('/admin/profile/','UserController@adminProfile')->name('user.adminProfile');
Route::put('/admin/profile/update/{user}','UserController@adminProfileStore')->name('user.adminProfileStore');
Route::get('/user/profile/adminChangeImage/{image}', 'UserController@adminChangeImage')->name('user.adminChangeImage');
Route::get('/user/admin/change-password/', 'UserController@adminChangePassword')->name('user.adminChangePassword');
Route::get('/admin/dashboard','UserController@dashboard')->name('dashboard');
Route::get('/export/user/','UserController@export')->name('user.export');


// Route::get('/sendTestMail', function(){
// 	$data = [
// 		'title' => 'Test Email',
// 		'name' => 'ali',
// 		'family' => 'alian',
// 		'mobile' => '09131568758',
// 		'body' => 'Test sending email by laravel'
// 	];
// 	Illuminate\Support\Facades\Mail::to('lms_fezeledu@yahoo.com')
// 		->send(new App\Mail\VerifyEmail($data));

// 	echo "Main has been sent";
// });

Auth::routes(['verify' => true]);

// Route::get('/verifyEmail',function(){
// 	return view('mail.verify');
// });

Route::resource('shoe','ShoeController');

Route::resource('category','CategoryController');
Route::post('/category/changeActive','CategoryController@changeActive')->name('category.changeActive');

Route::resource('color','ColorController');

Route::resource('design','DesignController');
Route::get('/api/showColors', 'ColorController@showColors')->name('api.showColors');
Route::post('/design/changeActive','DesignController@changeActive')->name('design.changeActive');
Route::get('/design/listOfColors/{design}','DesignController@listOfColors')->name('design.listOfColors');
Route::post('/design/designColor/changeActive','DesignController@designColor_changeActive')->name('design.designColor_changeActive');
Route::post('/design/designColor/delete','DesignController@designColor_delete')->name('design.designColor_delete');
Route::post('/design/designColor/store','DesignController@designColor_store')->name('design.designColor_store');

Route::resource('discountCard','DiscountCardController');
Route::post('/discountCard/deleteGroup', 'DiscountCardController@deleteGroup')->name('discountCard.deleteGroup');
Route::post('/discountCard/changeIsGifted', 'DiscountCardController@changeIsGifted')->name('discountCard.changeIsGifted');
Route::post('/discountCard/changeIsGiftedGroup', 'DiscountCardController@changeIsGiftedGroup')->name('discountCard.changeIsGiftedGroup');



// Route::get('/factorEmail',function(){
// 	$order = App\Order::orderby('created_at','desc')
// 		->first();
// 	// Illuminate\Support\Facades\Mail::to(Auth::user()->email)
// 	// 	->send(new App\Mail\FactorMail($order));

// 	return view('mail.factor')->with('order',$order);
// });

Route::get('/compare/add', 'CompareController@add')->name('compare.add');
Route::get('/compare/remove', 'CompareController@remove')->name('compare.remove');
Route::get('/compare', 'CompareController@index')->name('compare.index');

Route::resource('bedcover','BedcoverController');
route::post('/bedcover/changeVisibility','BedcoverController@changeVisibility')->name('bedcover.changeVisibility');
route::post('/bedcover/changeVisibilityGroup','BedcoverController@changeVisibilityGroup')->name('bedcover.changeVisibilityGroup');
Route::get('/bedcover/duplicate/{bedcover}','BedcoverController@duplicate')->name('bedcover.duplicate');
Route::get('/store/bedcovers/','BedcoverController@storeIndex')->name('bedcover.storeIndex');
Route::get('/store/bedcovers/filter', 'BedcoverController@storeFilter')->name('bedcover.storeFilter');


Route::resource('prayermat','PrayermatController');
route::post('/prayermat/changeVisibility','PrayermatController@changeVisibility')->name('prayermat.changeVisibility');
route::post('/prayermat/changeVisibilityGroup','PrayermatController@changeVisibilityGroup')->name('prayermat.changeVisibilityGroup');
Route::get('/prayermat/duplicate/{prayermat}','PrayermatController@duplicate')->name('prayermat.duplicate');
Route::get('/store/prayermats/','PrayermatController@storeIndex')->name('prayermat.storeIndex');
Route::get('/store/prayermats/filter', 'PrayermatController@storeFilter')->name('prayermat.storeFilter');


Route::resource('pillow','PillowController');
route::post('/pillow/changeVisibility','PillowController@changeVisibility')->name('pillow.changeVisibility');
route::post('/pillow/changeVisibilityGroup','PillowController@changeVisibilityGroup')->name('pillow.changeVisibilityGroup');
Route::get('/pillow/duplicate/{pillow}','PillowController@duplicate')->name('pillow.duplicate');
Route::get('/store/pillows/','PillowController@storeIndex')->name('pillow.storeIndex');
Route::get('/store/pillows/filter', 'PillowController@storeFilter')->name('pillow.storeFilter');


Route::resource('fabric','FabricController');
route::post('/fabric/changeVisibility','FabricController@changeVisibility')->name('fabric.changeVisibility');
route::post('/fabric/changeVisibilityGroup','FabricController@changeVisibilityGroup')->name('fabric.changeVisibilityGroup');
Route::get('/fabric/duplicate/{fabric}','FabricController@duplicate')->name('fabric.duplicate');
Route::get('/store/fabrics/','FabricController@storeIndex')->name('fabric.storeIndex');
Route::get('/store/fabrics/filter', 'FabricController@storeFilter')->name('fabric.storeFilter');

// Route::get('/payment/callback',function(){
// 	dd("ddddd");
// });

Route::post('/payment/callback','PaymentController@verifyPayment')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/payment/callback','PaymentController@verifyPayment')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);


Route::resource('payment','PaymentController');


Route::resource('etc','EtcController');




//Route::post('/payment/verify','PaymentController@verify')->name('payment.verify');
//Route::get('/payment/verify','PaymentController@verify')->name('payment.verify');
