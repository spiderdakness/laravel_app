<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ChatbotLog extends Model
{
    protected $fillable = ['user_id', 'question'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
