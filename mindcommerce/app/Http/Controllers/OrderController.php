<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public static function clearOrders(){
        echo "Running clearOrders";
        $newTime = strtotime('-15 minutes');
        $now = date("Y-m-d H:i:s", $newTime);
      
        $orders = Order::where("created_at", "<=", $now)->where("status", "PU")->get();
        echo($orders);
        foreach ($orders as $order) {
            $order->status="D";
            $order->save();
            
        }
        return true;
    }
}
