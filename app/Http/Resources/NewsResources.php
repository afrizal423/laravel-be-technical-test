<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'message' => 'success get detail news',
            'data' => [
                'id' => $this->id,
                'title' => $this->title,
                'content' => $this->content,
                'image_banner' => $this->image_banner,
                'created_at' => (string) $this->created_at,
                'updated_at' => (string) $this->updated_at,
                'author' => $this->author->name,
            ],
            'comments_total' => (int) $this->jumlah_komentar,
            'comments' => $this->comments->map(function ($cm) {
                return [
                    'id' => $cm->id,
                    'comment' => $cm->comment,
                    'created_at' => (string) $cm->created_at,
                    'updated_at' => (string) $cm->updated_at,
                    'author' => $cm->author->name,
                ];
            })
        ];
    }
}
