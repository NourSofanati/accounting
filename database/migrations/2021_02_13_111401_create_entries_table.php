<?php

use App\Models\Account;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedFloat('cr',16)->nullable();
            $table->unsignedFloat('dr',16)->nullable();
            $table->foreignIdFor(Account::class, 'account_id');
            $table->foreignIdFor(Transaction::class, 'transaction_id')->constrained();
            $table->unsignedInteger('currency_value');
            $table->foreignIdFor(Currency::class,'currency_id')->default(1)->nullable();
            //$table->foreign('transaction_id')->references('id')->on('transactions')->cascadeOnDelete();
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
        Schema::dropIfExists('entries');
    }
}
