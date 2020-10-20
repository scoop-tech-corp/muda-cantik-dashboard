<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;

    protected $table = "gallery";
    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id','imagename', 'imagetype','size','alternativetext',
        'title','caption','description','url','created_by'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
