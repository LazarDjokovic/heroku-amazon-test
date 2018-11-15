<?php

namespace App\Http\Controllers;

use App\Model\Post;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;

use Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Post::all();
        return view('posts',$posts);
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
        
        $file=$request->file('image');
        if($file){
            $destinationPath = public_path(). '/images/articles';
            $filename = time().$file->getClientOriginalName();


            $s3 = \Storage::disk('s3');
            $filePath = '/images/' . $filename;
            $s3->put($filePath, file_get_contents($file), 'public');
            $fileUrl=\Storage::cloud()->url($filename);


            //$file->move($destinationPath, $filename);


            //dd($filename);

            Post::insert([
                'first_name'=>$request->firstName,
                'last_name'=>$request->lastName,
                'image'=>$fileUrl,
                'created_at'=>Carbon\Carbon::now(),
                'updated_at'=>Carbon\Carbon::now()
            ]);

            return redirect('/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
