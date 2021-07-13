<?php

use App\Models\Account;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountIdToInvertoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invertories', function (Blueprint $table) {

            $table->foreignIdFor(Account::class, 'account_id')->nullable();
            $table->foreignIdFor(Account::class, 'expense_account_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invertories', function (Blueprint $table) {
            $table->dropForeignKey('account_id');
        });
    }
}
