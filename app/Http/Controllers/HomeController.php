<?php

namespace App\Http\Controllers;

use App\Models\Invoivices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Invoivices::count();
        $count_v1 = Invoivices::where('Value_Status', 1)->count();
        $count_v2 = Invoivices::where('Value_Status', 2)->count();
        $count_v3 = Invoivices::where('Value_Status', 3)->count();

        if ($count != 0) {

            $N1 = number_format($count_v1 / $count  * 100, 1);
            $N2 = number_format($count_v2 / $count  * 100, 1);
            $N3 = number_format($count_v3 / $count  * 100, 1);
        } else {
            $N1 = 0;
            $N2 = 0;
            $N3 = 0;
        }








        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير المدفوعه جزئيا', 'الفواتير المدفوعه', 'الفواتير الغير مدفوعه', 'احمالي الفواتير'])
            ->datasets([
                [
                    "label" => "",
                    'backgroundColor' => ['rgb(255, 163 , 60)', 'green', ' rgba(255, 99, 132, 0.9)', 'blue'],
                    'data' =>  [$N3, $N1, $N2, 100]
                ],

            ])
            ->options([]);




        return view('dashboard', compact('chartjs', 'N1', 'N2', 'N3'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
