<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
    * Run the migrations.
    */

    public function up(): void
    {
        DB::statement("ALTER TABLE business_requests MODIFY status ENUM('PENDING', 'ACCEPTED', 'REJECTED', 'CANCELLED') DEFAULT 'PENDING'");
    }

    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::table('business_requests', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->enum('status', ['PENDING', 'ACCEPTED', 'REJECTED'])->default('PENDING');
        });
    }
};
