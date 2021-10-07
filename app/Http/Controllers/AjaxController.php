<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Wards;
use App\Models\Feeship;
use App\Models\OrderDetails;
use App\Models\GroupProduct;
use App\Models\Category;
use Cart;
use Session;
use DB;

class AjaxController extends Controller
{
	public function test()
	{
		return view('admin.test');
	}
	public function ajax($val)
	{
		$val_new = $val + 1;
		echo "<input id='quantity' type='text' name='quantity' value='" . $val_new . "' autocomplete='off' size='2'>";
	}
	public function session_checkout()
	{
		echo "<p id='session_checkout'>" . Session::put('checkout', 1) . "aaa</p>";
		/*if(session()->has('checkout'))
			echo("a");
		else
			echo("b");*/
	}
	public function quan_huyen($id)
	{
		$quan_huyen = District::where('matp', $id)->get();
		echo "<option disabled selected>-- Quận/huyện --</option>";
		foreach ($quan_huyen as $qh) {
			echo "<option value='" . $qh->maqh . "'>" . $qh->name_quanhuyen . "</option>";
		}
	}
	public function xa_phuong($id)
	{
		$xa_phuong_thi_tran = Wards::where('maqh', $id)->get();
		echo "<option disabled selected>-- Xã/Phường/Thị trấn --</option>";
		foreach ($xa_phuong_thi_tran as $x) {
			echo "<option value='" . $x->xaid . "'>" . $x->name_xaphuong . "</option>";
		}
	}
	public function money($matp, $maqh, $xaid)
	{
		$fee = Feeship::where('fee_matp', $matp)->where('fee_maqh', $maqh)->where('fee_xaid', $xaid)->first();
		if ($fee) {
			$fee_ship = $fee->fee_feeship;
			$money = (int)(implode('', explode(',', Cart::subtotal()))) + $fee_ship;
		} else {
			$fee_ship = (int)20000;
			$money = (int)(implode('', explode(',', Cart::subtotal()))) + $fee_ship;
		}
		//echo '<div>Phí ship: '.number_format($fee_ship=$fee->fee_feeship).' VNĐ</div>';
		//echo '<div>Thành tiền: '.number_format($money).' VNĐ</div>';

		echo '							<td colspan="4">&nbsp;</td>
							<td colspan="2">
								<table class="table table-condensed total-result">
									<tr>
										<td>Thành tiền</td>
										<td>' . Cart::subtotal() . ' VNĐ' . '</td>
									</tr>
									<tr class="shipping-cost">
										<td>Phí ship</td>
										<td>' . number_format($fee_ship) . ' VNĐ</td>										
									</tr>
									<tr>
										<td>Tổng</td>
										<td><span>' . number_format($money) . ' VNĐ' . '</span></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="submit" value="Đặt mua"/ class="btn btn-primary btn-sm"></td>
									</tr>
								</table>
							</td>
';
		//echo number_format($money)." VNĐ";

	}

	public function groupProduct($id)
	{
		$group_product = groupProduct::where('category_id', $id)->get();
		if (count($group_product) > 0) {
			foreach ($group_product as $g) {
				echo '<option value="' . $g->id . '">' . $g->group_product_name . '</option>';
			}
		} else {
			echo '<option value="0">Rỗng</option>';
		}
		dd($group_product);
		//echo "1";
	}
	// public function subCategoryDiscount($id)
	// {
	// 	$sub_category=SubCategory::where('category_id',$id)->get();
	// 	if(count($sub_category)>0)
	// 	{
	// 		$data='<select name="sub_category" id="sub_category"  class="form-control">';
	// 		foreach($sub_category as $s)
	// 		{
	// 		 	$data.='<option value="'.$s->id.'">'.$s->sub_category_name.'</option>';
	// 		}
	// 		$data.='</select>';
	// 		echo $data;
	// 	}
	// 	else
	// 	{
	// 		$data='<select name="sub_category" id="sub_category"  class="form-control">';

	// 		$data.='<option value="" disabled selected>Rỗng</option>';

	// 		$data.='</select>';
	// 		echo $data;

	// 	}
	// 	//dd($sub_category);
	// }
	// public function keyup($price)
	// {
	// 	$price=number_format((int)implode("",explode(",",$price)));
	// 	//echo '<input type="text" name="" value="'.$price.'" id="price"/>';

	// 	echo $price;
	// }


	// public function type($val)
	// {
	// 	if($val==1)
	// 	{
	// 		$category=Category::all();
	// 		$option=""
	// 		foreach($category as $c)
	// 			{
	// 				$option.='<option value="'.$c->id.'">'.$c->category_name.'</option>';
	// 			}


	// 		echo '<div class="form-group">
	//                    <label for="name">Tên danh mục</label>
	//                    <select name="category" id="category" class="form-control">
	//                    	'.$option.'
	//                    </select>
	//                	</div>';
	// 	}
	// }
}
