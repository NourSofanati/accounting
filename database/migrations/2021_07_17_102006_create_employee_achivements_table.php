<?php

use App\Models\HR\EmployeeDetails;
use Database\Seeders\EmployeeSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAchivementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_achivements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EmployeeDetails::class, 'employee_id');
            $table->enum('type', ['certificate', 'experience']);
            $table->text('achievment');
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
        Schema::dropIfExists('employee_achivements');
    }
}
