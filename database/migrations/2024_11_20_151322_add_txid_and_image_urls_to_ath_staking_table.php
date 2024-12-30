<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTxidAndImageUrlsToAthStakingTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ath_staking', function (Blueprint $table) {
            $table->string('txid', 50)->nullable()->comment('txid')->after('ath');
            $table->json('image_urls')->nullable()->comment('이미지 링크')->after('txid');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ath_staking', function (Blueprint $table) {
            $table->dropColumn(['txid', 'image_urls']);
        });
    }
};
