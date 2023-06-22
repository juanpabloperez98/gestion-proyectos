<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'description',
        'date_start',
        'date_end',
        'user_id',
    ];

    function user() {
        return $this->belongsTo(User::class);
    }

    function tasks() {
        return $this->hasMany(Task::class);
    }
}
