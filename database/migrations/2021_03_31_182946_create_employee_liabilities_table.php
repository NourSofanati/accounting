<?php

use App\Models\HR\EmployeeDetails;
use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeLiabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_liabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EmployeeDetails::class,'employee_id');
            $table->foreignIdFor(Transaction::class,'transaction_id');
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
        Schema::dropIfExists('employee_liabilities');
    }
}
