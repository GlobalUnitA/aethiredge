<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddisRefToAthDeviceAffTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ath_device_aff', function (Blueprint $table) {
            $table->tinyInteger('is_ref')->default(0)->comment('추천 보너스 여부')->after('aff_user_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ath_device_aff', function (Blueprint $table) {
            $table->dropColumn('is_ref');
        });
    }
};
