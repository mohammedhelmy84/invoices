<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoices;
use App\Models\Invoices_details;
use App\Models\Invoices_attachments;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use File;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = Invoices::where('id', $id)->first();

        $details = Invoices_details::where('id_invoice', $id)->get();
        $attachments = Invoices_attachments::where('invoice_id', $id)->get();

         return view('invoices.invoices_details',compact('invoice','details','attachments'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $invoices = Invoices_attachments::where('id',$request->id_file)->first();
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function open_file($invoice_number, $file_name)
    {
        $path = $invoice_number . '/' . $file_name;
        $fullPath = Storage::disk('public_uploads')->path($path);
        return response()->file($fullPath);
    }




    public function download_file($invoice_number, $file_name)
    {
        $path = $invoice_number . '/' . $file_name;
        $fullPath = Storage::disk('public_uploads')->path($path);
        return response()->download($fullPath);
    }
}
