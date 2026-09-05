<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('institutions', 'user_id')) {

            Schema::table('institutions', function (Blueprint $table) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            });

        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('institutions', 'user_id')) {

            Schema::table('institutions', function (Blueprint $table) {

                // Hapus foreign key jika memang ada
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Throwable $e) {
                    // Abaikan jika foreign key tidak ditemukan
                }

                $table->dropColumn('user_id');
            });

        }
    }
};