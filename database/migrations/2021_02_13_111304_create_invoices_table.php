<?php

use App\Models\AttachmentGroup;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('issueDate')->nullable();
            $table->date('dueDate')->nullable();
            $table->enum('status', ['مسودة', 'مرسلة', 'مدفوعة'])->default('مسودة');
            $table->integer('currency_value')->nullable();
            $table->integer('invoice_month')->nullable();
            $table->text('invoice_date')->nullable();
            $table->foreignIdFor(Transaction::class, 'transaction_id')->nullable();
            $table->foreignIdFor(Customer::class, 'customer_id')->nullable();
            $table->foreignIdFor(Currency::class, 'currency_id')->nullable();
            $table->foreignIdFor(AttachmentGroup::class, 'attachment_group_id')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
