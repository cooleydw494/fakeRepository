<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class CommentsController extends Controller
{
    //
    public function store(Post $post)
    {
      //validate the comment form
      $this->validate(request(), ['body' => 'required|min:3']);
      //abstract the addComment method to the post for clarity
      $post->addComment(request('body'));

      //create and save the comment in the database from the CommentsController
      //Comment::create([
        //'body' => request('body'),
        //'post_id' => $post->id
      //]);
      return back();
    }
}
