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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('hall_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at');
            $table->date('date_from');
            $table->string('text', 1000);
            $table->enum('period', ['WEEKLY', 'MONTHLY', 'YEARLY']);
            $table->string('PDF_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
