<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Tags extends Model
{
    use SoftDeletes;

    protected $table = "Tags";
    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    public static function rules($update = false, $id = null)
    {
        $rules =
        [
            'TagsName' => ['required', Rule::unique('Tags')->ignore($id,'id')],
            'Description' => 'required'

        ];

        if($update)
        {
            return $rules;
        }

        return array_merge($rules,[
            'TagsName' => 'required|unique:Tags,TagsName'
        ]);
    }

}
