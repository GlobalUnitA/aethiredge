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
        Schema::create('ath_staking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->comment('회원 번호');
            $table->enum('status', ['o', 'p', 'c', 'r'])->default('o')->comment('주문 상태');
            $table->integer('ea')->default(13500)->comment('상품 수량');
            $table->integer('bundle')->default(1)->comment('번들 수량');
            $table->decimal('ath', 12, 2)->default(0)->comment('신청 금액');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ath_staking');
    }
};
