<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transection;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Product;

class TransectionController extends Controller
{
    //

    public function pay(Request $request)
    {

            try {

                // Add Bill Record
                $bill_id = 'B'.date('Y').rand(100, 999);
                $bill = new Bill();
                $bill->BillID = $bill_id;
                $bill->CustomerName = $request->customer_name;
                $bill->PhoneNumber = $request->customer_phone;
                $bill->save();




                foreach ($request->orders as $order) {
                    // Create a new transaction record

                    $tran_id = 'TRN'.date('YmdHis').rand(1000, 9999);

                    $transection = new Transection();
                    $transection->TranID = $tran_id;
                    $transection->TranType = 'income';
                    $transection->ProductID = $order['id'];
                    $transection->Qty = $order['Qty'];
                    $transection->Price = $order['PriceSell'];
                    $transection->Detail = $order['ProductName'];
                    $transection->save();

                    // Update Product Stock
                    $product = Product::find($order['id']);
                    if ($product) {
                        $product->Qty = $product->Qty - $order['Qty'];
                        $product->save();
                    }


                    // Add Bill Item Record
                    $billItem = new BillItem();
                    $billItem->BillID = $bill_id;
                    $billItem->ItemName = $order['ProductName'];
                    $billItem->Qty = $order['Qty'];
                    $billItem->Price = $order['PriceSell'];
                    $billItem->save();
                }


            $success = true;
            $message = "ບັນທຶກການຂາຍ ສຳເລັດ!";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
            $bill_id = null;
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'bill_id' => $bill_id,
        ], 201);
    }
}
