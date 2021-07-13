<?php

use App\Models\Account;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidFromColumnToExpenseRecieptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expense_reciepts', function (Blueprint $table) {
            $table->foreignIdFor(Account::class,'paid_from')->nullable();
            $table->boolean('refunded')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('column_to_expense_reciepts', function (Blueprint $table) {
            $table->dropColumn('paid_from');
        });
    }
}
