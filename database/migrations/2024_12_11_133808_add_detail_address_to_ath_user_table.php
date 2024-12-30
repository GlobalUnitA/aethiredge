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
        Schema::table('ath_user', function (Blueprint $table) {
            $table->string('detail_address', 255)->nullable()->comment('상세 주소')->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ath_user', function (Blueprint $table) {
            $table->dropColumn('detail_address');
        });
    }
};
