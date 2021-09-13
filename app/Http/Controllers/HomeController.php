<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::with('user')->get();
        $user_image = Auth::user()->image;
        return view('home',compact('posts','user_image'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function userList()
    {
        $users = User::all();
        return view('dashboard.userList',compact('users'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return back()->with('message','User has deleted successfully!');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        $userPosts = Post::where('user_id',$id)->get();
        return view('dashboard.show_user',compact('user','userPosts'));
    }


}
