<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $table = "addresses";
    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    protected $fillable = [
        'name','phone', 'provinsi','kota','kecamatan',
        'kabupaten','detailAddress','created_by'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
