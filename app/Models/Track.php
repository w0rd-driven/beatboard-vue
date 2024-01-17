<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Track extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'spotify_id',
        'album_spotify_id',
        'album_name',
        'album_image_url',
        'album_release_date',
        'album_total_tracks',
        'name',
        'popularity',
        'duration_ms',
        'searched_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'spotify_id' => 'string',
        'album_spotify_id' => 'string',
        'album_name' => 'string',
        'album_image_url' => 'string',
        'album_release_date' => 'datetime',
        'album_total_tracks' => 'integer',
        'name' => 'string',
        'popularity' => 'integer',
        'duration_ms' => 'integer',
        'searched_at' => 'datetime',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
