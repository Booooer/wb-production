<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;

    protected $table = 'storage';

    protected $fillable = [
        'nmId', 'lastChangeDate', 'supplierArticle', 'techSize',
                'barcode',
                'quantity',
                'isSupply',
                'isRealization',
                'quantityFull',
                'warehouseName',
                'subject',
                'category',
                'daysOnSite',
                'brand',
                'SCCode',
                'Price',
                'Discount',
    ];
}
