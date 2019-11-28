<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'vote_count' => $this->vote_count,
            'answer_count' => $this->answer_count,
            'views' => $this->views,
            'status' => $this->status,
            'excerpt' => $this->excerpt,
            'created_date' => $this->created_date,
            'user' => new UserResource($this->user),
        ];
    }
}
