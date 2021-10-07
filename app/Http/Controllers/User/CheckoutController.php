<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\FeeShip;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use App\Models\Product;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use Cart;
use Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\URL;

class CheckoutController extends Controller
{
    public function checkout()
    {
        if (session()->has('user_id')) {
            $tinh_thanh_pho = Province::all();
            $user = User::find(Session::get('user_id'));
            $xaid = "";
            $maqh = "";
            $matp = "";
            if ($user->xaid != 0 | $user->maqh != 0 | $user->matp != 0) {
                $xaid = $user->xaid;
                $maqh = $user->maqh;
                $matp = $user->matp;
            }
            //var_dump($tinh_thanh_pho);
            return view(
                'frontend.pages.checkout',
                [
                    'tinh_thanh_pho' => $tinh_thanh_pho,
                    'xaid' => $xaid,
                    'maqh' => $maqh,
                    'matp' => $matp,
                    'user' => $user,
                ]
            );
        } else {
            return redirect('dang-nhap');
        }
    }
    public function quan_huyen($id)
    {
        $quan_huyen = District::where('matp', $id)->get();
        echo "<option disabled selected>-- Quận/huyện --</option>";
        foreach ($quan_huyen as $qh) {
            echo "<option value='" . $qh->maqh . "'>" . $qh->name_quanhuyen . "</option>";
        }
        //var_dump($quan_huyen);
    }
    public function xa_phuong($id)
    {
        $xa_phuong_thi_tran = Ward::where('maqh', $id)->get();
        echo "<option disabled selected>-- Xã/Phường/Thị trấn --</option>";
        foreach ($xa_phuong_thi_tran as $x) {
            echo "<option value='" . $x->xaid . "'>" . $x->name_xaphuong . "</option>";
        }
    }
    public function confirm_shipping(Request $request)
    {
        $fee = "";
        //user co thong tin
        $province = $request->matp_available;
        $district = $request->maqh_available;
        $wards = $request->xaid_available;
        $this->validate(
            $request,
            [
                'name' => 'required',
                'phone' => 'required',
                'payment' => 'required',
            ],
            [
                'name.required' => 'Bạn phải nhập họ tên',
                'phone.required' => 'Bạn phải nhập số điện thoại',
                'payment.required' => 'Bạn phải chọn phương thức thanh toán',
            ]
        );

        //validate TH thay doi thong tin
        if ($request->xaid | $request->maqh | $request->matp) {
            $this->validate(
                $request,
                [

                    'matp' => 'required',
                    'maqh' => 'required',
                    'xaid' => 'required',
                ],
                [

                    'matp.required' => 'Bạn phải chọn tỉnh/thành phố',
                    'maqh.required' => 'Bạn phải chọn quận/huyện',
                    'xaid.required' => 'Bạn phải chọn xã/phường/thị trấn',

                ]
            );
            //echo "co";
            $fee = FeeShip::where('fee_matp', $request->matp)->where('fee_maqh', $request->maqh)->where('fee_xaid', $request->xaid)->first();
            //user khong co thong tin
            $province = $request->matp;
            $district = $request->maqh;
            $wards = $request->xaid;
        }

        //validate TH ko co thong tin
        if (!$request->xaid_available | !$request->maqh_available | !$request->matp_available) {
            $this->validate(
                $request,
                [

                    'matp' => 'required',
                    'maqh' => 'required',
                    'xaid' => 'required',
                ],
                [

                    'matp.required' => 'Bạn phải chọn tỉnh/thành phố',
                    'maqh.required' => 'Bạn phải chọn quận/huyện',
                    'xaid.required' => 'Bạn phải chọn xã/phường/thị trấn',

                ]
            );
        }

        $fee = FeeShip::where('fee_matp', $request->matp_available)->where('fee_maqh', $request->maqh_available)->where('fee_xaid', $request->xaid_available)->first();
        //tinh tien ship
        if ($fee) {
            $fee_ship = $fee->fee_feeship;
            $money = (int)(implode('', explode(',', Cart::subtotal()))) + $fee_ship;
        } else {
            $fee_ship = (int)20000;
            $money = (int)(implode('', explode(',', Cart::subtotal()))) + $fee_ship;
        }

        //tinh tien coupon
        $money = $money - session('number_discount');


        $payment_method = $request->payment;
        $name = $request->name;
        $phone = $request->phone;
        $coupon = session('number_discount');
        return view(
            'frontend.pages.review_payment',
            [
                'fee_ship' => $fee_ship,
                'money' => $money,
                'coupon' => $coupon,
                'payment_method' => $payment_method,
                'note' => $request->note,
                //'product'=>$product,
                'province' => $province,
                'district' => $district,

                'wards' => $wards,
                'name' => $name,
                'phone' => $phone,

            ]
        );
    }
    public function buying(Request $request)
    {
        $code = Str::random(10);

        //lay dia chi giao hang
        $province_id = $request->province;
        $province = Province::where('matp', $province_id)->first();

        $district_id = $request->district;
        $district = District::where('maqh', $district_id)->first();
        $wards_id = $request->wards;
        $wards = Ward::where('xaid', $wards_id)->first();

        //new shipping
        $shipping = new Shipping;
        $shipping->shipping_name = $request->name;
        $shipping->shipping_phone = $request->phone;
        $shipping->shipping_address = $wards->name_xaphuong . ", " . $district->name_quanhuyen . ", " . $province->name_city;
        $shipping->shipping_notes = $request->note;
        $shipping->shipping_method = $request->payment_method;
        $shipping->save();


        //new order
        $shipping_id = $shipping->id;
        $order = new Order;
        $order->user_id = Session::get('user_id');
        $order->order_total = $request->money;
        $order->order_feeship = $request->fee_ship;
        $order->order_status = "Đang xử lí";
        $order->order_code = $code;
        $order->shipping_id = $shipping_id;
        $order->order_payment = $request->payment;
        $order->order_coupon = $request->coupon;
        $order->order_note = "";
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->save();

        //new order_details
        foreach (Cart::content() as $c) {
            $order_details = new OrderDetail;
            $order_details->product_id = $c->id;
            // $order_details->product_name=$c->name;
            $order_details->product_sales_quantity = $c->qty;
            $order_details->product_price = $c->price;
            // $order_details->product_image=$c->options['image'];       
            $order_details->order_id = $order->id;
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $order_details->created_at = now();
            $order_details->updated_at = now();
            $order_details->save();
            $product = Product::where('id', $c->id)->first();
            $product->product_qty = $product->product_qty - $c->qty;
            $product->save();
        }
        //mail
        $user = Session::get('user');
        $email = $user->user_email;
        Mail::to($email)->send(new OrderMail($order));


        Cart::destroy();
        Session::forget('coupon');
        Session::forget('number_discount');
        return redirect('/');
    }
    public function view_order()
    {
        $user_id = Session::get('user_id');
        $order = Order::where('user_id', $user_id)->orderByDesc('id')->get();
        return view(
            'frontend.pages.view_order',
            [
                'order' => $order
            ]
        );
    }

    public function cancelOrder(Request $request)
    {
        $id = $request->id;
        $order = Order::find($id);
        $order->order_status = "Hủy";
        $order->order_note = $request->order_note;
        foreach ($order->orderDetails as $od) {
            $product_id = $od->product_id;
            $qty = $od->product_sales_quantity;
            $product = Product::find($product_id);
            $product->product_qty = $product->product_qty + $qty;
            $product->save();
        }

        $order->save();
        return $order->order_code;
    }
}
