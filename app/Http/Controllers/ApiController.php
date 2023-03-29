<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Storage;
use App\Models\Realization;
use App\Models\Sale;

class ApiController extends Controller
{
    private function getContext($api){
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'accept: application/json',
                    'content-type: application/json',
                    "Authorization: $api"
                ]
            ]
        ];

        return stream_context_create($options);
    }
    

    public function updateStorage(Request $request){
        $api = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6ImZjNGUyZDNmLWVkZDgtNDRhZi05YjNlLTlkZGM0YzhiMDRjNCJ9.2ykXlcgfHf7t7ecLo1alJa3dn-K_NiIWFSHkeXkr-vg";
        $dateFrom = $request->dateFrom ? $request->dateFrom : date('Y-m-d', time() - 86400);
        $url = "https://statistics-api.wildberries.ru/api/v1/supplier/stocks?dateFrom=$dateFrom";

        $context = $this->getContext($api);

        $result = json_decode(file_get_contents($url, false, $context));

        // Предварительное очищение бд перед заполнением
        Storage::truncate();

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
        s
        return "Код 200: Обновление базы данных 'storage' прошло успешно";
    }
        
    public function updateRealizations(Request $request){

        $api = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6ImZjNGUyZDNmLWVkZDgtNDRhZi05YjNlLTlkZGM0YzhiMDRjNCJ9.2ykXlcgfHf7t7ecLo1alJa3dn-K_NiIWFSHkeXkr-vg";
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;
        $url = "https://statistics-api.wildberries.ru/api/v1/supplier/reportDetailByPeriod?dateFrom=$dateFrom&dateTo=$dateTo";

        

        $context = $this->getContext($api);

        $result = json_decode(file_get_contents($url, false, $context));
        
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
                "brand_name" => $item->brand_name,	
                "sa_name" => $item->sa_name,	
                "ts_name" => $item->ts_name,
                "barcode" => $item->barcode,
                "doc_type_name"	 => $item->doc_type_name,
                "quantity"	 => $item->quantity,
                "retail_price" => $item->retail_price,
                "retail_amount"	 => $item->retail_amount,
                "sale_percent"	 => $item->sale_percent,
                "commission_percent" => $item->commission_percent,
                "office_name" => $item->office_name,
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

    public function updateSales(Request $request){
        $api = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6ImZjNGUyZDNmLWVkZDgtNDRhZi05YjNlLTlkZGM0YzhiMDRjNCJ9.2ykXlcgfHf7t7ecLo1alJa3dn-K_NiIWFSHkeXkr-vg";
        $dateFrom = $request->dateFrom;
        $url = "https://statistics-api.wildberries.ru/api/v1/supplier/sales?dateFrom=$dateFrom";

        $context = $this->getContext($api);

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
            ]);
        }
        
        return "Код 200: Обновление базы данных 'sales' прошло успешно";
    }

    public function updateOrders(Request $request){
        return "Этот метод ещё в разработке";
    }
}
