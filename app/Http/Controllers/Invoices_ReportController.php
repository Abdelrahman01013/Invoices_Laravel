<?php

namespace App\Http\Controllers;

use App\Models\Invoivices;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Invoices_ReportController extends Controller
{
    public function index()
    {
        return view('reports.invoices_report');
    }

    public function Search_invoices(Request $request)
    {
        // return $request;

        $rdio = $request->rdio;
        if ($rdio == 1) {


            if ($request->type !== "الكل" && !empty($request->start_at) && empty($request->end_at)) {
                $start_at = date($request->start_at);
                $type = $request->type;
                $invoices = Invoivices::select('*')->where('invoice_Date', '>=', $start_at)->where('Status', '=', $type)->get();

                return view('reports.invoices_report', compact('type', 'invoices', 'start_at'));
            } elseif ($request->type !== "الكل" &&  empty($request->start_at) && !empty($request->end_at)) {
                $end_at = date($request->end_at);
                $type = $request->type;
                $invoices = Invoivices::select('*')->where('invoice_Date', '<=', $end_at)->where('Status', '=', $type)->get();

                return view('reports.invoices_report', compact('type', 'invoices', 'end_at'));
            } elseif ($request->type == "الكل" && !empty($request->start_at) && empty($request->end_at)) {

                $start_at = date($request->start_at);
                $type = $request->type;
                $invoices = Invoivices::select('*')->where('invoice_Date', '>=', $start_at)->get();

                return view('reports.invoices_report', compact('type', 'invoices', 'start_at'));
            } elseif ($request->type == "الكل" && empty($request->start_at) && !empty($request->end_at)) {

                $end_at = date($request->end_at);
                $type = $request->type;
                $invoices = Invoivices::select('*')->where('invoice_Date', '<=', $end_at)->get();

                return view('reports.invoices_report', compact('type', 'invoices', 'end_at'));
            } elseif ($request->type !== "الكل" && empty($request->start_at) && empty($request->end_at)) {
                $invoices = Invoivices::select('*')->where('Status', '=', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('type', 'invoices'));
            } elseif ($request->type == "الكل" && empty($request->start_at) && empty($request->end_at)) {
                $invoices = Invoivices::select('*')->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('type', 'invoices'));
            } elseif ($request->type == "الكل" && !empty($request->start_at) && !empty($request->end_at)) {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $invoices = Invoivices::WhereBetween('invoice_Date', [$start_at, $end_at])->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('type', 'invoices', 'start_at', 'end_at'));
            } else {


                $start_at = date($request->start_at);
                $end_at = date($request->end_at);

                $invoices = Invoivices::whereBetween('invoice_Date', [$start_at, $end_at])->where('Status', '=', $request->type,)->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('type', 'invoices', 'start_at', 'end_at'));
            }
        } else {

            // $type = $request->type;
            $invoices = Invoivices::select('*')->where('invoice_number', $request->invoice_number)->get();
            return view('reports.invoices_report', compact('invoices'));
        }
    }


    public function customer_search(Request $request)
    {
        $sections = Section::all();

        return view('reports.customers_report', compact('sections'));
    }

    public function Customer(Request $request)
    {
        $validated = $request->validate(['Section' => 'required',], ['Section.required' => 'من فضلك اختار القسم',]);

        $sections = Section::all();
        if (!empty($request->start_at) && empty($request->end_at)) {
            // $validated = $request->validate(['end_at' => 'required',], ['end_at.required' => 'من فضلك ادخل فتره النهايه',]);
            $start_at = date($request->start_at);
            $details = Invoivices::select("*")->where('invoice_Date', '>=', $start_at)->where('section_id', $request->Section)->where('product', $request->product)->get();
            return view('reports.customers_report', compact('details', 'start_at', 'sections'));
        } elseif (empty($request->start_at) && !empty($request->end_at)) {
            $end_at = date($request->end_at);
            $details = Invoivices::select("*")->where('invoice_Date', '<=', $end_at)->where('section_id', $request->Section)->where('product', $request->product)->get();
            return view('reports.customers_report', compact('details', 'end_at', 'sections'));
        } elseif (empty($request->start_at) && empty($request->end_at)) {


            $details = Invoivices::select('*')->where('section_id', $request->Section)->where('product', $request->product)->get();
            return view('reports.customers_report', compact('details', 'sections'));
        } else {
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);



            $details = Invoivices::whereBetween('invoice_Date', [$start_at, $end_at])->where('section_id', $request->Section)->where('product', $request->product)->get();
            return view('reports.customers_report', compact('details', 'sections', 'start_at', 'end_at'));
        }
    }
}













// DB::select("select * from invoivices where section_id=$request->Section AND product='$request->product'");
