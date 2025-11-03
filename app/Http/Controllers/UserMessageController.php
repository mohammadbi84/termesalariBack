<?php

namespace App\Http\Controllers;

use App\UserMessage;
use App\Message;
use Illuminate\Http\Request;

class UserMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(UserMessage::class, 'userMessage');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $userMessages = UserMessage::withTrashed()
        //     ->where('parentID',0)
        //     ->orderby('created_at','desc')
        //     ->get();
        $userMessages = UserMessage::withTrashed()
            ->orderby('created_at','desc')
            ->get();
        // dd($userMessages);

        foreach ($userMessages as $key => $message) {
            if($message->parentID <> 0) {
                $userMessages[$key] = $message->parent()->withTrashed()->first();
                // dd($userMessages[$key]);
                if(($message != "") and $message->isRead == 0) {
                    $UM = $userMessages[$key];
                    // dd($UM);
                    $userMessages->map(function ($UM)
                    {
                        return $UM->isRead = 0;
                    });
                }
            }
        }

        $userMessages = $userMessages->unique('id');

        $messages = Message::orderby('created_at','desc')
            ->orderby('created_at','desc')
            ->get();

        return view('message.index')
            ->with('userMessages',$userMessages)
            ->with('messages',$messages);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserMessage  $userMessage
     * @return \Illuminate\Http\Response
     */
    public function show(UserMessage $userMessage)
    {
        // dd($userMessage);
        // $userMessage = UserMessage::withTrashed()
        //         ->where('id', $userMessage->id)
        //         ->firstOrFail();

        $messageDetails = UserMessage::withTrashed()
            ->where('parentID',$userMessage->id)
            ->orderby('created_at','asc')
            ->get();

        if(isset($userMessage) and $userMessage->isRead == 0)
        {
            $userMessage->isRead = 1;
            $userMessage->save();
        }
        return view('message.message-details')
            ->with('messageStart',$userMessage)
            ->with('messageDetails',$messageDetails);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserMessage  $userMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(UserMessage $userMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserMessage  $userMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserMessage $userMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserMessage  $userMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $userMessages = UserMessage::where('id',$request->id)
            ->orWhere('parentID',$request->id);

        if ($userMessages->forceDelete())
        {
            $result["res"] = "success";
            $result["message"] = "پیام انتخابی به همراه گفتگوهای مربوط به آن حذف شد.";
            return $result;
        }
    }

    public function delMessage(Request $request)
    {
        $this->authorize('delMessage', UserMessage::class);
        $userMessage = UserMessage::where('id',$request->id);

        if ($userMessage->forceDelete())
        {
            $result["res"] = "success";
            $result["message"] = "پیام انتخابی با موفقیت حذف شد.";
            return $result;
        }
    }

    public function delUserMessageGroup(Request $request)
    {
        $this->authorize('delUserMessageGroup', UserMessage::class);
        $userMessages = UserMessage::whereIn('id',$request->selectUserMessage)
            ->orWhereIn('parentID',$request->selectUserMessage);
        $userMessages->forceDelete();
        return redirect()->route('userMessage.index')
            ->with('success', '::عملیات حذف با موفقیت انجام شد ::');
    }




    
}   
