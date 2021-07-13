<?php

use App\Models\FixedAssetExpenseGroup;
use App\Models\Account;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_asset_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FixedAssetExpenseGroup::class, 'group_id');
            $table->foreignIdFor(Account::class, 'account_id');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixed_asset_expenses');
    }
}
