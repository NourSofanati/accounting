<?php

use App\Models\ExpenseReciept;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseRecieptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_reciept_items', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->integer('qty')->nullable();
            $table->unsignedFloat('rate',16)->nullable();
            $table->foreignIdFor(ExpenseReciept::class, 'reciept_id');
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
        Schema::dropIfExists('expense_reciept_items');
    }
}
