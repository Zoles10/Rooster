<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_text',
        'archived'
    ];

    public function scopeWithQuestionId($query, $questionId)
    {
        return $query->where('question_id', $questionId);
    }
}
