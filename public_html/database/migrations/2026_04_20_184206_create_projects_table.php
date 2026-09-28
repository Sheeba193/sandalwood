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
        Schema::create('projects', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('tagline')->nullable();

            $table->string('location');
            $table->string('specifications')->nullable();
            $table->string('location_url')->nullable();

            $table->enum('status', [
                'ongoing',
                'completed',
                'planned',
                'sold_out',
            ])->default('ongoing');

            $table->boolean('is_featured')->default(false);


            /*
            |--------------------------------------------------------------------------
            | Main Overview
            |--------------------------------------------------------------------------
            */

            $table->text('description')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Cover / Banner
            |--------------------------------------------------------------------------
            |
            | The actual image is also registered in Spatie Media Library.
            | This column stores the relative path for quick access.
            |
            */

            $table->string('cover_image')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Ideal Setting
            |--------------------------------------------------------------------------
            */

            $table->string('ideal_title')
                ->default('THE IDEAL SETTING');

            $table->text('ideal_description')->nullable();

            $table->string('ideal_image')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Tranquil Retreat
            |--------------------------------------------------------------------------
            */

            $table->string('tranquil_title')
                ->default('A TRANQUIL RETREAT');

            $table->text('tranquil_description')->nullable();

            $table->string('tranquil_image')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
