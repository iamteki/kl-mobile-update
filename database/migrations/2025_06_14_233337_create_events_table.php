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
        Schema::create('events', function (Blueprint $table) {
           $table->id();
            $table->foreignId('event_type_id')
                  ->nullable()
                  ->constrained('event_types')
                  ->onDelete('set null');
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->string('slug')->unique();
            $table->string('featured_image')->nullable();
            $table->string('video')->nullable(); // S3 path
            $table->json('image_gallery')->nullable(); // Array of S3 paths
            $table->string('video_title')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            
            $table->index('event_type_id');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
