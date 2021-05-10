<?php

use App\Models\ExpenseReciept;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseRecieptPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_reciept_payments', function (Blueprint $table) {
            $table->id();
            
            $table->foreignIdFor(ExpenseReciept::class, 'reciept_id');
            $table->unsignedFloat('amount',16)->nullable();
            $table->unsignedInteger('currency_value');
            $table->date('date')->nullable();
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
        Schema::dropIfExists('expense_reciept_payments');
    }
}
