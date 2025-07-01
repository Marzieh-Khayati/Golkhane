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
        Schema::table('consultation_sessions', function (Blueprint $table) {
            $table->dropColumn('payment_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultation_sessions', function (Blueprint $table) {
            //
            $table->decimal('pament_amount',10,0)->after('status');
        });
    }
};
