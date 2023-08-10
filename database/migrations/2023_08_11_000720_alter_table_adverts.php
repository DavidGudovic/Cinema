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
        Schema::table('adverts', function (Blueprint $table) {
            $table->string('title')->max('255');
            $table->string('company')->max('255');
            $table->integer('quantity')->default(1);
            $table->dropColumn('slot_number');
        });
    }

    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::table('adverts', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('company');
            $table->dropColumn('quantity');
            $table->integer('slot_number')->default(1);
        });
    }
};
