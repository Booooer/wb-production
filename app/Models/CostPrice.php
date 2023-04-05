<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_wb',
        'costPrice',
        'article',
        'brand'
    ];
}
