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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            // Sales yang melakukan kunjungan
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Instansi yang dikunjungi
            $table->foreignId('institution_id')
                ->constrained('institutions')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Jenis kunjungan
            $table->foreignId('visit_type_id')
                ->constrained('visit_types')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Hasil kunjungan
            $table->foreignId('visit_result_id')
                ->constrained('visit_results')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('visit_date');
            $table->time('visit_time');

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
