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

    public function index()
    {

        $perPage = \Request::get('perPage', 10);
        $sort = \Request::get('sort', 'asc');
        $search = \Request::get('search', '');
        $month_type = \Request::get('month_type', 'm');
        $dmy = \Request::get('dmy', null);


        $query = Transection::query();

        if (!empty($search)) {
            // search multiple columns
            $query->where(function($q) use ($search) {
                $q->where('TranID', 'like', '%' . $search . '%')
                  ->orWhere('TranType', 'like', '%' . $search . '%')
                  ->orWhere('Detail', 'like', '%' . $search . '%')
                  ->orWhere('Price', 'like', '%' . $search . '%');
            });
        }

        $month = explode('-', $dmy)[1];
        $year = explode('-', $dmy)[0];

        if($month_type == "m"){

            $query->whereMonth('created_at', $month)
                  ->whereYear('created_at', $year);

        } else if($month_type == "y"){

            $query->whereYear('created_at', $year);

        } 
        

        $transections = $query->orderBy('created_at', $sort)->paginate($perPage);

        return response()->json($transections, 200);
    }


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
                    $transection->Price = $order['PriceSell']*$order['Qty'];
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
