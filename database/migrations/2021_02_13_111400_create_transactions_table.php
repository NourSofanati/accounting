<?php

use App\Models\Currency;
use App\Models\ExpenseReciept;
use App\Models\Invoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->text('transaction_name')->nullable();
            $table->date('transaction_date')->nullable();
            $table->foreignIdFor(Invoice::class, 'invoice_id')->nullable();
            $table->foreignIdFor(ExpenseReciept::class, 'reciept_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices')->cascadeOnDelete();
            $table->foreign('reciept_id')->references('id')->on('expense_reciepts')->cascadeOnDelete();
            $table->enum('ref_type', ['reciept', 'invoice'])->nullable();
            $table->foreignIdFor(Currency::class, 'currency_id')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
