<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        // $name = ($this->user->name  != null) ? $this->user->name : "null"  ;
        return [
            'id' =>$this->id,
            'name'=>$this->name,
            'completed'=>$this->completed,
            'completed_at'=>$this->completed_at,
            // 'belongs_to'=>  $name
        ];
    }
}
