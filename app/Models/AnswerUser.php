<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id',
        'option_id',
        'exam_id',
        'result',
    ];
}
