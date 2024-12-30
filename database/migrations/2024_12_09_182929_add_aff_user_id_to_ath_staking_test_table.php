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
        Schema::table('ath_staking_test', function (Blueprint $table) {
            $table->bigInteger('aff_user_id')->comment('산하 회원 번호')->after('staking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ath_staking_test', function (Blueprint $table) {
            $table->dropColumn('aff_user_id');
        });
    }
};
