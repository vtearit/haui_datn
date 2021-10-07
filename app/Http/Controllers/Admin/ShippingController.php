<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeeShip;
use App\Models\Province;
class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fee = FeeShip::all();
        return view('admin.pages.ship.display')->with(compact('fee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tinh_thanh_pho = Province::all();
        return view('admin.pages.ship.add')->with(compact('tinh_thanh_pho'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fee = new FeeShip;
        $fee->fee_xaid = $request->xaid;
        $fee->fee_maqh = $request->maqh;
        $fee->fee_matp = $request->matp;
        $fee->fee_feeship = $request->fee;
        $fee->save();
        $thongbao = 'Thêm thành công';
        return redirect('admin/danh-muc/them')->with(compact('thongbao'));
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
       $fee = FeeShip::find($id);
       return view('admin.pages.ship.edit')->with(compact('fee'));
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
        $fee = FeeShip::find($id);
        $fee->fee_feeship = $request->fee;
        $fee->save();
        $thongbao = 'Sửa thành công';
        return redirect('admin/ship/sua/'.$id)->with(compact('thongbao'));
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
