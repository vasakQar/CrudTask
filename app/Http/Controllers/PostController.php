<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use voku\helper\ASCII;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //validate
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'body'  => 'required',
        ]);

        if ($request->image){
            $destination_path = 'public/images';
            $image = $request['image'];
            $image_name = time().'.'.$image->getClientOriginalName();
            $path = $request->image->storeAs($destination_path,$image_name);
            $image->move($destination_path, $image_name);
            $request->image = $image_name;
        }

        Post::create([
            'title'    => $request->title,
            'body'     => $request->body,
            'image'    => $request->image,
            'user_id'  => Auth::id(),
        ]);
        return back()->with('message', 'Post has been added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Post $post)
    {
        return view('dashboard.edit',compact('post'));
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Post $post)
    {
        //validate
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'body'  => 'required',
        ]);

        if ($request->image){
            $destination_path = 'public/images';
            $image = $request['image'];
            $image_name = time().'.'.$image->getClientOriginalName();
            $path = $request->image->storeAs($destination_path,$image_name);
            $image->move($destination_path, $image_name);
            $request->image = $image_name;
        }

        if (is_file(storage_path('app/public/images/'.$image->getClientOriginalName())) && is_file('public/images/'.$post->image)){
            Storage::delete('/public/images/'.$post->image);
            unlink('public/images/'.$post->image);
        }

        $post = Post::findOrFail($post->id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->image = $request->image;
        $save = $post->save();

        if ($save){
            return redirect()->route('home')->with('message', 'Post has been updated successfully!');
        }else{
            return redirect()->route('home')->with('message','Something went wrong, failed to register');
        }
    }

    /**
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post)
    {
        if (is_file(storage_path('app/public/images/'.$post->image)) && is_file('public/images/'.$post->image)){
            Storage::delete('/public/images/'.$post->image);
            unlink('public/images/'.$post->image);
        }
        $post->delete();
        return redirect()->route('home')->with('message', 'Post has been deleted successfully!');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showPost($id)
    {
        $post = Post::findOrFail($id);
        return view('dashboard.show_post',compact('post'));
    }
}
