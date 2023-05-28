<?php

namespace App\Models;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comments extends Model
{
    use HasFactory, HasUlids;
    protected $fillable = [
        'comment',
        'user_id',
        'news_id'
    ];

    public function author(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function news(){
        return $this->belongsTo(News::class);
    }
}
