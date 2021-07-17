<?php

use App\Models\Account;
use App\Models\Currency;
use App\Models\Invertory;
use App\Models\Vendor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Account::class, 'account_id')->nullable();
            $table->foreignIdFor(Account::class, 'expense_account_id')->nullable();
            $table->foreignIdFor(Invertory::class, 'invertory_id')->nullable();
            $table->foreignIdFor(Account::class, 'purchase_account')->nullable();
            $table->foreignIdFor(Currency::class, 'currency_id')->default(1);
            $table->foreignIdFor(Vendor::class,'vendor_id')->nullable();
            $table->date('purchase_date')->nullable();
            $table->text('supervisor')->nullable();
            $table->text('name');
            $table->decimal('currency_value', 16, 2)->nullable();
            $table->decimal('value', 16, 2)->nullable();
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
        Schema::dropIfExists('fixed_assets');
    }
}
