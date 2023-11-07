<?php

namespace App\Http\Controllers;

use App\Models\invoices_attachment;
use App\Models\invoices_detalis;
use App\Models\Invoivices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\FlareClient\Http\Exceptions\InvalidData;

class InvoicesDetalisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_detalis  $invoices_detalis
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_detalis $invoices_detalis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_detalis  $invoices_detalis
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = Invoivices::where('id', $id)->first();
        $details = invoices_detalis::where('id_Invoice', $id)->get();
        $attachments = invoices_attachment::where('invoice_id', $id)->get();




        return view("invoices.detalis", compact('invoices', 'details', 'attachments'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_detalis  $invoices_detalis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_detalis $invoices_detalis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_detalis  $invoices_detalis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {




        $invoices_num = $request->invoice_number;
        $file_name = $request->file_name;
        $file_path = public_path('Attachments/' . $invoices_num . "/" . $file_name);
        if (file_exists($file_path)) {

            unlink($file_path);
        }
        $id = $request->id_file;
        invoices_attachment::destroy($id);

        session()->flash('delete', 'تم حزف الملف بنجاح');

        return redirect()->back();
    }


    public function open_file($file_name, $file_num)

    {
        $file = public_path('Attachments/' . $file_num . "/" . $file_name);
        return response()->file($file, ['Content-Type' => 'application/pdf']);
    }

    public function download($file_name, $file_num)
    {

        return response()->download(public_path('Attachments/' . $file_num . "/" . $file_name));
    }
}
