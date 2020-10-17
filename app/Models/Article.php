<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title', 'slug', 'body',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function commentsarticle()
    {
        return $this->hasMany('App\Models\CommentArticle');
    }

    public function tags()
    {
        return $this->hasMany('App\Models\Tags');
    }
}
