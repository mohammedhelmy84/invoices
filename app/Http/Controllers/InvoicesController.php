<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Invoices_details;
use App\Models\Invoices_attachments;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $invoices=Invoices::all();
         return view("invoices.invoices",compact('invoices'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections=Section::all();
        return view("invoices.add_invoice",compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            // 'invoice_number' => 'required',
            // 'invoice_date' => 'required',
            // 'due_date' => 'required',
            // 'product' => 'required',
            // 'section_id' => 'required',
            // 'amount_collection' => 'required',
            // 'amount_Commission' => 'required',
            // 'discount' => 'required',
            // 'value_vat' => 'required',
            // 'rate_vat' => 'required',
            // 'total' => 'required',

        ]);

        $auth=Auth::id();


        Invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);



        $invoice_id = Invoices::latest()->first()->id;
        Invoices_details::create([
            'id_invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user_id' => $auth,
        ]);



        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new Invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->created_by = $auth;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();


            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        return back();

    }

    /**
     * Display the specified resource.
     */
    public function show(Invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $sections = Section::get();
        $invoice = Invoices::where('id',$id)->first();
        $attachment = Invoices_attachments::where('id',$invoice->id)->first();

        return view('invoices.edit_invoice',compact('invoice','sections','attachment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
         $invoice = Invoices::findOrFail($request->id);
        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);

        session()->flash("edit","تم التعديل بنجاح");
        return back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $invoice = Invoices::findOrFail($request->invoice_id);
        $attachments = Invoices_attachments::where('id ','11')->get();
        dd($attachments->id);
        // $invoice->forceDelete();
        // $invoice->Delete();
        // return redirect('/invoices')->with('delete_invoice','تم الحذف بنجاح');
    }

    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }

}
