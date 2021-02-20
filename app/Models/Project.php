<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Team $team
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function team() {
        return $this->belongsTo(Team::class);
    }
}
