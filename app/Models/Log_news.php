<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_news extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_description',
        'news_id',
        'user_id'
    ];
}
