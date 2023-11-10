<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\ApiTrait;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class apiProductController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        return $this->apiResponse($product, 200, 'جميع المنتجات');
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
            'product_name' => 'required|max:255',
            'section_id' => 'required|exists:sections,id',

        ], [
            'product_name.required' => 'يجب ادخال اسم المنتج',
            'product_name.max' => 'اسم المنتج كبير جدا',
            'section_id.required' => 'ادخل اسم القسم',
            'section_id.exists' => 'القسم غير موجود ',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(), 400);
        }

        $section = Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id

        ]);

        session()->flash('Add', 'تم أضافه المنتج بنجاح');

        return $this->apiResponse($section, 200, 'تم اضافه منتج');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        return $this->apiResponse($product, 200, 'طلب ناجح');
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
            'section_id' => 'required | exists:sections,id'
        ], [
            'section_id.required' => 'يجب ادخال القسم',
            'section_id.exists' => 'القسم غير موجود',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(), 404, 'تاكد من القسم');
        }

        $Product = Product::find($id);
        $Product->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' =>  $request->section_id,
        ]);
        session()->flash('Add', 'تم التعديل بنجاح');
        return $this->apiResponse($Product, 200, 'تم التعديل بنجتح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        session()->flash('Error', 'تم الحزف بنجاح');
        return $this->apiResponse(null, 201, 'تم حزف النتج بنجاح');
    }
}
