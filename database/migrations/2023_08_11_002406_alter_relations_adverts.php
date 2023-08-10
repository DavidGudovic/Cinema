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
        Schema::table('adverts', callback: function (Blueprint $table) {
            $table->dropForeign('adverts_screening_id_foreign');
            $table->dropColumn('screening_id');
        });
    }

    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::table('adverts', callback: function (Blueprint $table) {
            $table->unsignedBigInteger('screening_id')->nullable();
            $table->foreign('screening_id')->references('id')->on('screenings');
        });
    }
};
