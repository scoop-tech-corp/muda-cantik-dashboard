<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Categories extends Model
{
    use SoftDeletes;

    protected $table = "Categories";
    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    public static function rules($update = false, $id = null)
    {
        $rules = [
            'CategoriesName' => 'required|max:30'
        ];

        if($update)
        {
            return $rules;
        }

        return $rules;
    }
}
