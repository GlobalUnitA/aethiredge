<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartUsdtToAthDeviceAffTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ath_device_aff', function (Blueprint $table) {
            $table->decimal('part_usdt', 12,2)->default(0)->comment('보너스 당시 참여 금액')->after('bonus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ath_device_aff', function (Blueprint $table) {
            $table->dropColumn('part_usdt');
        });
    }
};
