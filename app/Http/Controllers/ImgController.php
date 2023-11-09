<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ImgController extends Controller
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
        $request->validate([
            'img' => 'mimes:png,jpg,jpeg,gif'
        ], [
            'img.mimes' => 'يجب ان تكون الصوره  png , Jpg , jpeg , gif'
        ]);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $file->move('assets/img/profile', $file_name);

            $old_img_path = 'assets/img/profile/' . auth()->user()->img;
            if (file_exists($old_img_path) && is_file($old_img_path)) {

                unlink($old_img_path);
            }



            $user = User::find(auth()->user()->id);
            $user->img = $file_name;
            $user->save();

            return back();
        } else {
            return back();;
        }
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
