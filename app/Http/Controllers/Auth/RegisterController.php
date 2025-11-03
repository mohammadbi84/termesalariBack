<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Trez\RayganSms\Facades\RayganSms;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest', 'verifiedMobileNumber'])->except('registerSendSMS');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $user = session()->get('authenticationUser');
        $data['mobile'] = $user['mobile'];
        $data['password'] = $user['password'];
        $data['password_confirmation'] = $user['password'];

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'family' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'numeric', 'unique:users'],
            'email' => ['bail','nullable', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'conditions' => ['required'],
        ]); 
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = session()->get('authenticationUser');
        $data['mobile'] = $user['mobile'];
        $data['password'] = $user['password'];
        $data['password_confirmation'] = $user['password'];
        return User::create([
            'name' => $data['name'],
            'family' => $data['family'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    
    //---------------------------------------------------------------------
    public function registerStepOne()
    {
        return view('auth.register-step-one');
    }

    public function registerSendSMS(Request $request)
    {
        // session()->flush();
        $rules = [
           'mobile' => 'required|numeric|unique:users',
           'password' => 'required|string|min:8|confirmed',
           'password_confirmation' => 'required|string|min:8' ,
        ];
        $request->validate($rules);
        //$active_code = '111111';
        $active_code = mt_rand(100000, 999999);
        //$active_code = RayganSms::sendAuthCode($request->mobile, "به فروشگاه ترمه سالاری خوش آمدید./nکد تایید:".mt_rand(100000, 999999), false);
        RayganSms::sendMessage($request->mobile, "به فروشگاه ترمه سالاری خوش آمدید.کد تایید:" . $active_code);
        $user = $request->all();
        $user['active_code'] = $active_code;
        // dd($user);
        session()->put('authenticationUser', $user);
        // dd(session()->all());
        return view('auth.verify-phone-number');
    }

    public function registerResendSMS()
    {
        if(session()->has('authenticationUser'))
        {
            $user = session()->get('authenticationUser');
            $active_code = mt_rand(100000, 999999);
            // dd($user['mobile']);
            RayganSms::sendMessage($user['mobile'], "به فروشگاه ترمه سالاری خوش آمدید.کد تایید:" . $active_code);
            $user['active_code'] = $active_code;
            session()->put('authenticationUser',$user);
            $result["res"] = "success";
            $result["message"] = "کد فعالسازی مجددا به شماره موبایل شما ( ".$user['mobile']." ) ارسال شد.در صورت نیاز به ویرایش شماره موبایل، به مرحله قبل بازگردید.";
        }
        else
        {
            $result["res"] = "error";
            $result["message"] = "انجام عملیات با خطا روبرو شد .";
        }
        return $result;
    }

    public function checkVerifyCode(Request $request)
    {
        // dd(session()->all());
        $verify_code = $request->active_code;
        $user = session()->get('authenticationUser');
        if($user['active_code'] == $verify_code)
        {
            return redirect()->route('register');
        }
        else
        {
            return redirect()->route('register.backToCheckVerifyCode')->withInput($request->all())->with('danger','::خطا: کد فعالسازی نادرست می باشد.::');
            // return redirect()->back()->with('error','خطا');
        }
    }

}//End
