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
        Schema::table('event_types', function (Blueprint $table) {
            // Add image field after description if it doesn't exist
            if (!Schema::hasColumn('event_types', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
            // Add image_alt field for SEO
            if (!Schema::hasColumn('event_types', 'image_alt')) {
                $table->string('image_alt')->nullable()->after('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_types', function (Blueprint $table) {
            $table->dropColumn(['image', 'image_alt']);
        });
    }
};