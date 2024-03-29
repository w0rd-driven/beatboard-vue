<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'spotify_id',
        'name',
        'image_url',
        'follower_count',
        'searched_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'spotify_id' => 'string',
        'name' => 'string',
        'image_url' => 'string',
        'follower_count' => 'integer',
        'searched_at' => 'datetime',
    ];

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
}
