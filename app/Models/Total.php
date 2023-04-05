<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Total extends Model
{
    use HasFactory;

    protected $fillable = [
        "gNumber",
        "srid",
        "barcode",
        "PriceWithDisc",
        "dateOrder",
        "isCancel",
        "cancel_dt",
        "nmId",
        "supplierArticle",
        "dateSale",
        "retail_price_withdisc_rub",
        "retail_amount",
        "ppvz_for_pay",
        "logistics",
        "logisticsRefund",
        "penalty",
        "surcharge",
        "commission_wb",
        "costPrice",
        "advert_budget",
        "count_orders",
        "spo",
        "marginality_rub",
        "marginality_percent",
        "days_on_the_road",
        "status",
        "orders_things",
        "buyout_rub",
        "buyout_things",
        "refuse_rub",
        "refuse_things",
        "refund_rub",
        "refund_things",
        "inTransit_rub",
        "inTransit_things",
        "category",
        "subject",
        "storage",
        "SPP_rub",
        "SPP_percent",
        "countryName",
        "oblastOkrugName",
        "regionName",
        "brand",
        "avg_days_buyout",
        "quantity",
    ];
}
