<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('store');
        $this->authorizeResource(Message::class, 'message');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validated();
        // dd($request->all());
        $result["res"] = "success";
        $result["message"] = ".با تشکر از شما کاربر عزیز، پیام شما  ارسال شد ";
        $message = Message::create($request->all());
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        $message->isRead = 1;
        $message->save();
        // return true;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Message $message)
    {
        $message = Message::where('id',$request->id);

        if ($message->delete())
        {
            $result["res"] = "success";
            $result["message"] = "پیام انتخابی با موفقیت حذف شد.";
            return $result;
        }
    }

    public function delMessageGroup(Request $request)
    {
        $this->authorize('delMessageGroup', Message::class);
        $messages = Message::whereIn('id',$request->selectMessage);
        $messages->delete();
        return redirect()->route('userMessage.index')
            ->with('success', '::عملیات حذف با موفقیت انجام شد ::');
    }
}
