<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('role', 'admin')->update(['role' => 'staff']);
    }

    public function down(): void
    {
        // Keep role data intact when rolling back; staff roles may predate this migration.
    }
};
