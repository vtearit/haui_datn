<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Product;
use App\Models\Analyst;
use DB;

class PageController extends Controller
{
	public function dashboard()
	{
		$dau_thang = Now('Asia/Ho_Chi_Minh')->startOfMonth();
		$cuoi_thang = Now('Asia/Ho_Chi_Minh')->endOfMonth();
		$user = User::whereBetween('created_at', [$dau_thang, $cuoi_thang])->get();
		$order = Order::whereBetween('created_at', [$dau_thang, $cuoi_thang])->where('order_status', 'Đã giao')->get();
		$order_total = Order::whereBetween('created_at', [$dau_thang, $cuoi_thang])->get();
		$cancel_order = Order::whereBetween('created_at', [$dau_thang, $cuoi_thang])->where('order_status', 'Hủy')->get();
		$month = date('m');
		//$year=date('Y');
		$new_product = count(Product::whereBetween('created_at', [$dau_thang, $cuoi_thang])->get());
		$product_sell = DB::table('order_detail')
			->select(DB::raw('sum(product_sales_quantity) as sale '))->whereBetween('created_at', [$dau_thang, $cuoi_thang])->get();
		foreach ($product_sell as $key => $value) {
			foreach ($value as $key1 => $value1) {
				$product_sell = $value1;
			}
		}
		$product_in_store = DB::table('product')
			->select(DB::raw('sum(product_qty) as sale '))->get();
		foreach ($product_in_store as $key => $value) {
			foreach ($value as $key1 => $value1) {
				$product_in_store = $value1;
			}
		}

		$most_view = Product::orderBy('product_view', 'DESC')->take(5)->get();
		$sell_product = DB::table('order_detail')->join('product', 'product.id', '=', 'order_detail.product_id')->select('product.id', 'product.product_image', 'product.product_name', DB::raw('SUM(product_sales_quantity) as total_sales'))->groupBy('product_id')->whereBetween('order_detail.created_at', [$dau_thang, $cuoi_thang])->get();
		// var_dump($sell_product);
		return view('admin.pages.dashboard')->with(compact('user', 'month', 'order', 'order_total', 'cancel_order', 'new_product', 'product_sell', 'product_in_store', 'most_view', 'sell_product'));
	}
}
