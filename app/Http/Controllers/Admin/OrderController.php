<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\Analyst;
use Carbon\Carbon;
use PDF;
class OrderController extends Controller
{
    public function newOrder()
    {
        $new_order = Order::where('order_status', 'Đang xử lí')->paginate(5);
        return view('admin.pages.order.new_order')->with(compact('new_order'));
    }
    public function confirmOrder($id)
    {

        $order = Order::find($id);
        if ($order->order_status == "Đang xử lí") {
            $order->order_status = "Đang giao hàng";
            $order->save();
            $new_order = Order::where('order_status', 'Đang xử lí')->paginate(5);
            $order_code = $order->order_code;
            $success = 'Xác nhận đơn hàng ' . $order_code . ' thành công';
            return redirect('admin/don-hang/don-hang-moi')->with(compact('new_order', 'success'));
        } else {
            $order->order_status = "Đã giao";
            $order->save();
            $shipping_order = Order::where('order_status', 'Đang giao hàng')->paginate(5);
            $order_code = $order->order_code;
            $success = 'Xác nhận đơn hàng ' . $order_code . ' thành công';
            return redirect('admin/don-hang/don-hang-dang-giao')->with(compact('shipping_order', 'success'));
        }
    }
    public function confirmOrderPost(Request $request)
    {
        $id = $request->order_id;
        $order = Order::find($id);
        $order->order_status = "Đã xác nhận";
        $order->save();
        $new_order = Order::where('order_status', 'Đang xử lí')->get();
        echo $new_order;
    }
    public function detail($id)
    {
        $order_view = Order::find($id);
        return view('admin.pages.order.detail')->with(compact('order_view'));
    }
    public function shippingOrder()
    {
        $shipping_order = Order::where('order_status', 'Đang giao hàng')->paginate(5);
        return view('admin.pages.order.shipping')->with(compact('shipping_order'));
    }
    public function successOrder($id)
    {
        $order = Order::find($id);
        $order->order_status = "Đã giao";
        $order->save();
        $shipping_order = Order::where('order_status', 'Đang giao hàng')->paginate(5);
        $order_code = $order->order_code;
        $success = 'Xác nhận đơn hàng ' . $order_code . ' thành công';

        //tich diem user
        $user_id = $order->user->id;
        $user = User::find($user_id);
        $user->user_point += round($order->order_total / 1000000);
        $user->save();

        //analyst
        $order_date = $order->created_at->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $analyst = Analyst::where('order_date', $order_date)->first();

        //add db
        $order_detail = OrderDetail::where('order_id', $order->id)->get();
        $coupon = $order->order_coupon;
        $sales = 0;
        $profit = 0;
        foreach ($order_detail as $od) {
            $product = Product::where('id', $od->product_id)->first();
            $price = 0;
            if (isKM($product->bdkm, $product->ktkm)) {
                $price = $product->product_price_km;
            } else {
                $price = $product->product_price;
            }
            $import = $product->product_import;

            $sales += $od->product_sales_quantity * $price;
            $profit += $od->product_sales_quantity * $price - $od->product_sales_quantity * $import;
        }
        $profit = $profit - $coupon;

        //check isset
        if ($analyst) {
            $analyst->sales = $analyst->sales + $sales;
            $analyst->profit = $analyst->profit + $profit;
            $analyst->coupon = $analyst->coupon + $coupon;
            $analyst->order_qty = $analyst->order_qty + 1;
            $analyst->save();
        } else {
            $new_analyst = new Analyst;
            $new_analyst->sales = $sales;
            $new_analyst->profit = $profit;
            $new_analyst->coupon = $coupon;
            $new_analyst->order_qty = 1;
            $new_analyst->order_date = $order_date;
            $new_analyst->save();
        }
        return redirect('admin/don-hang/don-hang-dang-giao')->with(compact('shipping_order', 'success'));
    }
    public function order()
    {
        $success_order = Order::where('order_status', 'Đã giao')->paginate(5);
        return view('admin.pages.order.success')->with(compact('success_order'));
    }
    public function print($id)
    {
        $order_view = Order::find($id);
        return view('admin.pages.order.print_order')->with(compact('order_view'));
    }
    public function pdfview($id)
    {
        $order_view=Order::find($id);
        view()->share('order_view',$order_view);
        $pdf = PDF::loadView('admin.pages.order.print_order');
        $pdf->download('pdfview.pdf');
        return view('admin.pages.order.print_order');
    }

    public function inMonth()
    {
        $dau_thang = Now('Asia/Ho_Chi_Minh')->startOfMonth();
        $cuoi_thang = Now('Asia/Ho_Chi_Minh')->endOfMonth();
        $success_order = Order::whereBetween('created_at', [$dau_thang, $cuoi_thang])->where('order_status', 'Đã giao')->paginate(5);
        //var_dump($success_order);
        return view('admin.pages.order.success')->with(compact('success_order'));
    }
    public function cancelOrder()
    {
        $order = Order::where('order_status', 'Hủy')->paginate(5);
        return view('admin.pages.order.cancel_order')->with(compact('order'));
    }
    public function cancel($id, $status)
    {
        $order = Order::find($id);
        $order->order_status = "Hủy";
        $order->order_note = "Admin hủy";
        $order->save();
        foreach ($order->orderDetails as $od) {
            $product_id = $od->product_id;
            $qty = $od->product_sales_quantity;
            $product = Product::find($product_id);
            $product->product_qty = $product->product_qty + $qty;
            $product->save();
        }

        if ($status == "Đang xử lí") {
            $new_order = Order::where('order_status', 'Đang xử lí')->paginate(5);
            $success = "Hủy đơn hàng " . $order->order_code . " thành công";
            return view('admin.pages.order.new_order')->with(compact('new_order', 'success'));
        } else if ($status == "Đang giao hàng") {
            $shipping_order = Order::where('order_status', 'Đang giao hàng')->paginate(5);
            $success = "Hủy đơn hàng " . $order->order_code . " thành công";
            return view('admin.pages.order.shipping')->with(compact('shipping_order', 'success'));
        }
    }
}
