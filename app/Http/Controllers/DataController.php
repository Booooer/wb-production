<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Storage;
use App\Models\Realization;
use App\Models\Sale;
use App\Models\Order;

class DataController extends Controller
{
    public function welcome($range = "today"){
        $data = $this->getData($range);

        $sum = 0;
        $refund = 0;

        foreach($data as $item){
            if ($item->isRefund) {
                $refund++;
            }
            else{
                $sum += $item->finishedPrice;
            }
        }

        $count = count($data) - $refund;

        return view('welcome',compact('sum','refund','count','range'));
    }

    private function getData($range){
        switch ($range) {
            case 'yesterday':
                $date = date('Y-m-d',time() - 86400);
                return Sale::where('date','like','%'.$date.'%')->get();
            
            case 'week':
                $from = date('Y-m-d',time() - (86400 * 7));
                $to = date('Y-m-d');
                return Sale::whereBetween('date',[$from,$to])->get();

            case 'month':
                $from = date('Y-m-d',time() - (86400 * 30));
                $to = date('Y-m-d');
                return Sale::whereBetween('date',[$from,$to])->get();    

            case "today":
                $date = date('Y-m-d');
                return Sale::where('date','like','%'.$date.'%')->get();
        }
    }
}
