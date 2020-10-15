<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tags extends Model
{
    use SoftDeletes;

    protected $table = "Tags";
    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    protected $fillable = [
        'tagname','description', 'slug','created_by'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
