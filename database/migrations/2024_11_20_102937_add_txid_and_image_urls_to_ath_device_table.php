<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTxidAndImageUrlsToAthDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ath_device', function (Blueprint $table) {
            $table->string('txid', 50)->nullable()->comment('txid')->after('usdt');
            $table->json('image_urls')->nullable()->comment('이미지 링크')->after('txid');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ath_device', function (Blueprint $table) {
            $table->dropColumn(['txid', 'image_urls']);
        });
    }
}