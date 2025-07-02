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
        //
        Schema::table('consultation_sessions', function (Blueprint $table) {
            $table->dropColumn('end_time'); // حذف ستون زمان پایان ثابت
            $table->timestamp('ended_at')->after('start_time')->nullable(); // زمان پایان جلسه
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('consultation_sessions', function (Blueprint $table) {
            $table->dateTime('end_time')->after('start_time')->nullable();
            $table->dropColumn('ended_at');
        });
        
    }
};
