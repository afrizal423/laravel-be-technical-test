<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsInsertUpdateResponse extends JsonResource
{
    protected $act;

    public function action($value){
        $this->act = $value;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'success '.$this->act.' data news',
            'data' => [
                'id' => $this->id,
                'title' => $this->title,
                'content' => $this->content,
                'image_banner' => $this->image_banner,
                'created_at' => (string) $this->created_at,
                'updated_at' => (string) $this->updated_at,
                'author' => $this->author->name,
            ]
        ];
    }
}
