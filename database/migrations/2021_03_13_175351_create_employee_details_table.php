<?php

use App\Models\Account;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_details', function (Blueprint $table) {
            $table->id();
            $table->text('firstName');
            $table->text('lastName');
            $table->date('birthDate');
            $table->date('startDate');
            $table->enum('gender', ['male', 'female']);
            $table->text('payday');
            $table->decimal('monthlySalary', 16, 2);
            $table->foreignIdFor(Account::class, 'liability_account_id');
            $table->foreignIdFor(Account::class, 'expense_account_id');
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
        Schema::dropIfExists('employee_details');
    }
}
