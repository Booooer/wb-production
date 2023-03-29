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
        Schema::create('sales', function (Blueprint $table) {
            $table->string('srid')->nullable();
            $table->dateTime("date");
            $table->dateTime("lastChangeDate");
            $table->string("supplierArticle");
            $table->string("techSize");
            $table->string("barcode");
            $table->bigInteger("totalPrice");
            $table->integer("discountPercent");
            $table->boolean("isSupply");
            $table->boolean("isRealization");
            $table->bigInteger("promoCodeDiscount");
            $table->string("warehouseName");
            $table->string("countryName");
            $table->string("oblastOkrugName");
            $table->string("regionName");
            $table->bigInteger("incomeID");
            $table->string("saleID");
            $table->bigInteger("odid");
            $table->bigInteger("spp");
            $table->bigInteger("forPay");
            $table->bigInteger("finishedPrice");
            $table->bigInteger("priceWithDisc");
            $table->bigInteger("nmId");
            $table->string("subject");
            $table->string("category");
            $table->string("brand");
            $table->string("IsStorno");
            $table->string("gNumber");
            $table->string("sticker");
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
        Schema::dropIfExists('sales');
    }
};
