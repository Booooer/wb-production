<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Storage;

class Daily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:update';

    protected $api = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6ImZjNGUyZDNmLWVkZDgtNDRhZi05YjNlLTlkZGM0YzhiMDRjNCJ9.2ykXlcgfHf7t7ecLo1alJa3dn-K_NiIWFSHkeXkr-vg";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command update table storage in database';

    /**
     * Execute the console command.
     *
     * @return int
     */

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

    public function handle()
    {    
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
}
