<?php

use App\Models\Item;
use App\Models\Label;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_label', function (Blueprint $table) {
            $tab1 = $table->foreignIdFor(Item::class);
            $tab2 = $table->foreignIdFor(Label::class);

            $tab1->constrained()->cascadeOnDelete();
            $tab2->constrained()->cascadeOnDelete();
            $table->primary([$tab1->name,$tab2->name]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_label');
    }
};
