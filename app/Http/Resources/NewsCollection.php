<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'message' => 'success get all news',
            'data' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'content' => Str::limit($item->content, 200),
                    'image_banner' => $item->image_banner,
                    'created_at' => (string) $item->created_at,
                    'updated_at' => (string) $item->updated_at,
                    'comments_total' => (int) $item->jumlah_komentar,
                    'author' => $item->author->name,
                ];
            }),
            'pagination' => [
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_pages' => $this->lastPage(),
            ],
        ];
    }
}
