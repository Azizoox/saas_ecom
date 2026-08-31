<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['user_id', 'session_id', 'metadata'];
    protected $casts = ['metadata' => 'array'];
    
    public function messages() {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
