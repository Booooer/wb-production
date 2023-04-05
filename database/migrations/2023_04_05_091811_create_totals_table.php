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
        Schema::create('totals', function (Blueprint $table) {
            $table->bigInteger("gNumber");
            $table->bigInteger("srid");
            $table->bigInteger("barcode");
            $table->integer("PriceWithDisc");
            $table->date("dateOrder");
            $table->boolean("isCancel");
            $table->date("cancel_dt");
            $table->bigInteger("nmId");
            $table->string("supplierArticle");
            $table->dateTime("dateSale");
            $table->integer("retail_amount");
            $table->integer("ppvz_for_pay");
            $table->integer("logistics");
            $table->integer("logisticsRefund");
            $table->integer("penalty");
            $table->integer("surcharge");
            $table->integer("commission_wb");
            $table->integer("costPrice");
            $table->float("advert_budget");
            $table->integer("count_orders");
            $table->float("spo");
            $table->integer("marginality_rub");
            $table->integer("marginality_percent");
            $table->integer("days_on_the_road");
            $table->string("status");
            $table->float("orders_things");
            $table->integer("buyout_rub")->nullable();
            $table->integer("buyout_things")->nullable();
            $table->integer("refuse_rub")->nullable();
            $table->integer("refuse_things")->nullable();
            $table->integer("refund_rub")->nullable();
            $table->integer("refund_things")->nullable();
            $table->integer("inTransit_rub")->nullable();
            $table->integer("inTransit_things")->nullable();
            $table->string("category");
            $table->string("subject");
            $table->string("storage");
            $table->integer("SPP_rub");
            $table->integer("SPP_percent");
            $table->string("countryName");
            $table->string("oblastOkrugName")->nullable();
            $table->string("regionName")->nullable();
            $table->string("brand")->nullable();
            $table->integer("avg_days_buyout");
            $table->integer("quantity");
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
        Schema::dropIfExists('totals');
    }
};
