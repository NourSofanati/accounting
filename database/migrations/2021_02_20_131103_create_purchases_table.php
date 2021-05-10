<?php

use App\Models\Account;
use App\Models\AttachmentGroup;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->foreignIdFor(Vendor::class, 'vendor_id')->nullable();
            $table->foreignIdFor(Transaction::class, 'transaction_id')->nullable();
            $table->foreignIdFor(AttachmentGroup::class, 'attachments_id')->nullable();
            $table->foreignIdFor(Account::class, 'purchased_asset_id');
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
