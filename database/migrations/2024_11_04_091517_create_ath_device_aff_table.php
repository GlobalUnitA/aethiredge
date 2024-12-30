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
        Schema::create('ath_device_aff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('ath_device')->comment('주문 번호');
            $table->foreignId('user_id')->constrained('users')->comment('회원 번호');
            $table->bigInteger('aff_user_id')->comment('산하 회원 번호');
            $table->tinyInteger('aff_user_level')->comment('산하 회원 레벨');
            $table->decimal('bonus', 12, 2)->comment('지급 금액');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ath_device_aff');
    }
};
