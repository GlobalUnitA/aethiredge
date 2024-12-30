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
        Schema::table('ath_post', function (Blueprint $table) {
            $table->bigInteger('comment_id')->default(0)->comment('답글 게시글 번호')->after('board_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ath_post', function (Blueprint $table) {
            $table->dropColumn('comment_id');
        });
    }
};
