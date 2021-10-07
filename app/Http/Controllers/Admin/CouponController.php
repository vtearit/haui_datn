<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupon = Coupon::where('status', 1)->get();
        return view('admin.pages.coupon.display')->with(compact('coupon'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.coupon.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'time' => 'required',
                'code' => 'required|unique:coupon,coupon_code',
                'number' => 'required',
                'condition' => 'required',
            ],
            [

                'name.required' => 'Tên mã giảm giá không được để trống',
                'time.required' => 'Số lần sử dụng không được để trống',
                'code.required' => 'Mã giảm giá không được để trống',
                'number.required' => 'Số tiền|Số phần trăm không được để trống',
                'condition.required' => 'Điều kiện không được để trống',
                'code.unique' => 'Mã giảm giá đã tồn tại',
            ]
        );
        $coupon = new Coupon;
        $coupon->coupon_name = $request->name;
        $coupon->coupon_code = $request->code;
        $coupon->coupon_number = $request->number;
        $coupon->coupon_condition = $request->condition;
        $coupon->coupon_time = $request->time;
        $coupon->user_id = 0;

        $coupon->save();
        return redirect('admin/ma-giam-gia/them')->with('thongbao', 'Thêm mã giảm giá thành công');
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
        $coupon = Coupon::find($id);
        return view('admin.pages.coupon.edit')->with(compact('coupon'));
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
        $coupon = Coupon::find($id);
        if ($coupon->coupon_code != $request->code) {
            $this->validate(
                $request,
                [
                    'code' => 'unique:coupon,coupon_code',

                ],
                [

                    'code.unique' => 'Mã giảm giá đã tồn tại',
                ]
            );
        }
        $this->validate(
            $request,
            [
                'name' => 'required',
                'time' => 'required',
                'code' => 'required',
                'number' => 'required',
                'condition' => 'required',
            ],
            [

                'name.required' => 'Tên mã giảm giá không được để trống',
                'time.required' => 'Số lần sử dụng không được để trống',
                'code.required' => 'Mã giảm giá không được để trống',
                'number.required' => 'Số tiền|Số phần trăm không được để trống',
                'condition.required' => 'Điều kiện không được để trống',
            ]
        );

        $coupon->coupon_name = $request->name;
        $coupon->coupon_code = $request->code;
        $coupon->coupon_number = $request->number;
        $coupon->coupon_condition = $request->condition;
        $coupon->coupon_time = $request->time;

        $coupon->save();
        return redirect('admin/ma-giam-gia/sua/' . $id)->with('thongbao', 'Cập nhật mã giảm giá thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        $thongbao = "Ẩn mã giảm giá " . $coupon->coupon_code . " thành công";
        $coupon->status = 0;
        $coupon->save();
        $coupon = Coupon::where('status', 1)->get();
        return view('admin.pages.coupon.display')->with(compact('coupon', 'thongbao'));
    }
}
