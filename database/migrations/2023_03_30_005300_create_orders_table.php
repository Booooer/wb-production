<?php

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
        Schema::create('orders', function (Blueprint $table) {
            $table->dateTime("date");
            $table->dateTIme("lastChangeDate");
            $table->string("supplierArticle");
            $table->string("techSize");
            $table->string("barcode");
            $table->bigInteger("totalPrice");
            $table->integer("discountPercent");
            $table->string("warehouseName");
            $table->string("oblast");
            $table->integer("incomeID");
            $table->integer("odid");
            $table->integer("nmId");
            $table->string("subject");
            $table->string("category");
            $table->string("brand")->nullable();
            $table->boolean("isCancel");
            $table->dateTime("cancel_dt");
            $table->string("gNumber");
            $table->string("sticker")->nullable();
            $table->string("srid");
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
        Schema::dropIfExists('orders');
    }
};
