<?php

namespace App\Models;

use App\Models\Comments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'title',
        'content',
        'image_banner',
        'user_id',
    ];

    public function author(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments(){
        return $this->hasMany(Comments::class)->with(['author']);
    }
}
