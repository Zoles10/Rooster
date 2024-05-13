<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'option_text', 'correct'];

    public $timestamps = false;

    public function optionsHistory()
    {
        return $this->hasOne(OptionsHistory::class);
    }
}
