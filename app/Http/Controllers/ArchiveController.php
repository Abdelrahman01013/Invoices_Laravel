<?php

namespace App\Http\Controllers;

use App\Models\invoices_attachment;
use App\Models\invoices_detalis;
use Illuminate\Support\Facades\File;

use App\Models\Invoivices;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoivices::onlyTrashed()->get();

        return view('invoices.Archive', compact('invoices'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = Invoivices::withTrashed()->where('id', $id)->first();
        $details = invoices_detalis::where('id_Invoice', $id)->get();
        $attachments = invoices_attachment::where('invoice_id', $id)->get();




        return view("invoices.detalis", compact('invoices', 'details', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->invoice_id;

        $invoices = Invoivices::withTrashed()->where('id', $id)->restore();
        session()->flash('restore_invoice');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $invoices = Invoivices::withTrashed()->where('id', $request->invoice_id)->first();
        $attachmens = invoices_attachment::where('invoice_id', $request->invoice_id)->get();


        foreach ($attachmens as $attachment) {
            $filePath = "Attachments/" . $attachment->invoice_number;
            if (File::exists($filePath)) {
                File::deleteDirectory($filePath);
            }
            $invoices->forceDelete();
            session()->flash('delete_invoice');
            return redirect('/invoices');
        }
    }
}
