<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Carbon\Carbon;

class PostsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
      //$posts = Post::latest()->get();
      //alernatively could be
      //$posts = Post::orderBy('created_at', 'desc')->get();


      $posts = Post::latest()
          ->filter(request()->only(['month', 'year']))
          ->get();

      return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
      return view('posts.show', compact('post'));
    }

    public function create()
    {
      return view('posts.create');
    }

    public function store()
    {
      //validate the request
      $this->validate(request(), [
        'title' => 'required|max:20',
        'body' => 'required' //name of input and pipe separated list of
      ]);                    //validations (look up options in doc.)
      // //create a new post using the request
      // $post = new Post;
      // $post->title = request('title');
      // $post->body = request('body');
      // //save it to the database
      // $post->save();

      // //alternative to creating a new post using request and saving it
      // Post::create([
      //   'title' => request('title'),
      //   'body' => request('body')
      // ]);

      //alernative alternative
      //Post::create([
        //'title' => request('title'),
        //'body' => request('body'),    //create and save
        //'user_id' => auth()->user()->id
      //]);

      //alternative alternative alternative
      auth()->user()->publish(
        new Post(request(['title', 'body']))
      );

      //redirect somewhere in the application (home page)
      return redirect('/');
    }
}
