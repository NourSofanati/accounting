<?php

use App\Models\HR\EmployeeDetails;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_vacations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EmployeeDetails::class, 'employee_id');
            $table->dateTime('fromDate');
            $table->dateTime('toDate');
            $table->boolean('paid');
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
        Schema::dropIfExists('employee_vacations');
    }
}
