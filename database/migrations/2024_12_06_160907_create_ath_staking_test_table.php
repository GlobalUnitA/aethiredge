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
        Schema::create('ath_staking_test', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->comment('회원 번호');
            $table->foreignId('staking_id')->constrained('ath_staking')->comment('스테이킹 번호');
            $table->decimal('daily', 12,2)->default(0)->comment('데일리');
            $table->decimal('paid', 12,2)->default(0)->comment('지급');
            $table->decimal('earn', 12,2)->default(0)->comment('적립');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ath_staking_test');
    }
};
