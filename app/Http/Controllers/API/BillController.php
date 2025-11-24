<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\BillItem;

class BillController extends Controller
{
    //
    public function printBill($bill_id)
    {
        $bill = Bill::where('BillID', $bill_id)->first();
        $billItems = BillItem::where('BillID', $bill_id)->get();

        return view('bill', compact('bill', 'billItems'));

    }
}
