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
        Schema::create('storage', function (Blueprint $table) {
            $table->bigInteger('nmId');
            $table->dateTime('lastChangeDate');
            $table->string('supplierArticle');
            $table->integer('techSize');
            $table->bigInteger('barcode');
            $table->bigInteger('quantity');
            $table->boolean('isSupply');
            $table->boolean('isRealization');
            $table->bigInteger('quantityFull');
            $table->string('warehouseName');
            $table->string('subject');
            $table->string('category');
            $table->integer('daysOnSite');
            $table->string('brand')->nullable();
            $table->string('SCCode')->nullable();
            $table->integer('Price');
            $table->integer('Discount')->nullable();
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
        Schema::dropIfExists('storage');
    }
};
