<?php

use App\Models\FixedAsset;
use App\Models\FixedAssetExpenses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStuffToExpenseRecieptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expense_reciepts', function (Blueprint $table) {
            $table->foreignIdFor(FixedAsset::class, 'asset_id')->nullable();
            $table->foreignIdFor(FixedAssetExpenses::class, 'expense_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expense_reciepts', function (Blueprint $table) {
            //
        });
    }
}
