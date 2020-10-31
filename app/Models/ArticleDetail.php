<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleDetail extends Model
{
    protected $table = "articlesdetail";

    protected $guarded = ['id'];

    protected $fillable = [
        'tag_id', 'article_id',
    ];

    // public function article()
    // {
    //     return $this->belongsTo('App\Models\Article');
    // }

    // public function user()
    // {
    //     return $this->belongsTo('App\Models\User');
    // }

    // public function tags()
    // {
    //     return $this->hasMany('App\Models\Tags');
    // }

    // public function tags()
    // {
    //     return $this->belongsToMany('App\Models\Tags', 'articlesdetail', 'articles_id', 'tag_id');
    // }
}
