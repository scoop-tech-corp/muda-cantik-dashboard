<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = "articles";

    protected $guarded = ['id'];

    protected $fillable = [
        'title', 'slug', 'body', 'gallery_id', 'user_id',
        'category_id', 'created_by',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function commentsarticle()
    {
        return $this->hasMany('App\Models\CommentArticle');
    }

    public function gallery()
    {
        return $this->belongsTo('App\Models\Gallery');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Categories');
    }

    public function articlesdetail()
    {
        return $this->hasMany('App\Models\ArticleDetail')
            ->join('tags', 'tags.id', '=', 'articlesdetail.tag_id');
    }
}
