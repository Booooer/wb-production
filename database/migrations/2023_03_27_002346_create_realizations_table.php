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
        Schema::create('realizations', function (Blueprint $table) {
            $table->bigInteger('realizationreport_id');
            $table->dateTime('date_from');
            $table->dateTime('date_to');
            $table->dateTime('create_dt');
            $table->string('suppliercontract_code')->nullable();
            $table->bigInteger('rrd_id');
            $table->bigInteger('gi_id');
            $table->string('subject_name');
            $table->bigInteger('nm_id');
            $table->string('brand_name');
            $table->string('sa_name');
            $table->string('ts_name');
            $table->string('barcode');
            $table->string('doc_type_name');
            $table->integer('quantity');
            $table->bigInteger('retail_price');
            $table->bigInteger('retail_amount');
            $table->bigInteger('sale_percent');
            $table->float('commission_percent');
            $table->string('office_name');
            $table->string('supplier_oper_name');
            $table->dateTime('order_dt');
            $table->dateTime('sale_dt');
            $table->dateTime('rr_dt');
            $table->bigInteger('shk_id');
            $table->float('retail_price_withdisc_rub');
            $table->integer('delivery_amount');
            $table->integer('return_amount');
            $table->integer('delivery_rub');
            $table->string('gi_box_type_name');
            $table->float('product_discount_for_report');
            $table->integer('supplier_promo');
            $table->bigInteger('rid');
            $table->float('ppvz_spp_prc');
            $table->float('ppvz_kvw_prc_base');
            $table->float('ppvz_kvw_prc');
            $table->float('ppvz_sales_commission');
            $table->float('ppvz_for_pay');
            $table->integer('ppvz_reward');
            $table->float('acquiring_fee');
            $table->string('acquiring_bank');
            $table->float('ppvz_vw');
            $table->float('ppvz_vw_nds')->nullable;
            $table->bigInteger('ppvz_office_id');
            $table->string('ppvz_office_name')->nullable;
            $table->bigInteger('ppvz_supplier_id');
            $table->string('ppvz_supplier_name');
            $table->string('ppvz_inn');
            $table->string('declaration_number');
            $table->string('bonus_type_name')->nullable;
            $table->string('sticker_id');
            $table->string('site_country');
            $table->float('penalty');
            $table->integer('additional_payment');
            $table->string('kiz')->nullable;
            $table->string('srid');
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
        Schema::dropIfExists('realizations');
    }
};
