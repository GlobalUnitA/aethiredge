<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageUrlsToAthStakingTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ath_staking', function (Blueprint $table) {
            $table->json('image_urls')->nullable()->comment('이미지 링크')->after('real_usdt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ath_staking', function (Blueprint $table) {
            $table->dropColumn(['image_urls']);
        });
    }
};
