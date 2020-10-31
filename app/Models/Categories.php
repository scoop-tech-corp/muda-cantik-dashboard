<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;

    protected $table = "categories";
    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    protected $fillable = [
        'categoriesname', 'description', 'slug', 'message', 'created_by',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
