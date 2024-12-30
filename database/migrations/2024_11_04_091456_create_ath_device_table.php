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
        Schema::create('ath_device', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->comment('회원 번호');
            $table->enum('status', ['o', 'p', 'c', 'r'])->default('o')->comment('주문 상태');
            $table->float('ea')->default(1)->comment('상품 수량');
            $table->decimal('usdt', 12, 2)->default(0)->comment('신청 금액');
            $table->decimal('real_usdt', 12, 2)->nullable()->comment('실제 금액');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ath_device');
    }
};
