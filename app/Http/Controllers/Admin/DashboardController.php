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

class DashboardController extends Controller
{
  public function filter(Request $request)
  {
    $analyst = Analyst::whereBetween('order_date', [$request->begin, $request->end])->get();
    foreach ($analyst as $key => $val) {
      $chart[] = array(
        'date' => $val->order_date,
        'order_qty' => $val->order_qty,
        'sales' => $val->sales,
        'coupon' => $val->coupon,
        'profit' => $val->profit
      );
    }
    // foreach ($analyst as $key => $val) {
    //     $chart[]=array(
    //         'year' => $val->order_date,
    //         'value' => $val->order_qty);
    // }
    return json_encode($chart);
    //echo $chart;
  }
  public function filterMonth(Request $request)
  {
    $dau_thang = Now('Asia/Ho_Chi_Minh')->startOfMonth();
    $cuoi_thang = Now('Asia/Ho_Chi_Minh')->endOfMonth();
    $analyst = Analyst::whereBetween('order_date', [$dau_thang, $cuoi_thang])->get();
    foreach ($analyst as $key => $val) {
      $chart[] = array(
        'date' => $val->order_date,
        'order_qty' => $val->order_qty,
        'sales' => $val->sales,
        'coupon' => $val->coupon,
        'profit' => $val->profit
      );
    }
    // foreach ($analyst as $key => $val) {
    //     $chart[]=array(
    //         'year' => $val->order_date,
    //         'value' => $val->order_qty);
    // }
    return json_encode($chart);
    //echo $chart;
  }

  public function box(Request $request)
  {
    $begin = $request->begin;
    $end = $request->end;
    $user = User::whereBetween('created_at', [$begin, $end])->get();
    $order = Order::whereBetween('created_at', [$begin, $end])->where('order_status', 'Đã giao')->get();
    $order_total = Order::whereBetween('created_at', [$begin, $end])->get();
    $cancel_order = Order::whereBetween('created_at', [$begin, $end])->where('order_status', 'Hủy')->get();
    echo '
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <p>' . $begin . ' - ' . $end . '</p>
                <h3>' . count($order) . '</h3>
                <p>Đơn đặt hàng hoàn thành</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <p>' . $begin . ' - ' . $end . '</p>
                <h3>' . count($order_total) . '</h3>
                <p>Tổng đơn hàng</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <p>' . $begin . ' - ' . $end . '</p>
                <h3>' . count($user) . '</h3>
                <p>Khách hàng mới</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <p>' . $begin . ' - ' . $end . '</p>
                <h3>' . count($cancel_order) . '</h3>
                <p>Đơn hàng hủy</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
          
       ';
  }
  public function sellProduct(Request $request)
  {
    $begin = $request->begin;
    $end = $request->end;
    $sell_product = DB::table('order_detail')->join('product', 'product.id', '=', 'order_detail.product_id')->select('product.id', 'product.product_image', 'product.product_name', DB::raw('SUM(product_sales_quantity) as total_sales'))->groupBy('product_id')->whereBetween('order_detail.created_at', [$begin, $end])->get();
    $product = "";
    foreach ($sell_product as $sp)
      $product .= '<tr>
                  <td>' . $sp->id . '</td>
                  <td><img width="50px" height="50px" src="img/product/' . $sp->product_image . '" alt=""></td>
                  <td>' . $sp->product_name . '</td>
                  <td>' . $sp->total_sales . '</td>
                </tr>';
    echo '<div class="card-body pad table-responsive filter-sell-product">
              <h5>Sản phẩm đã bán trong từ ' . $begin . ' đến ' . $end . '</h5>
              <table class="table table-bordered  text-center">
                <tr>
                  <th>ID</th>
                  <th>Ảnh</th>
                  <th>Tên sản phẩm</th>
                  <th>Số lượng bán</th>
                </tr>
                ' . $product . '
              </table>
        </div>';
  }
}
