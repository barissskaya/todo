<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function scopeLevel($query, $level){
        return $query->where('level', $level);
    }

    public function scopeDurationAsc($query){
        return $query->orderBy('duration');
    }

    public function scopeDurationDesc($query){
        return $query->orderByDesc('duration');
    }
}
