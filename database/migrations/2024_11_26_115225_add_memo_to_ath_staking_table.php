<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemoToAthStakingTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ath_staking', function (Blueprint $table) {
            $table->string('memo', 255)->nullable()->comment('관리자 메모')->after('image_urls');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ath_staking', function (Blueprint $table) {
            $table->dropColumn('memo');
        });
    }
};
