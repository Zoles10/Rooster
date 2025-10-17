<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'option_id',
        'user_id',
        'correct',
    ];

    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
