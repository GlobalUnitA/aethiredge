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
        Schema::create('ath_board', function (Blueprint $table) {
            $table->id();
            $table->string('board_id', 20)->comment('게시판 이름');
            $table->tinyInteger('access_level')->comment('접근 레벨');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ath_board');
    }
};
