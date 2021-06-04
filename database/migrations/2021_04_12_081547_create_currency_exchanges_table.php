<?php

use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_exchanges', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('amount');
            $table->decimal('amount_spent');
            $table->decimal('currency_value');
            $table->foreignIdFor(Currency::class, 'currency_to');
            
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
        Schema::dropIfExists('currency_exchanges');
    }
}
