<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;


class invoiceController extends Controller
{
    //invoice index

    public function index(){

        return view('invoice.index');
    }
}
