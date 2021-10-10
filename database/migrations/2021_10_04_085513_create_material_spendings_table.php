<?php

use App\Models\Account;
use App\Models\Material;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialSpendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_spendings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Material::class, 'material_id');
            $table->foreignIdFor(Account::class,'account_spent_on_id')->nullable();
            $table->date('date');
            $table->decimal('qty_spent', 20);
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
        Schema::dropIfExists('material_spendings');
    }
}
