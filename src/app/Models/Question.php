<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poll;

class Question extends Model
{
    use HasFactory;

    public function scopeWithPollId($query, $pollId)
    {
        return $query->where('poll_id', $pollId);
    }
}
