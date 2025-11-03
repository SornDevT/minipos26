<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    //
    protected $fillable = [
        'BillID',
        'ItemName',
        'Qty',
        'Price',
    ];
}
