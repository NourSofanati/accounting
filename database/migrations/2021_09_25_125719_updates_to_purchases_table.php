<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatesToPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->decimal('currency_value',24,2);
            $table->enum('type', ['material', 'asset']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('attachments_id');
            $table->dropColumn('purchased_asset_id');
        });
    }
}
