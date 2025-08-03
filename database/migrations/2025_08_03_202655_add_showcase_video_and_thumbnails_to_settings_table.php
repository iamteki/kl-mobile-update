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
        Schema::table('settings', function (Blueprint $table) {
            // Add showcase video field
            $table->string('showcase_video')->nullable()->after('about_video');
            
            // Add thumbnail fields
            $table->string('about_video_thumbnail')->nullable()->after('showcase_video');
            $table->string('showcase_video_thumbnail')->nullable()->after('about_video_thumbnail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'showcase_video',
                'about_video_thumbnail', 
                'showcase_video_thumbnail'
            ]);
        });
    }
};