<?php

namespace App\Http\Controllers;
use Auth;
use App\Comment;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Comment::class, 'comment');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();
        return view('comment.index')
            ->with('comments',$comments);
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
       $result = [];
        if (Auth::check())
        {
            $userID = Auth::id();
            $class="App\\".$request->model;
            $product = $class::find($request->product);
            $comment = new Comment;
            $comment->text = $request->text;
            $comment->user_id = $userID;
            $product->comments()->save($comment);

            $result["res"] = "success";
            $result["message"] = "باتشکر از شما کاربر عزیز، نظرات شما ثبت  و بعد از  تایید در وب سایت نمایش داده خواهد شد  .";
            }

        else{   //Auth
            $result["res"] = "error";
            $result["message"] = "لطفا برای ثبت نظرات خود  ابتدا با نام کاربری وارد سایت شوید.";

        }
        if ($request->ajax()) {
            return $result;
        }else{
            return redirect()->back()->with('success', 'نظر شما با موفقیت ثبت شد و پس از تایید نمایش داده خواهد شد.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }

    public function showProductComments(string $model, int $id)
    {
        $this->authorize('showProductComments', Comment::class);
        $class = "App\\".$model;
        $product = $class::find($id);
        $comments = Comment::where("commentable_type",$class)
            ->where("commentable_id",$id)
            ->get();
        return view('comment.productComments')
            ->with('comments',$comments)
            ->with('product',$product);

    }

    public function changeStatus(int $comment)
    {
        // dd($comment);
        $this->authorize('changeStatus', Comment::class);
        $comment = Comment::find($comment);
        // dd($comment);
        if($comment->status == "0"){
            $comment->status = "1";
        }
        else if($comment->status == "1"){
            $comment->status = "0";
        }
        $comment->save();

        $result["res"] = "success";
        $result["message"] = "مورد انتخابی تغییر وضعیت یافت.";
        return $result;
    }

    public function chnageStatusGroup(Request $request)
    {
        $this->authorize('chnageStatusGroup', Comment::class);
        $result = [];
        if(isset($request->items)){
            foreach($request->items as $id){
                $comment = Comment::find($id);
                if($comment->status == 0)
                    $comment->status = 1;
                else if ($comment->status == 1)
                    $comment->status = 0;
                $comment->save();
            }
            $result["res"] = "success";
            $result["message"] = "موارد انتخابی با موفقیت تغییر وضعیت یافت .";
        }
        else
        {
            $result["res"] = "error";
            $result["message"] = "لطفا ابتداسطرهای مورد نظر را انتخاب کنید.";
        }
        return $result;
    }
}//End
