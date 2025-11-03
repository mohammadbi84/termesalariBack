<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Tablecloth;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }

    public function selectTag(Request $request)
    {
        // if (Gate::allows('selectTag')) {
            $q = $request->q;
            $res = [
                'results' => []
            ];

            if(empty($q)){
                return $res;
            }

            $tags = \App\Tag::where('name', 'like', $q . '%')->get();

            if($tags->isEmpty()){
                array_push($res['results'], ['id' => $q, 'text' => $q]);
                
                return $res;
            } 
            



            $searchResult = $tags->search( function($item, $key) use ($q) {
                return $item->name === $q;
            });

            if($searchResult === false)
                array_push($res['results'], ["id" => $q, "text" => $q]);
            

            foreach ($tags as $tag) {
                array_push($res['results'], ["id" => $tag->id, "text" => $tag->name]);
            }
            return $res;
        // } 
    }

}
