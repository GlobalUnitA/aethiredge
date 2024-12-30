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
        Schema::create('ath_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->comment('회원 번호');
            $table->bigInteger('parent_id')->nullable()->comment('추천 회원 번호');
            $table->tinyInteger('level')->default(1)->comment('회원 레벨');
            $table->string('phone', 20)->comment('전화 번호');
            $table->string('post_code', 10)->nullable()->comment('우편 번호');
            $table->string('address', 255)->nullable()->comment('주소');
            $table->integer('meta_uid')->nullable()->comment('메타웨이브 유아이디');
            $table->string('pcc', 10)->nullable()->comment('개인통관번호');
            $table->string('part_usdt', 12,2)->default(0)->comment('참여 usdt');
            $table->string('memo', 255)->nullable()->comment('관리자 메모');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ath_user_info');
    }
};
