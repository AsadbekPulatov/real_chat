<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $attributes = [
        'is_read' => 0
    ];

    protected $fillable = [
        'receiver_id',
        'sender_id',
        'text'
    ];

    public function receiver(){
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }
}
