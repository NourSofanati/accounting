<?php

use App\Models\HR\EmployeeDetails;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EmployeeDetails::class, 'employee_id');
            $table->date('date');
            $table->decimal('bonus_amount', 16, 2);
            $table->decimal('currency_value', 16, 2);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('employee_bonuses');
    }
}
