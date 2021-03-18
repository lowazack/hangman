<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $visible = [
        'id', 'created_at', 'updated_at', 'word', 'hasLost', 'hasWon', 'difficulty', 'user_id', 'user', 'duration'
    ];

    protected $appends =[
      'duration'
    ];

    protected $with = [
        'user'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getDurationAttribute(): string
    {
        $diff = $this->created_at->diffInSeconds($this->updated_at);
        return  gmdate('H:i:s', $diff);

    }
}
