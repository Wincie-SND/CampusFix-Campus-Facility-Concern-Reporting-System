<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facility_concerns', function (Blueprint $table): void {
            $table->string('title', 120)->nullable()->after('category');
            $table->string('building', 120)->nullable()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('facility_concerns', function (Blueprint $table): void {
            $table->dropColumn(['title', 'building']);
        });
    }
};
