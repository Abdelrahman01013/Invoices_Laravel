<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use Illuminate\Support\Facades\File;


use App\Models\invoices_attachment;
use App\Models\invoices_detalis;
use App\Models\Invoivices;
use App\Models\Product;
use App\Models\Section;
use App\Models\User;
use App\Notifications\Add_invoices_not;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Notifications\AddInvoices;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;

class InvoivicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $invoices = Invoivices::all();
        $sections = Section::all();



        return view('invoices.invoices', compact('invoices', 'sections',));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();

        return view('invoices.add_invoices', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required | unique:invoivices'
        ], [
            'invoice_number.required' => 'يجب ادخال رقم الفاتوره',
            'invoice_number.unique' => 'هذه الفاتوره موجوده من قبل ',

        ]);


        Invoivices::create([
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
        $invoice_id = Invoivices::latest()->first()->id;

        invoices_detalis::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'total' => $request->Amount_collection,
            'user' => (auth()->user()->name),
        ]);


        if ($request->hasFile('pic')) {


            $invoice_id = Invoivices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = (auth()->user()->name);
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

        $inv_id = Invoivices::latest()->first()->id;
        $user = User::where('id', '!=', auth()->user()->id)->get();

        $title = "تم اصافه فاتوره برقم";

        Notification::send($user, new Add_invoices_not($inv_id, $title));
        // $user->notify(new AddInvoices($request->invoice_id));
        Notification::send($user, new AddInvoices($inv_id));







        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');

        return redirect()->route('invoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoivices  $invoivices
     * @return \Illuminate\Http\Response
     */
    public function show(Invoivices $invoivices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoivices  $invoivices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = Invoivices::find($id);
        $sections = Section::all();

        return view('invoices.edit_invoce', compact('invoices', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoivices  $invoivices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoices = Invoivices::findOrFail($request->invoice_id);
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

        $detalis = invoices_detalis::where('id_Invoice', $request->invoice_id);

        $detalis->update([
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'note' => $request->note,
            'totla' => $request->Amount_collection


        ]);

        $attachments = invoices_attachment::where('invoice_id', $request->invoice_id);
        $attachments->update([
            'invoice_number' => $request->invoice_number
        ]);



        $oldPath = public_path('Attachments/' . $request->invoice_old_number);
        $newPath = public_path('Attachments/' . $request->invoice_number);

        File::moveDirectory($oldPath, $newPath);

        $user = User::where('id', '!=', auth()->user()->id)->get();

        $inv_id = $request->invoice_id;
        $title = "تم التعديل علي الفاتوره رقم";

        Notification::send($user, new Add_invoices_not($inv_id, $title));


        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoivices  $invoivices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $id = $request->invoice_id;
        $id_page = $request->id_page;
        $invoice = Invoivices::find($id);
        $attachmens = invoices_attachment::where('invoice_id', $id)->get();

        if (!$id_page == 2) {
            foreach ($attachmens as $attachment) {
                $filePath = "Attachments/" . $attachment->invoice_number;
                if (File::exists($filePath)) {
                    File::deleteDirectory($filePath);
                }
            }
            $invoice->forceDelete();

            session()->flash('delete_invoice');

            return redirect('/invoices');
        } else {
            $invoice->Delete();
            session()->flash('delete_invoice');
            return redirect()->back();
        }
    }
    public function getProductsBySection(Request $request)
    {
        $sectionId = $request->input('section_id');
        $products = Product::where('section_id', $sectionId)->get();


        return response()->json($products);
    }

    public function Status(Request $request)
    {
        $id = $request->id;
        $invoices = Invoivices::find($id);

        return view('invoices.status_update', compact('invoices'));
    }

    public function Status_Update(Request $request)
    {

        $invoice = Invoivices::find($request->invoice_id);
        $detalis = invoices_detalis::where('id_Invoice', $request->invoice_id);

        if ($request->Status === 'مدفوعة') {
            $invoice->update([
                'Status' => $request->Status,
                'Value_Status' => 1,
                'Payment_Date' => $request->Payment_Date,
                'Amount_collection' => 0



            ]);
            $detalis->create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'Payment_Date' => $request->Payment_Date,
                'note' => $request->note,
                'user' => (auth()->user()->name),
                'total' => 0
            ]);
        } else {
            $Paid_Amount = $request->Paid_Amount;
            $mount = $request->Amount_collection;

            if ($Paid_Amount == null) {
                $Paid_Amount == 0;
            }

            $total = $mount - $Paid_Amount;

            $invoice->update([
                'Status' => $request->Status,
                'Value_Status' => 3,
                'Payment_Date' => $request->Payment_Date,
                'Amount_collection' => $total,
            ]);
            $detalis->create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'Payment_Date' => $request->Payment_Date,
                'note' => $request->note,
                'user' => (auth()->user()->name),
                'total' => $total
            ]);
        }


        session()->flash('Status_Update');
        return redirect('/invoices');
    }

    public function show_invoices_status($id)
    {
        $status = 3;
        $status_view = "الفواتير المدفوعه جزئيا";



        if ($id == 1) {
            $status = 1;
            $status_view = "الفواتير المدفوعه";
        } elseif ($id == 2) {
            $status_view = "الفواتير الغير مدفوعه";
            $status = 2;
        }

        $invoices = Invoivices::Where('Value_Status', $status)->get();
        $sections = Section::all();


        return view('invoices.invoices', compact('invoices', 'sections', 'status_view'));
    }

    public function Print_invoice($id)
    {
        $invoices = Invoivices::find($id);
        return view('invoices.print_invoices', compact('invoices'));
    }


    public function export()
    {

        return Excel::download(new InvoicesExport, 'Invoices.xlsx');
    }

    public function read_all(Request $request)
    {
        $not = auth()->user()->unreadNotifications;

        if ($not) {
            $not->markAsRead();
            return back();
        }
    }
}
