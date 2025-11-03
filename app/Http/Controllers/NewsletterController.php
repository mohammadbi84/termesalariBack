<?php

namespace App\Http\Controllers;

use App\Newsletter;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Exports\NewsletterEmailExport;
use App\Exports\NewsletterMobileExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterMail;

class NewsletterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('index-newsletter')) {
            // $emails = User::select('email')
            //     ->where('email','<>','')
            //     ->where('isActive',1)
            //     ->where('role','user')
            //     ->where('send_newsletter',1)
            //     ->orderby('created_at');

            // $newsletters = Newsletter::select('email')
            //     ->where('email','<>','')
            //     ->orderby('created_at')
            //     ->union($emails)
            //     ->distinct()
            //     ->paginate(16);
            $email_newsletters = Newsletter::where('email','<>','')
                ->orderby('created_at')
                ->paginate(16, ['*'], 'email_newsletters');
            $mobile_newsletters = Newsletter::where('mobile','<>','')
                ->orderby('created_at')
                ->paginate(16, ['*'], 'mobile_newsletters');
            // dd($newsletters);
            return view('newsletter.index')
                ->with('email_newsletters',$email_newsletters)
                ->with('mobile_newsletters',$mobile_newsletters);
        }
        else
            return "<div style='color:red; text-align:center;direction:rtl;font-family:system-ui'>متاسفانه دسترسی به این صفحه برای شما وجود ندارد.</div>";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newsletter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $fieldName = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $count = Newsletter::where($fieldName,$request->email)
            ->count();
        if($fieldName == 'mobile' and (strlen($request->email) < 10 or is_numeric($request->email) == false))
        {
            $result["res"] = "error";
            $result["message"] = ".فرمت شماره موبایل یا آدرس ایمیل صحیح نمی باشد";
            return $result;
        }

        $flag = 1;
        if($count > 0)
            $flag = 0;

        if($flag == 1)
        {
            $newsletter = new Newsletter;
            $newsletter->$fieldName = $request->email;
            $newsletter->save();
            $result["res"] = "success";
            $result["message"] = "از حالا منتظر خبرهای جذاب ما باشید ";
        }
        elseif($flag == 0)
        {
            $result["res"] = "error";
            $result["message"] = " آدرس پست الکترونیک تکراری می باشد ";
        }
        
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function show(Newsletter $newsletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsletter $newsletter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newsletter $newsletter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        $result["res"] = "success";
        $result["message"] = "آیتم انتخابی با موفقیت حذف شد.";
        return $result;
    }

    public function exportEmails()
    {
        if (Gate::allows('export-newsletter')) {
            return Excel::download(new NewsletterEmailExport, 'newsletter_email.xlsx');
        }
        else
            return "<div style='color:red; text-align:center;direction:rtl;font-family:system-ui'>متاسفانه دسترسی به این صفحه برای شما وجود ندارد.</div>";
    }

    public function exportMobiles()
    {
        if (Gate::allows('export-newsletter')) {
            return Excel::download(new NewsletterMobileExport, 'newsletter_mobile.xlsx');
        }
        else
            return "<div style='color:red; text-align:center;direction:rtl;font-family:system-ui'>متاسفانه دسترسی به این صفحه برای شما وجود ندارد.</div>";
    }

    public function sendMail(Request $request)
    {
        $emails = Newsletter::where('active',1)
            ->pluck('email');
        $data['message'] = $request->compose;
        $data['subject'] = $request->subject;
        Mail::bcc($emails)
            ->send(new NewsletterMail($data));
        return redirect()->route('newsletter.create')
            ->with('success','ایمیل برای اعضای خبرنامه ارسال شد.');
    }
}
