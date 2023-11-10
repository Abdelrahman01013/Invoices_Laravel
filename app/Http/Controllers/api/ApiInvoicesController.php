<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\invoices_attachment;
use App\Models\invoices_detalis;
use App\Models\Invoivices;
use App\Models\User;
use App\Notifications\Add_invoices_not;
use App\Notifications\AddInvoices;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Notification;


use Illuminate\Support\Facades\Validator;

class ApiInvoicesController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incoices = Invoivices::all();
        return $this->apiResponse($incoices, 200, 'تم بنجاح');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // response('this is all', 200, "تم ");
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
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required | unique:invoivices'
        ], [
            'invoice_number.required' => 'يجب ادخال رقم الفاتوره',
            'invoice_number.unique' => 'هذه الفاتوره موجوده من قبل ',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $invoice = Invoivices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = $invoice->id;

        invoices_detalis::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'total' => $request->Amount_collection,
            'user' => "Abdelrahman",
        ]);

        if ($request->hasFile('pic')) {
            $file_name = $request->pic->getClientOriginalName();

            $attachments = new invoices_attachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $request->invoice_number;
            $attachments->Created_by = "Abdelrahman";
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $request->invoice_number), $imageName);
        }

        // // $user = User::where('id', '!=', auth()->user()->id)->get();

        // $title = "تم اصافه فاتوره برقم";

        // Notification::send($user, new Add_invoices_not($invoice_id, $title));
        // Notification::send($user, new AddInvoices($invoice_id));

        return $this->apiResponse($invoice, 200, 'تم بنجاح');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = Invoivices::find($id);
        return $this->apiResponse($invoices, 200, 'تم بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'invoice_number' => ' unique:invoivices'
        ], [

            'invoice_number.unique' => 'هذه الفاتوره موجوده من قبل ',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }




        $invoices = Invoivices::findOrFail($id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        $detalis = invoices_detalis::where('id_Invoice', $id);

        $detalis->update([
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'note' => $request->note,
            'total' => $request->Amount_collection


        ]);

        $attachments = invoices_attachment::where('invoice_id', $id);
        $attachments->update([
            'invoice_number' => $request->invoice_number
        ]);



        $oldPath = public_path('Attachments/' . $request->invoice_old_number);
        $newPath = public_path('Attachments/' . $request->invoice_number);

        File::moveDirectory($oldPath, $newPath);

        // $user = User::where('id', '!=', auth()->user()->id)->get();

        // $inv_id = $request->invoice_id;
        // $title = "تم التعديل علي الفاتوره رقم";

        // Notification::send($user, new Add_invoices_not($inv_id, $title));


        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return $this->apiResponse($invoices, 200, 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoivices::find($id);
        $attachmens = invoices_attachment::where('invoice_id', $id)->get();





        foreach ($attachmens as $attachment) {
            $filePath = "Attachments/" . $attachment->invoice_number;
            if (File::exists($filePath)) {
                File::deleteDirectory($filePath);
            }
        }
        $invoice->forceDelete();

        session()->flash('delete_invoice');

        return $this->apiResponse('تم الحزف', 200, 'تم الحزف بنجاح');
    }



    public function archive($id)
    {
        $invoice = Invoivices::find($id);
        $invoice->Delete();
        session()->flash('delete_invoice');
        return $this->apiResponse($invoice, 200, 'تم النقل الي الارشيف');
    }
}
