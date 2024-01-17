<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained();
            $table->string('spotify_id');
            $table->string('album_spotify_id');
            $table->string('album_name');
            $table->string('album_image_url');
            $table->dateTime('album_release_date');
            $table->unsignedInteger('album_total_tracks');
            $table->string('name');
            $table->unsignedInteger('popularity');
            $table->unsignedBigInteger('duration_ms');
            $table->dateTime('searched_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
