<?php

use App\Models\HR\Employee;
use App\Models\HR\EmployeeDetails;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_pictures', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EmployeeDetails::class, 'employee_id');
            $table->longText('uri');
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
        Schema::dropIfExists('employee_pictures');
    }
}
