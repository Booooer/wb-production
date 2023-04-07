<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Storage;
use App\Models\Realization;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Total;
use App\Models\CostPrice;
use App\Models\AdvertInfo;

class ApiController extends Controller
{
    // private $api = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6ImZjNGUyZDNmLWVkZDgtNDRhZi05YjNlLTlkZGM0YzhiMDRjNCJ9.2ykXlcgfHf7t7ecLo1alJa3dn-K_NiIWFSHkeXkr-vg";
    private $api = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6IjkwOWIwMWYzLTQ5MjEtNDYzMS1hNmRiLThhNjU1ODA1N2VmZiJ9.SSiUyltd0E56NMaTRIu-rWgeLGJfY-7-PeelCyOOcDY";

    private function getContext(){
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'accept: application/json',
                    'content-type: application/json',
                    "Authorization: $this->api",
                ]
            ]
        ];

        return stream_context_create($options);
    }
    
    private function getStatus($logisticsRefund, $isCancel){
        if($logisticsRefund == 0 && !$isCancel){
            return "Выкуплен";
        }
        if ($logisticsRefund > 0 && !$isCancel) {
            return "Возврат";
        }
        
        return "Отказ";   //($logisticsRefund == 0 && !$isCancel ?  "Выкуплен" : $logisticsRefund > 0 && !$isCancel) ? "Возврат" : "Отказ"       
    }

    private function mergeRealizations($realization){
        if (count($realization) > 1){
            $array1 = $realization[0]->toArray();
            $array2 = $realization[1]->toArray();

            if (empty($realization[0]->retail_price)) {
                return $realization = (object)array_merge($array1,$array2);
            }

            return $realization = (object)array_merge($array2,$array1);
        }

        return (object)$realization[0];
    }

    public function updateStorage(){
        $dateFrom = date('Y-m-d', time() - 86400);
        $url = "https://statistics-api.wildberries.ru/api/v1/supplier/stocks?dateFrom=$dateFrom";

        $context = $this->getContext();

        $result = json_decode(file_get_contents($url, false, $context));

        foreach($result as $item){
            Storage::create([
                'nmId' => $item->nmId,
                'lastChangeDate' => $item->lastChangeDate,
                'supplierArticle' => $item->supplierArticle,
                'techSize' => $item->techSize,
                'barcode' => $item->barcode,
                'quantity' => $item->quantity,
                'isSupply' => $item->isSupply,
                'isRealization' => $item->isRealization,
                'quantityFull' => $item->quantityFull,
                'warehouseName' => $item->warehouseName,
                'subject' => $item->subject,
                'category' => $item->category,
                'daysOnSite' => $item->daysOnSite,
                'brand' => $item->brand,
                'SCCode' => $item->SCCode,
                'Price' => $item->Price,
                'Discount' => $item->Discount,
            ]);
        }
        return "Код 200: Обновление базы данных 'storage' прошло успешно";
    }
        
    public function updateRealizations(Request $request){
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;
        $url = "https://statistics-api.wildberries.ru/api/v1/supplier/reportDetailByPeriod?dateFrom=$dateFrom&dateTo=$dateTo";

        $context = $this->getContext();

        $result = json_decode(file_get_contents($url, false, $context));
        
        // Предварительное очищение бд перед заполнением
        Realization::truncate();

        foreach($result as $item){
            Realization::create([
                "realizationreport_id" => $item->realizationreport_id,
                "date_from"	=> date('Y-m-d H:i:s', strtotime($item->date_from)),
                "date_to" => date('Y-m-d H:i:s', strtotime($item->date_to)),
                "create_dt" => date('Y-m-d H:i:s', strtotime($item->create_dt)),
                "suppliercontract_code" => $item->suppliercontract_code,
                "rrd_id" => $item->rrd_id,	
                "gi_id" => $item->gi_id,	
                "subject_name" => $item->subject_name,	
                "nm_id"	 => $item->nm_id,
                "brand_name" => isset($item->brand_name) ? $item->brand_name : "",	
                "sa_name" => $item->sa_name,	
                "ts_name" => $item->ts_name,
                "barcode" => $item->barcode,
                "doc_type_name"	 => $item->doc_type_name,
                "quantity"	 => $item->quantity,
                "retail_price" => $item->retail_price,
                "retail_amount"	 => $item->retail_amount,
                "sale_percent"	 => $item->sale_percent,
                "commission_percent" => $item->commission_percent,
                "office_name" => isset($item->office_name) ? $item->office_name : "",
                "supplier_oper_name" => $item->supplier_oper_name,
                "order_dt"	 => date('Y-m-d H:i:s', strtotime($item->order_dt)),
                "sale_dt" => date('Y-m-d H:i:s', strtotime($item->sale_dt)),
                "rr_dt"	 => date('Y-m-d H:i:s', strtotime($item->sale_dt)),
                "shk_id" => $item->shk_id,	
                "retail_price_withdisc_rub"	 => $item->retail_price_withdisc_rub,
                "delivery_amount" => $item->delivery_amount,
                "return_amount"	 => $item->return_amount,
                "delivery_rub" => $item->delivery_rub,	
                "gi_box_type_name" => $item->gi_box_type_name,
                "product_discount_for_report" => $item->product_discount_for_report,
                "supplier_promo" => $item->supplier_promo,	
                "rid" => $item->rid,
                "ppvz_spp_prc" => $item->ppvz_spp_prc,
                "ppvz_kvw_prc_base" => $item->ppvz_kvw_prc_base,
                "ppvz_kvw_prc" => $item->ppvz_kvw_prc,
                "ppvz_sales_commission" => $item->ppvz_sales_commission,
                "ppvz_for_pay" => $item->ppvz_for_pay,
                "ppvz_reward" => $item->ppvz_reward,
                "acquiring_fee"	 => $item->acquiring_fee,
                "acquiring_bank" => $item->acquiring_bank,	
                "ppvz_vw" => $item->ppvz_vw,
                "ppvz_vw_nds" => $item->ppvz_vw_nds,
                "ppvz_office_id"	 => $item->ppvz_office_id,
                "ppvz_office_name"	 => isset($item->ppvz_office_name) ? $item->ppvz_office_name : "",
                "ppvz_supplier_id" => $item->ppvz_supplier_id,
                "ppvz_supplier_name" => $item->ppvz_supplier_name,	
                "ppvz_inn" => $item->ppvz_inn,
                "declaration_number" => $item->declaration_number,	
                "bonus_type_name" => isset($item->bonus_type_name) ? $item->bonus_type_name : "",	
                "sticker_id" => $item->sticker_id,	
                "site_country" => $item->site_country,	
                "penalty"	 => $item->penalty,
                "additional_payment" => $item->additional_payment,
                "kiz" => isset($item->kiz) ? $item->kiz : "",	
                "srid" => $item->srid,	
            ]);
        }

        return "Код 200: Обновление базы данных 'realizations' прошло успешно";
    }

    public function updateSales(){
        $dateFrom = $dateFrom = date("Y-01-01");
        $url = "https://statistics-api.wildberries.ru/api/v1/supplier/sales?dateFrom=$dateFrom";

        $context = $this->getContext();

        $result = json_decode(file_get_contents($url, false, $context));

        // Предварительное очищение бд перед заполнением
        Sale::truncate();

        foreach($result as $item){
            Sale::create([
                "srid" => $item->srid,
                "date" => $item->date,
                "lastChangeDate" => $item->lastChangeDate,
                "supplierArticle" => $item->supplierArticle,
                "techSize" => $item->techSize,
                "barcode" => $item->barcode,
                "totalPrice" => $item->totalPrice,
                "discountPercent" => $item->discountPercent,
                "isSupply" => $item->isSupply,
                "isRealization" => $item->isRealization,
                "promoCodeDiscount" => $item->promoCodeDiscount,
                "warehouseName" => $item->warehouseName,
                "countryName" => $item->countryName,
                "oblastOkrugName" => $item->oblastOkrugName,
                "regionName" => $item->regionName,
                "incomeID" => $item->incomeID,
                "saleID" => $item->saleID,
                "odid" => $item->odid,
                "spp" => $item->spp,
                "forPay" => $item->forPay,
                "finishedPrice" => $item->finishedPrice,
                "priceWithDisc" => $item->priceWithDisc,
                "nmId" => $item->nmId,
                "subject" => $item->subject,
                "category" => $item->category,
                "brand" => $item->brand,
                "IsStorno" => $item->IsStorno,
                "gNumber" => $item->gNumber,
                "sticker" => $item->sticker,
                "isRefund" => $item->totalPrice < 0 ? true : false,
            ]);
        }
        
        return "Код 200: Обновление базы данных 'sales' прошло успешно";
    }

    public function updateOrders(Request $request){
        $dateFrom = date("Y-01-01");
        $url = "https://statistics-api.wildberries.ru/api/v1/supplier/orders?dateFrom=$dateFrom";

        $context = $this->getContext();

        $result = json_decode(file_get_contents($url, false, $context));

        Order::truncate();

        foreach($result as $item){
            Order::create([
                "date" => $item->date,
                "lastChangeDate" => $item->lastChangeDate,
                "supplierArticle" => $item->supplierArticle,
                "techSize" => $item->techSize,
                "barcode" => $item->barcode,
                "totalPrice" => $item->totalPrice,
                "discountPercent" => $item->discountPercent,
                "warehouseName" => $item->warehouseName,
                "oblast" => $item->oblast,
                "incomeID" => $item->incomeID,
                "odid" => $item->odid,
                "nmId" => $item->nmId,
                "subject" => $item->subject,
                "category" => $item->category,
                "brand" => $item->brand,
                "isCancel" => $item->isCancel,
                "cancel_dt" => $item->cancel_dt,
                "gNumber" => $item->gNumber,
                "sticker" => $item->sticker,
                "srid" => $item->srid,
                'link' => "https://www.wildberries.ru/catalog/$item->nmId/detail.aspx",
                'PriceWithDisc' => $item->totalPrice - ($item->totalPrice * ($item->discountPercent / 100)),
            ]);
        }

        return "Код 200: Обновление базы данных 'orders' прошло успешно";
    }

    public function updateTotals(){
        set_time_limit(0);

        $orders = Order::all();

        Total::truncate();

        $orders = Order::chunk(100, function($orders){
            foreach($orders as $order) { 
                $realization = Realization::where('srid',$order->srid)->get();

                
                $check = $this->mergeRealizations($realization);

                $realization = $check;
                

                // dd($realization[0]->order_dt);

                $sale = Sale::where('srid',$order->srid)->first();

                Total::create([
                    "gNumber" => $order->gNumber,
                    "srid" => $order->srid,
                    "barcode" => $order->barcode,
                    "PriceWithDisc" => $order->priceWithDisc,
                    "dateOrder" => $dateOrder = !empty($realization->order_dt) ? $realization->order_dt : null,
                    "isCancel" => $isCancel = $order->isCancel,
                    "cancel_dt" => $order->cancel_dt,
                    "nmId" => $order->nmId,
                    "supplierArticle" => $order->supplierArticle,
                    "dateSale" => $dateSale = !empty($realization->sale_dt) ? $realization->sale_dt : null,
                    "retail_price_withdisc_rub" => $retailPrice = !empty($realization->retail_price_withdisc_rub) ? $realization->retail_price_withdisc_rub : 0,
                    "retail_amount" => $retail_amount = !empty($realization->retail_amount) ? $realization->retail_amount : 0,
                    "ppvz_for_pay" => $ppvz_for_pay = !empty($realization->ppvz_for_pay) ? $realization->ppvz_for_pay : 0,
                    "logistics" => $logistics = !empty($realization->delivery_amount) || !empty($realization->return_amount) ?  $realization->delivery_rub : (!empty($realization->product_discount_for_report) ? $realization->product_discount_for_report : null),
                    "logisticsRefund" => $logisticsRefund = !empty($realization->return_amount) ? $realization->delivery_rub : 0,
                    "penalty" => $penalty = !empty($realization->penalty) ? $realization->penalty : null,
                    "surcharge" => $surcharge = !empty($realization->additional_payment) ? $realization->additional_payment : null, 
                    "commission_wb" => $commission_wb = $retail_amount - $ppvz_for_pay,
                    "costPrice" => $costPrice = CostPrice::where('article_wb',$order->nmId)->value('costPrice') ? CostPrice::where('article_wb',$order->nmId)->value('costPrice') : null,
                    "advert_budget" => $advert = AdvertInfo::where('nmId',$order->nmId)->value('dailyBudget') ? AdvertInfo::where('nmId',$order->nmId)->value('dailyBudget') : 0, // доделать 
                    "count_orders" => count($orders->where('supplierArticle',$order->supplierArticle)),
                    "spo" => 0, // доделать 
                    "marginality_rub" => $marginality_rub = $retail_amount - $logistics - $logisticsRefund - $penalty - $surcharge - $commission_wb - $costPrice, // проверить на отсутствие retail_amount
                    "marginality_percent" => $retail_amount > 0 ? ($marginality_rub / $retail_amount) * 100 : 0,
                    "days_on_the_road" => ((strtotime($dateSale) - strtotime($dateOrder)) / 86400) > 0 ? ((strtotime($dateSale) - strtotime($dateOrder)) / 86400) : 0,
                    "status" => $status = $this->getStatus($logisticsRefund, $isCancel),
                    "orders_things" => !empty($order->srid) ? 1 : 0,
                    "buyout_rub" => $status == "Выкуплен" ? $retailPrice : 0,
                    "buyout_things" => $status == "Выкуплен" ? 1 : 0,
                    "refuse_rub" => $status == "Выкуплен" ? $order->priceWithDisc : 0,
                    "refuse_things" => $status == "Выкуплен" ? 0 : 1,
                    "refund_rub" => $status == "Выкуплен" ? $order->priceWithDisc : 0,
                    "refund_things" => $status == "Выкуплен" ? 0 : 1,
                    "inTransit_rub" => $status == "Выкуплен" ? $order->priceWithDisc : 0,
                    "inTransit_things" => $status == "Выкуплен" ? 1 : 0,
                    "category" => $order->category,
                    "subject" => $order->subject,
                    "storage" => $order->warehouseName,
                    "SPP_rub" => $spp_rub = $retailPrice - $retail_amount,
                    "SPP_percent" => $retailPrice > 0 ? 100 * ($spp_rub / $retailPrice) : 0,
                    "countryName" => !empty($sale->countryName) ? $sale->countryName : null,
                    "oblastOkrugName" => !empty($sale->oblastOkrugName) ? $sale->oblastOkrugName : null,
                    "regionName" => !empty($sale->regionName) ? $sale->regionName : null,
                    "brand" => !empty($sale->brand) ? $sale->brand : null,
                    "avg_days_buyout" => 0, // доделать 
                    "quantity" => Storage::where('supplierArticle',$order->supplierArticle)->where('warehouseName',$order->warehouseName)->sum('quantity'),
                  ]); 
                }   
        });
    }

    public function updateAdvert(){
        set_time_limit(0);
        $url = "https://advert-api.wb.ru/adv/v0/adverts";
        $context = $this->getContext();

        $list_rk = json_decode(file_get_contents($url, false, $context));

        AdvertInfo::truncate();

        foreach($list_rk as $item){
            $id = $item->advertId;
            $url = "https://advert-api.wb.ru/adv/v0/advert?id=$id";     
            $result = json_decode(file_get_contents($url, false, $context));

            // dd($result);

            AdvertInfo::create([
                "advertId" => $result->advertId,
                "name" => $result->name,
                "type" => $result->type,
                "status" => $result->status,
                "dailyBudget" => $result->dailyBudget,
                "createTime" => $result->createTime,
                "changeTime" => $result->changeTime,
                "startTime" => $result->startTime,
                "endTime" => $result->endTime,
                "begin" => isset($result->params[0]->intervals[0]->begin) ? $result->params[0]->intervals[0]->begin : null,
                "end" => isset($result->params[0]->intervals[0]->end) ? $result->params[0]->intervals[0]->end : null,
                "price" => isset($result->params[0]->price) ? $result->params[0]->price : null,
                "subjectId" => isset($result->params[0]->subjectId) ? $result->params[0]->subjectId : null,
                "subjectName" => isset($result->params[0]->subjectName) ? $result->params[0]->subjectName : "",
                "nmId" => isset($result->params[0]->nms[0]->nm) ? $result->params[0]->nms[0]->nm : null,
                "isActive" => isset($result->params[0]->active) ? $result->params[0]->active : null,
            ]);
        }

        dd($result);
    }
}
