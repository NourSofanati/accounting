<?php

use App\Models\Attachment;
use App\Models\ExpenseCategory;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseRecieptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_reciepts', function (Blueprint $table) {
            $table->id();
            $table->date('issueDate')->nullable();
            $table->date('dueDate')->nullable();
            $table->foreignIdFor(Vendor::class,'vendor_id')->nullable();
            $table->foreignIdFor(Attachment::class, 'attachment_id')->nullable();
            $table->foreignIdFor(Transaction::class, 'transaction_id')->nullable();
            $table->foreignIdFor(ExpenseCategory::class, 'category_id')->nullable();
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
        Schema::dropIfExists('expense_reciepts');
    }
}
