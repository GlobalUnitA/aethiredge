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
        Schema::table('ath_board', function (Blueprint $table) {
            $table->string('board_code', 10)->comment('게시판 코드')->after('id');
            $table->string('board_name', 50)->comment('게시판 이름')->after('board_code');
            $table->dropColumn('board_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ath_board', function (Blueprint $table) {
            $table->dropColumn(['board_code', 'board_name']);
            $table->string('board_id', 20)->comment('게시판 이름');
        });
    }
};
