<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'CategoriesName' => $this->CategoriesName,
            'Description' => $this->Description,
            'Slug' => $this->Slug,
            'Message' => $this->Message,
            'isDeleted' => $this->isDeleted,
            'created_by' => $this->created_by,
            'update_by' => $this->update_by
        ];
    }
}
