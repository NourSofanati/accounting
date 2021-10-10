<?php

use App\Models\Currency;
use App\Models\HR\Employee;
use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',20);
            $table->integer('currency_value');
            $table->date('payment_date');
            $table->foreignIdFor(Currency::class, 'currency_id');
            $table->foreignIdFor(Employee::class, 'employee_id');
            $table->foreignIdFor(Transaction::class, 'transaction_id');
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
        Schema::dropIfExists('employee_payments');
    }
}
