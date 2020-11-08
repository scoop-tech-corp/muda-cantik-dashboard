<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentArticle extends Model
{
    use SoftDeletes;
    
    protected $table = "commentarticles";
    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    protected $fillable = [
        'body','article_id','created_by'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }
}
