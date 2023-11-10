<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\ApiTrait;
use App\Http\Controllers\Controller;
use App\Models\Section;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class ApiSectionController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section = Section::all();
        return $this->apiResponse($section, 200, "جميع الاقسام");
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
        $validator = Validator::make($request->all(), [
            'section_name' => 'required|unique:sections'
        ], [
            'section_name.required' => 'يجب ادخال اسم القسم',
            'section_name.unique' => 'الاسم موجود مسبقا'
        ]);


        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(), 401, 'خطا ');
        }

        $section = Section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => "Abdelrahman",


            // (auth()->user()->name),

        ]);
        session()->flash('Add', 'تم اضافة القسم بنجاح ');
        return $this->apiResponse($section, 200, 'تم أضافه القسم ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = Section::find($id);

        return $this->apiResponse($section, 200, 'تم بنجاح');
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
            'section_name' => 'unique:sections'


        ], ['section_name.unique' => 'الاسم موجدود من قبل ']);

        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(), 400, 'خطا في الاسم ');
        }

        $section = Section::find($id);

        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'تم التعديل بنجاح');

        return $this->apiResponse($section, 201, 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $section = Section::destroy($id);
        session()->flash('Add', 'تم حزف القسم بنجاح');
        return $this->apiResponse('تم الحزف ', 200, 'نجح الحزف');
    }
}
