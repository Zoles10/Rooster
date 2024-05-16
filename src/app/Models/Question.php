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
        'question',
        'question_type',
        'owner_id',
        'subject_id',
        'active',
        'word_cloud',
        'last_note',
        'last_closed',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
