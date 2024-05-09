<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Option;


class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'question_type',
        'owner_id',
        'subject',
        'active'
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}
