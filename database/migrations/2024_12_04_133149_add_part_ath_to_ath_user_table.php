<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartAthToAthUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ath_user', function (Blueprint $table) {
            $table->decimal('part_ath', 12, 2)->default(0)->comment('참여 ath')->after('part_usdt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ath_user', function (Blueprint $table) {
            $table->dropColumn('part_ath');
        });
    }
};
