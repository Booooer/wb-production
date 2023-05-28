<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertInfo extends Model
{
    use HasFactory;

    protected $table = "adverts";
    
    protected $fillable = [
        "advertId",
        "name",
        "type",
        "status",
        "dailyBudget",
        "createTime",
        "changeTime",
        "startTime",
        "endTime",
        "begin",
        "end",
        "price",
        "subjectId",
        "subjectName",
        "nmId",
        "isActive",
    ];

    public function order(){
        return $this->belongsTo('App\Models\Order');
    }
}
