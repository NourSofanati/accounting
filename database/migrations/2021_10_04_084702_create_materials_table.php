<?php

use App\Models\Invertory;
use App\Models\MaterialCategory;
use App\Models\PurchaseItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignIdFor(Invertory::class, 'invertory_id');
            $table->foreignIdFor(PurchaseItem::class, 'purchase_item_id');
            $table->foreignIdFor(MaterialCategory::class, 'category_id');
            $table->decimal('price', 20);
            $table->decimal('qty', 20);
            // $table->decimal('amount_spent', 20)->nullable()->default(0);
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
        Schema::dropIfExists('materials');
    }
}
