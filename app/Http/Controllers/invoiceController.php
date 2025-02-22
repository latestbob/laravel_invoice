<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Cloudinary\Cloudinary;


class invoiceController extends Controller
{
    //invoice index

    public function index(){

        $invoices = Invoice::all();

        return view('invoice.index', compact("invoices"));
    }

    //store invoice


    public function store(Request $request){
        
        $request->validate([
            'customer_name' => 'required',
            'due_date' => 'required',
            'grand_total' => 'required',
            'items' => 'required',
            'status' => 'required',

            'file' => 'nullable|mimes:jpeg,png,jpg,gif,pdf,xlsx,xls|max:102400',
           

        ]);

       

        $uploadedUrl = '';
        if($request->hasFile('file')){
            
         
            $cloudinary = new Cloudinary();


            $uploadedFile = $cloudinary->uploadApi()->upload(
                $request->file('file')->getRealPath(),
                ['resource_type' => 'auto']
            );
            $uploadedUrl = $uploadedFile['secure_url'];

            // dd($uploadedUrl);
        }

        $invoice_number = rand(100000, 999999);

        $invoice = new Invoice();
        $invoice->invoice_number = $invoice_number;
        $invoice->customer_name = $request->customer_name;
        $invoice->due_date = $request->due_date;
        $invoice->grand_total = $request->grand_total;
        $invoice->items =  json_decode($request->items, true);
        $invoice->status = $request->status;
        $invoice->uploadUrl = $uploadedUrl;

        $invoice->save();

        return redirect()->route('invoice.index')->with('success', 'Invoice created successfully');
    }


    //show invoice

    public function show($invoice_number){

        $invoice = Invoice::where('invoice_number', $invoice_number)->first();

        return view('invoice.show', compact('invoice'));
    }


    //edit invoice

    public function edit($invoice_number){

        $invoice = Invoice::where('invoice_number', $invoice_number)->first();

        return view('invoice.edit', compact('invoice'));
    }

    //update invoice

    public function update(Request $request, $invoice_number){

        $request->validate([
            'customer_name' => 'required',
            'grand_total' => 'required',
            'items' => 'required',
            'status' => 'required',

            'file' => 'nullable|mimes:jpeg,png,jpg,gif,pdf,xlsx,xls|max:102400',
           

        ]);

        //  dd(json_decode($request->items, true));


        $uploadedUrl = '';
        if($request->hasFile('file')){
            
         
            $cloudinary = new Cloudinary();


            $uploadedFile = $cloudinary->uploadApi()->upload(
                $request->file('file')->getRealPath(),
                ['resource_type' => 'auto']
            );
            $uploadedUrl = $uploadedFile['secure_url'];

            // dd($uploadedUrl);
        }

        $invoice = Invoice::where("invoice_number",$invoice_number)->first();

        $invoice->customer_name = $request->customer_name;
        $invoice->grand_total = $request->grand_total;
        $invoice->items =  json_decode($request->items, true);
        $invoice->status = $request->status;
        if ($uploadedUrl) {
            $invoice->uploadUrl = $uploadedUrl;
        }

        $invoice->save();

        


        return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully');



    }


    //delete invoice

    public function destroy(Request $request, $id){
        $invoice = Invoice::find($id)->delete();

        return back()->with('success', 'Invoice deleted successfully');
    }
}