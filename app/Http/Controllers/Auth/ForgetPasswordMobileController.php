<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Trez\RayganSms\Facades\RayganSms;
use Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
// use App\Providers\RouteServiceProvider;


class ForgetPasswordMobileController extends Controller
{
   public function sendVerifyCode(Request $request)
   {
        $mobile = $request->email;
        $user = User::where('mobile',$mobile)
            ->first();
        if (isset($user)) {
            $active_code = mt_rand(100000, 999999);
            // dd($mobile);
            RayganSms::sendMessage($mobile, "کد تائیدیه موبایل جهت تغییر رمز عبور در فروشگاه ترمه سالاری: " . $active_code);
            $user->mobile_forget_password_code = $active_code;
            $user->save();
            // dd($user);
            session()->put('verifyMobile', $user->mobile);
            // dd(session()->all());
            return view('auth.passwords.verifyMobile');
        }
        else
            return redirect('/password/reset')
                ->withErrors(["email"=>"کاربری با این شماره موبایل یافت نشد."])
                ->withInput();
   }

   public function resendSMS(Request $request)
   {
       if(session()->has('verifyMobile'))
        {
            $user = User::where('mobile',session()->get('verifyMobile'))
                ->first();
            $active_code = mt_rand(100000, 999999);
            // dd($user['mobile']);
            RayganSms::sendMessage($user->mobile, "به فروشگاه ترمه سالاری خوش آمدید.کد تایید:" . $active_code);
            $user->mobile_forget_password_code = $active_code;
            $user->save();
            // session()->put('verifyMobile',$user);
            $result["res"] = "success";
            $result["message"] = "کد تائیدیه مجددا به شماره موبایل شما ( ".$user->mobile." ) ارسال شد.در صورت نیاز به ویرایش شماره موبایل، به مرحله قبل بازگردید.";
        }
        else
        {
            $result["res"] = "error";
            $result["message"] = "انجام عملیات با خطا روبرو شد .";
        }
        return $result;
   }

   public function verify(Request $request)
   {
        // dd($request->all());
        $verify_code = $request->verify_code;
        $user = User::where('mobile',session()->get('verifyMobile'))
                ->first();
        if($user->mobile_forget_password_code == $verify_code)
        {
            // Auth::login($user, true);
            // return redirect()->route('homeStore.index');
            return redirect()->signedRoute('password.resetPassword', ['mobile' => $user->mobile]);
            // URL::signedRoute('password.resetPassword', ['mobile' => $user->mobile]);
            // http://termehsalari.com/password/resetPassword?mobile=09131568758&signature=c4e640fadcc1c9eb394baf61a72c69b2b0cf7179a1a2ba5d7b7740388b22f590
            // return URL::temporarySignedRoute(
            //     'unsubscribe', now()->addMinutes(30), ['user' => 1]
            // );
        }
        else
        {
            return redirect()->route('register.backToReciveVerifyCode')->withInput($request->all())->with('danger','::خطا: کد فعالسازی نادرست می باشد.::');
        }
   }

   public function resetPassword(Request $request)
   {
        if (! $request->hasValidSignature()) {
            abort('آدرس نا معتبر است.');
        }else{
            $user = User::where('mobile',$request->mobile)
            ->first();
            // dd($user);
            return view('auth.passwords.resetPasswordViaMobile')
            ->with('user',$user);
        }
        
   }

   public function updatePassword(Request $request)
   {
       // dd(session()->all());
       $rules = [
           'mobile' => 'required',
           'password' => 'required|string|min:8|confirmed',
           'password_confirmation' => 'required|string|min:8' ,
        ];
        $request->validate($rules);
        $user = User::where('mobile',session()->get('verifyMobile'))
            ->first();
        $user->password = Hash::make($request->password);
        $user->save();
        Auth::login($user, true);
        return redirect()->route('homeStore.index');
   }

}//END
