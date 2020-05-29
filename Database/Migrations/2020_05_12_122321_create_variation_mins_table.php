<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariationMinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variation_mins', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('sku');

            $table->unsignedBigInteger('variation_id');
            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('restrict')->onUpdate('cascade');
            $table->string('value');

            $table->integer('min_qty')->default(1);

            $table->unsignedBigInteger('group')->nullable();
            $table->foreign('group')->references('id')->on('variation_mins')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('variation_mins');
    }
}
