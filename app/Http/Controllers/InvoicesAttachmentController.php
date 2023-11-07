<?php

namespace App\Http\Controllers;

use App\Models\invoices_attachment;
use Illuminate\Http\Request;

class InvoicesAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request, [
            'file_name' => 'mimes:png,jpg,pdf,jpeg'
        ], [
            'file_name.mimes' => 'png,jpg,pdf,jpeg يجب ان يكون  الصيغه '
        ]);


        $file = $request->file_name;


        $file_name = time() . '.' . $file->getClientOriginalName();

        $upload = $file->move('Attachments/' . $request->invoice_number . "/", $file_name);
        if ($upload) {
            invoices_attachment::create([
                'file_name' => $file_name,
                'invoice_number' => $request->invoice_number,
                'Created_by' => auth()->user()->name,
                'invoice_id' => $request->invoice_id
            ]);
            session()->flash('Add', 'تم اضافه المرفق');

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_attachment  $invoices_attachment
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_attachment  $invoices_attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_attachment  $invoices_attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_attachment  $invoices_attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices_attachment $invoices_attachment)
    {
        //
    }
}
