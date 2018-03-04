<?php

namespace App;

use Carbon\Carbon;

class Post extends Model
{
    //protected $fillable = ['title', 'body'];
    public function comments()
    {
      return $this->hasMany(Comment::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function addComment($body)
    {
      //use the relationship that already exists from the comments function
      $this->comments()->create(compact('body'));

      //manually specify the post id
      // Comment::create([
      //   'body' => $body,
      //   'post_id' => $this->id
      // ]);
    }

    public function scopeFilter($query, $filters)
    {
      if (isset($filters['month']))
      {
        $query->whereMonth('created_at',Carbon::parse($filters['month'])->month);
      }

      if (isset($filters['year']))
      {
        $query->whereYear('created_at', $filters['year']);
      }
    }

    public static function archives()
    {
      return static::selectRaw('year(created_at) as year, monthname(created_at) as month, count(*) as published')
          ->groupBy('year', 'month')
          ->orderByRaw('year DESC, month ASC')
          ->get()
          ->toArray();
    }
}
