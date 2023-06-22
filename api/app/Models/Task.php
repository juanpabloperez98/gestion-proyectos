<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'description',
        'status',
        'project_id',
    ];

    function project() {
        return $this->belongsTo(Project::class);
    }
}
