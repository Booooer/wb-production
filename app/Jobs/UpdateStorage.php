<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Storage;

class UpdateStorage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $api; 
    private $url;
    private $dateFrom;
    private $context;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dateFrom = date('Y-m-d', time() - 86400);

        $this->api = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6ImZjNGUyZDNmLWVkZDgtNDRhZi05YjNlLTlkZGM0YzhiMDRjNCJ9.2ykXlcgfHf7t7ecLo1alJa3dn-K_NiIWFSHkeXkr-vg";
        $this->url = "https://statistics-api.wildberries.ru/api/v1/supplier/stocks?dateFrom=$dateFrom";

        $this->context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'accept: application/json',
                    'content-type: application/json',
                    "Authorization: $this->api",
                ]
            ]
        ]);

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = json_decode(file_get_contents($this->url, false, $this->context));

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
    }
}
