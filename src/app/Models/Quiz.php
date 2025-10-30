<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quiz extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $dates = ['last_closed'];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            do {
                $random = Str::random(5);
            } while (self::where($model->getKeyName(), $random)->exists());

            $model->{$model->getKeyName()} = $random;
        });
    }

    protected $fillable = [
        'title',
        'description',
        'owner_id',
        'active',
        'last_closed',
        'previous_closed',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class, 'quiz_id');
    }
}
