<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $dates = ['last_closed'];
    protected $fillable = [
        'question',
        'owner_id',
        'quiz_id',
        'subject_id',
        'active',
        'last_note',
        'last_closed',
    ];

    public function options()
    {
        return $this->hasMany(Option::class, 'question_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
