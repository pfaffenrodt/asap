<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property Team $team
 * @property integer $id
 * @property string $repository
 * @property string $host
 * @property string $path
 * @property string $integration_type
 * @property string $integration_access_token
 * @property boolean $has_integration_access_token
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'repository',
        'integration_type',
        'integration_access_token',
    ];

    protected $hidden = [
        'integration_access_token',
    ];

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function getHasIntegrationAccessTokenAttribute() {
        return Str::length(trim($this->integration_access_token)) > 0;
    }

    public function getHostAttribute() {
        $repositoryUrlData = parse_url($this->repository);
        return $repositoryUrlData['host'] ?? null;
    }

    public function getPathAttribute() {
        $repositoryUrlData = parse_url($this->repository);
        return $repositoryUrlData['path'] ?? null;
    }
}
