<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'gender',
        'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
