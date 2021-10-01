<?php

use App\Models\PurchaseItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_item_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PurchaseItem::class, 'purchase_item');
            $table->text('key');
            $table->text('value');
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
        Schema::dropIfExists('purchase_item_attributes');
    }
}
