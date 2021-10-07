<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Province;
use Illuminate\Support\Str;
use Cart;

class CouponController extends Controller
{
    public function getPoint()
    {
        $id = Session::get('user_id');
        $user = User::find($id);
        return view('frontend.pages.getPoint')->with(compact('user'));
    }
    public function postPoint(Request $request)
    {
        //tinh diem
        $user = User::find(Session::get('user_id'));
        if ($user->user_point < $request->coupon) {
            $error = "Điểm tích lũy của bạn không đủ để đổi thưởng";
            return view('frontend.pages.getPoint')->with(compact('user', 'error'));
        } else {
            $user->user_point -= $request->coupon;
            $user->save();

            //tao ma
            $coupon = new Coupon;
            $coupon->coupon_name = "voucher";
            $coupon->coupon_code = Str::random(10);;
            $coupon->coupon_number = $request->coupon * 10000;
            $coupon->coupon_condition = 2;
            $coupon->coupon_time = 1;
            $coupon->user_id = Session::get('user_id');
            $coupon->status = 1;
            $coupon->save();
            $success = "Đổi mã giảm giá thành công!Vui lòng lấy mã giảm giá trong danh mục";
            return view('frontend.pages.getPoint')->with(compact('user', 'success'));
        }
    }

    public function yourCoupon()
    {
        $id = Session::get('user_id');
        $user = User::find($id);
        $coupon = Coupon::where('user_id', $id)->where('coupon_time', '>', 0)->get();
        return view('frontend.pages.your_coupon')->with(compact('user', 'coupon'));
    }
    public function allCoupon()
    {

        $coupon = Coupon::where('user_id', 0)->where('coupon_time', '>', 0)->get();
        return view('frontend.pages.all_coupon')->with(compact('coupon'));
    }

    public function check(Request $request)
    {
        $coupon_code = $request->coupon_code;
        $discount = 0;
        $number_discount = 0;
        //echo $coupon_code;
        $coupon_db = Coupon::where('coupon_code', $coupon_code)->where('coupon_time', '>', 0)->where('status', 1)->first();
        if (!$coupon_db) {
            return redirect('/gio-hang')->with('coupon_err', 'Mã giảm giá không hợp lệ');
        } else {
            $coupon = Session::get('coupon');

            if (!$coupon) {
                Session::put('number_discount', $number_discount);
                $discount = $this->checkType($coupon_db);
                $coupon[] = array(
                    '0' => array(
                        'coupon_code' => $coupon_db->coupon_code,
                        'coupon_condition' => $coupon_db->coupon_condition,
                        'coupon_number' => $discount,
                    )


                );
                Session::put('coupon', $coupon);

                foreach ($coupon as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $number_discount += $value1['coupon_number'];
                    }
                }

                //check discount lon hon tong don hang
                if ($number_discount > (int)(implode('', explode(',', Cart::subtotal())))) {
                    $number_discount = (int)(implode('', explode(',', Cart::subtotal())));
                }
                Session::put('number_discount', $number_discount);
                return redirect('gio-hang')->with('message', 'Thêm mã giảm giá thành công');
            } else {
                $check = 0;
                foreach ($coupon as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        if ($value1['coupon_code'] == $coupon_code) {
                            $check = 1;
                            break;
                        }
                    }
                }
                if ($check == 1) {
                    return redirect('gio-hang')->with('coupon_err', 'Mã giảm giá trùng');
                } else {
                    $count = count(Session::get('coupon'));
                    $discount = $this->checkType($coupon_db);
                    $add_coupon = array(
                        $count => array(
                            'coupon_code' => $coupon_db->coupon_code,
                            'coupon_condition' => $coupon_db->coupon_condition,
                            'coupon_number' => $discount,
                        )
                    );
                    array_push($coupon, $add_coupon);
                    Session::put('coupon', $coupon);

                    foreach ($coupon as $key => $value) {
                        foreach ($value as $key1 => $value1) {
                            $number_discount += $value1['coupon_number'];
                        }
                    }
                    //check discount lon hon tong don hang
                    if ($number_discount > (int)(implode('', explode(',', Cart::subtotal())))) {
                        $number_discount = (int)(implode('', explode(',', Cart::subtotal())));
                    }
                    Session::put('number_discount', $number_discount);
                    return redirect('gio-hang')->with('message', 'Thêm mã giảm giá thành công');
                }
            }
        }
    }

    public function checkType($coupon_db)
    {
        $coupon_db->coupon_time = $coupon_db->coupon_time - 1;
        $coupon_db->save();
        if ($coupon_db->coupon_condition == 1) {
            $discount = (int)((int)(implode('', explode(',', Cart::subtotal()))) / ($coupon_db->coupon_number));
        } else if ($coupon_db->coupon_condition == 2) {
            $discount = $coupon_db->coupon_number;
        }
        return $discount;
    }
    public function cancel($id)
    {
        $coupon = session('coupon');
        $number_discount = session('number_discount');
        $number = 0;
        $coupon_code = "";
        foreach ($coupon as $key => $value) {
            foreach ($value as $key1 => $value1) {
                if ($key1 == $id) {
                    $number = $value1['coupon_number'];
                    $coupon_code = $value1['coupon_code'];
                }
            }
        }
        $number_discount = $number_discount - $number;
        Session::put('number_discount', $number_discount);
        unset($coupon[$id]);
        Session::put('coupon', $coupon);

        $coupon_db = Coupon::where('coupon_code', $coupon_code)->first();
        $coupon_db->coupon_time = $coupon_db->coupon_time + 1;
        $coupon_db->save();
        return redirect('gio-hang')->with('message', 'Hủy mã giảm giá thành công');
    }
}
