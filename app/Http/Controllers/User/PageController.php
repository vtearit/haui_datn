<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\User;
use App\Models\Category;
use App\Models\GroupProduct;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Province;
use App\Models\Comment;
use App\Models\Thumbnail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Cart;


class PageController extends Controller
{
	public function homePage()
	{
		$category = Category::where('category_status', 1)->get();
		$slider_active = Slider::where('status', 2)->first();
		$slider = Slider::where('status', 1)->get();

		return view('frontend.pages.homepage')->with(compact('category', 'slider_active', 'slider'));
	}
	public function productPage($slug_category)
	{
		$category = Category::where('slug_category', $slug_category)->first();
		$category_id = $category->id;
		$product = GroupProduct::where('category_id', $category_id)->where('status', 1)->paginate(8);
		$name_page = $category->category_name;
		$slider_active = Slider::where('status', 2)->first();
		$slider = Slider::where('status', 1)->get();
		//var_dump($product);
		return view('frontend.pages.product')->with(compact('product', 'name_page', 'slider_active', 'slider', 'category_id'));
	}
	public function productDetails($slug_product)
	{
		$group_product = GroupProduct::where('group_product_slug', $slug_product)->first();
		$gp_id = $group_product->id;
		//var_dump($product);
		$selected_product = Product::where('group_product_id', $gp_id)->where('product_status', '>', 0)->first();

		if ($selected_product) {
			$product = Product::where('group_product_id', $gp_id)->whereNotIn('id', [$selected_product->id])->get();
			$comment = Comment::where('group_product_id', $gp_id);
			return view('frontend.pages.detail_product')->with(compact('product', 'selected_product', 'group_product', 'comment'));
		} else {
			echo "Sản phẩm rỗng";
		}
	}

	public function allProduct(Request $request)
	{
		$gp_id = $request->gp_id;
		$ram = $request->ram;
		$color = $request->color;
		$view = $this->rendView($gp_id, $ram, $color);
		echo $view;
	}

	public function changeProduct(Request $request)
	{
		$gp_id = $request->gp_id;
		$ram = $request->ram;
		$color = $request->color;
		$view = $this->rendView($gp_id, $ram, $color);
		echo $view;
	}
	public function test()
	{
		// $comment=new Comment;
		// $comment->user_id=1;
		// $comment->group_product_id=1;
		// $comment->comment="ok";
		// date_default_timezone_set('Asia/Ho_Chi_Minh');
		// $comment->created_at = now();
		// $comment->updated_at = now();
		// $comment->save();

		// $gp_id=1;
		// $ram='64GB';
		// $color='Blue';
		// $view=$this->rendView($gp_id,$ram,$color);
		// echo $view;

		// $test=minPrice(1);
		// var_dump($test);
		// $gp=GroupProduct::find(1);
		// echo $test=actionProduct($gp);
		$begin = Now('Asia/Ho_Chi_Minh')->startOfMonth();
		$end = Now('Asia/Ho_Chi_Minh')->endOfMonth();
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
	public function rendView($gp_id, $ram, $color)
	{
		$checkExitSelectedProduct = 0;
		$selected_product = DB::table('product')
			->join('configuration', 'configuration_id', '=', 'configuration.id')
			->where('product.group_product_id', $gp_id)
			->where('ram', $ram)
			->where('color', $color)
			->where('product.product_status', '<>', 0)
			->select('product.id')
			->get();
		if (count($selected_product) > 0) {
			$checkExitSelectedProduct = 1;
			foreach ($selected_product as $value)
				$selected_product_id = $value->id;
			$selected_product = Product::where('id', $selected_product_id)->where('product_status', '<>', 0)->first();

			//cong view
			$selected_product->product_view = $selected_product->product_view + 1;
			$selected_product->save();

			$product = Product::where('group_product_id', $gp_id)->get();
			$thumbnail = Thumbnail::where('product_id', $selected_product->id)->get();
			$thumb = "";
			if (count($thumbnail) > 2) {
				$thumb_foreach = "";
				foreach ($thumbnail as $t)
					$thumb_foreach .= '<img width="100px" src="img/thumbnail/' . $t->link . '" alt="">';
				$thumb = '<div id="similar-product" class="carousel slide" data-ride="carousel">
						<!-- Wrapper for slides -->
						<div class="carousel-inner">
							<div class="item active">
								<img width="80px" src="img/thumbnail/' . $selected_product->product_image . '" alt="">
								' . $thumb_foreach . '
							</div>
							<div class="item">' . $thumb_foreach . '
								
							</div>
							
						</div>

						<!-- Controls -->
						<a class="left item-control" href="#similar-product" data-slide="prev">
						<i class="fa fa-angle-left"></i>
						</a>
						<a class="right item-control" href="#similar-product" data-slide="next">
						<i class="fa fa-angle-right"></i>
						</a>
	  				</div>';
			}


			$btn_add_cart = "";
			$tinh_trang = '';
			$mau_sac = '';
			$ram = '';
			if ($selected_product->product_qty > 0)
				$btn_add_cart = '<button type="button" class="btn btn-default cart add-to-cart" name="add-to-cart"><i class="fa fa-shopping-cart"></i>
												Thêm giỏ hàng</button>';
			if ($selected_product->product_qty == 0)
				$tinh_trang = 'Hết hàng';
			else
				$tinh_trang = 'Còn hàng';
			$color = DB::table('product')
				->join('configuration', 'configuration_id', '=', 'configuration.id')
				->where('product.group_product_id', $gp_id)
				->select('color')
				->distinct()
				->get();
			foreach ($color as $c) {
				$isCheck = "";
				if ($c->color == $selected_product->configuration->color) {
					$isCheck = "checked";
				}
				$mau_sac .= '<input type="radio" class="btn-check color" value="' . $c->color . '" name="color" autocomplete="off" ' . $isCheck . '>
						<label class="btn btn-secondary" for="option2">' . $c->color . '</label>';
			}
			$ramDB = DB::table('product')
				->join('configuration', 'configuration_id', '=', 'configuration.id')
				->where('product.group_product_id', $gp_id)
				->select('ram')
				->distinct()
				->get();
			foreach ($ramDB as $r) {
				$isCheck = "";
				if ($r->ram == $selected_product->configuration->ram) {
					$isCheck = "checked";
				}
				$ram .= '<input type="radio" class="btn-check ram" id="ram" name="ram" value="' . $r->ram . '" autocomplete="off" ' . $isCheck . '>
						<label class="btn btn-secondary" for="option2">' . $r->ram . '</label>';
			}
			$comment = "";
			if (Session::has('user')) {
				$comment = '<div class="row bootstrap snippets bootdeys">
						<div class="col-sm-12">
							<div class="comment-wrapper">
								<div class="panel panel-info">
									
									<div class="panel-body">
										<form>
										<input type="hidden" name="_token" value="' . csrf_token() . '" />
										<textarea class="form-control comment" name="comment" placeholder="bình luận..." rows="3"></textarea>
										<br>
										<input type="hidden" name="gp_id" value="' . $gp_id . '" class="gp_id"/>
										<button type="button" class="btn btn-info pull-right post-comment">Đăng</button>
										</form> 
									</div>
								</div>
							</div>
						</div>

					</div>';
			}
			//check display discount 
			$percent = 0;
			$html_percent = "";
			if (isKM($selected_product->bdkm, $selected_product->ktkm)) {
				$percent = 100 - (round($selected_product->product_price_km / $selected_product->product_price * 100));
			}
			if ($percent != 0) {
				$html_percent = '<div class="action-product-homepage">Giảm ' . $percent . ' %</div>';
			}
			//check km
			$price = "";
			$price_input_form = "";
			if (isKM($selected_product->bdkm, $selected_product->ktkm)) {
				$price = "		                     
			<strike style='color:red'>" . number_format($selected_product->product_price) . ' VNĐ' . "</strike>
			<br/>
			<span>" . number_format($selected_product->product_price_km) . ' VNĐ' . "</span>";
				$price_input_form = '<input type="hidden" value="' . $selected_product->product_price_km . '" class="product_price">';
			} else {
				$price = "<span>" . number_format($selected_product->product_price) . ' VNĐ' . "</span>";
				$price_input_form = '<input type="hidden" value="' . $selected_product->product_price . '" class="product_price">';
			}
			//related product

			$group_product = GroupProduct::find($gp_id);
			$category = Category::find($group_product->category_id);
			$related_product_for = GroupProduct::where('category_id', $category->id)->where('status', 1)->whereNotIn('id', [$gp_id])->take(3)->get();
			$related_product = "";
			foreach ($related_product_for as $rp) {
				//check display discount related
				$discount_r = discount($rp);
				$html_percent_r = '';
				if ($discount_r < 0) {
					$html_percent_r = '<div class="action-product">' . $discount_r . ' %</div>';
				}
				$related_product .= '<div class="col-sm-4">
			<div class="product-image-wrapper">
				<div class="single-products">
					<div class="productinfo text-center">
						<a href="chi-tiet/' . $rp->group_product_slug . '">
						<img src="img/product/' . $rp->group_product_image . '" alt="" />
						<h2>' . number_format(minPrice($rp->id)) . ' VNĐ' . '</h2>
						<p>' . $rp->group_product_name . '</p>
						</a>
					</div>
					' . $html_percent_r . '
				</div>
			</div>
			</div>';
			}




			$view = '	<div class="product-details">
						<form>
							<input type="hidden" name="_token" value="' . csrf_token() . '" /> 
							<input type="hidden" name="gp_id" value="' . $gp_id . '"/>
							<input type="hidden" name="ram" value="' . $selected_product->configuration->ram . '"/>
							<input type="hidden" name="color" value="' . $selected_product->configuration->color . '"/>
								
						</form>

						<div class="col-sm-5">
							<div class="view-product">
								<img src="img/product/' . $selected_product->product_image . '" alt="" />
								' . $html_percent . '
							</div>
							' . $thumb . '
						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								

								<h2>' . $selected_product->product_name . '</h2>
								<p>Mã sản phẩm: ' . $selected_product->id . '</p>
								<span>
									<form>
									<input type="hidden" name="_token" value="' . csrf_token() . '" />
									<input type="hidden" value="' . $selected_product->id . '" class="product_id">
									<input type="hidden" value="' . $selected_product->product_name . '" class="product_name">
									<input type="hidden" value="' . $selected_product->product_image . '" class="product_image">
									' . $price_input_form . '
									' . $price . '
									<label>Số lượng:</label>
									<input name="quantity" class="product_qty" type="number" min="1"  value="1" />
											' . $btn_add_cart . '
									</form>
								</span>
								<p><b>Tình trạng:</b>
									' . $tinh_trang . '
								</p>
								<p><b>Trạng thái:</b> Mới</p>
								<form>
								<input type="hidden" name="_token" value="' . csrf_token() . '" /> 
								<input type="hidden" name="gp_id" value="' . $gp_id . '"/>
								<input type="hidden" name="ram" value="' . $selected_product->configuration->ram . '"/>
								<input type="hidden" name="color" value="' . $selected_product->configuration->color . '"/>
								<p><b>Màu sắc:</b>
									' . $mau_sac . '
								</p>
								<p><b>Mã hàng:</b>
									' . $ram . '
								</p>
								</form>
								
								<h3>Thông tin chi tiết</h3>
								<h2 class="st-pd-contentTitle" style="margin-right: 0px; margin-bottom: 24px; margin-left: 0px; padding: 0px; border: 0px; font-size: 20px; vertical-align: baseline; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; font-family: Roboto, sans-serif; color: rgb(33, 37, 41); line-height: 28px; text-align: center;">
    <table id="st-pd-table">
        <tbody>
            <tr id="st-pd-table-ob">
                <td id="st-pd-table-td-1">Mã sản phẩm</td>
                <td id="st-pd-table-td-2"><span  id="st-pd-table-ib">' . $selected_product->configuration->screen . '</span></td>
            </tr>
            <tr  id="st-pd-table-ib">
                <td id="st-pd-table-td-1">Kích thức</td>
                <td id="st-pd-table-td-2"><span  id="st-pd-table-ib">' . $selected_product->configuration->rear_camera . '</span></td></tr>
            <tr id="st-pd-table-ob">
                <td id="st-pd-table-td-1">Chiều cao</td>
                <td id="st-pd-table-td-2"><span  id="st-pd-table-ib">' . $selected_product->configuration->camera_selfie . '</span></td>
            </tr>
            <tr  id="st-pd-table-ib">
                <td id="st-pd-table-td-1">Mã hàng&nbsp;</td>
                <td id="st-pd-table-td-2"><span  id="st-pd-table-ib">' . $selected_product->configuration->ram . '</span></td>
            </tr>
            <tr  id="st-pd-table-ob">
                <td id="st-pd-table-td-1">Khối lượng</td>
                <td id="st-pd-table-td-2"><span  id="st-pd-table-ib">' . $selected_product->configuration->memory . '</span></td>
            </tr>
            <tr  id="st-pd-table-ib">
                <td id="st-pd-table-td-1">Thành phần</td>
                <td id="st-pd-table-td-2"><span  id="st-pd-table-ib">' . $selected_product->configuration->cpu . '</span></td>
            </tr>
            <tr  id="st-pd-table-ob">
                <td id="st-pd-table-td-1">Chứng nhận</td>
                <td id="st-pd-table-td-2"><span  id="st-pd-table-ib">' . $selected_product->configuration->gpu . '</span></td>
            </tr>
            <tr  id="st-pd-table-ib">
                <td id="st-pd-table-td-1">Tác dụng phụ</td>
                <td id="st-pd-table-td-2"><span  id="st-pd-table-ib">' . $selected_product->configuration->battery_capacity . '</span></td>
            </tr>
            <tr  id="st-pd-table-ob">
                <td id="st-pd-table-td-1">Thông tin thêm</td>
                <td id="st-pd-table-td-2"><span  id="st-pd-table-ib">' . $selected_product->configuration->sim . '</span></td>
            </tr>
            <tr  id="st-pd-table-ib">
                <td id="st-pd-table-td-1">Nhà cung cấp</td>
                <td id="st-pd-table-td-2"><span  id="st-pd-table-ib">' . $selected_product->configuration->os . '</span></td>
            </tr>
            <tr  id="st-pd-table-ob"><td id="st-pd-table-td-1">Xuất xứ</td>
                <td id="st-pd-table-td-2"><span  id="st-pd-table-ib">' . $selected_product->configuration->origin . '</span></td>
            </tr>
            <tr  id="st-pd-table-ib">
                <td id="st-pd-table-td-1">Ngày sản xuất</td>
                <td id="st-pd-table-td-2"><span  id="st-pd-table-ib">' . $selected_product->configuration->launch_time . '</span></td>
            </tr>
        </tbody>
    </table>
</h2>
								
							</div>
							
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#comment" data-toggle="tab">Comment</a></li>
								<li ><a href="#review" data-toggle="tab">Review sản phẩm</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="comment" >' . $comment . '
								<div id="loadComment"></div>
							</div>
							
							<div class="tab-pane fade" id="review" >
								' . $group_product->group_product_review . '
							</div>
						</div>
					</div>
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">	
									' . $related_product . '
								</div>
								<div class="item">	
									' . $related_product . '
									
								</div>
								
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->';
		} else
			$view = 0;

		return $view;
	}

	public function allComment(Request $request)
	{
		$comment = Comment::where('group_product_id', $request->id)->orderBy('created_at', 'DESC')->get();
		// $paginate="";
		// if ($comment->lastPage() > 1)
		// {
		// 	$page="";
		// 	for ($i = 1; $i <= $comment->lastPage(); $i++)
		// 	{
		// 		$page.='<li class="'. ($comment->currentPage() == $i) ? ' active' : '' .'">
		// 					<a href="'.$comment->url($i) .'">'.$i .'</a>
		// 				</li>';		
		// 	}

		// 	$paginate='<ul class="pagination">
		// 				<li class="'.($comment->currentPage() == 1) ? ' disabled' : '' .'">
		// 					<a href="'.$comment->url(1) .'">Trước</a>
		// 				</li>
		// 				'.
		// 				$page
		// 				.'
		// 				<li class="'.($comment->currentPage() == $comment->lastPage()) ? ' disabled' : '' .'">
		// 					<a href="'. $comment->url($comment->currentPage()+1) .'" >Sau</a>
		// 				</li>
		// 			</ul>';
		// }


		foreach ($comment as $cm) {
			$img = "";
			$action = "";

			//check anh dai dien
			if ($cm->user->user_avatar != "") {
				$img = '<img class="img-circle img-sm" src="img/avatar/' . $cm->user->user_avatar . '" width="30px" height="30px" alt=""/>';
			} else {
				$img = '<img class="img-circle img-sm" src="img/avatar/user.jpg" width="30px" height="30px" alt=""/>';
			}

			//check quyen sua xoa
			if ($cm->user_id == Session::get('user_id')) {
				$action = '<a type="button" class="btn btn-link cm_update" data-id_cm="' . $cm->id . '" >Sửa</a> 
				<a type="button" class="btn btn-link cm_delete" data-id_cm="' . $cm->id . '" >Xóa</a>';
			}
			echo '<div class="media">
                    <a class="pull-left" href="#">' . $img . '</a>
                    <div class="media-body">
                        <h4 class="media-heading" style="color:red">' . $cm->user->user_name . '
                            <small><i class="fas fa-clock">' . $cm->created_at . '</i></small>
                        </h4>
                        <div id="' . $cm->id . '">
							<form>
								<p>' . $cm->comment . '</p>
								<input type="hidden" name="_token" value="' . csrf_token() . '" /> 
								' . $action . '
							</form>
						</div>
                                    
                    </div>
					
						
                  </div> ';
		}
	}

	public function postComment(Request $request)
	{
		$comment = new Comment;
		$comment->user_id = Session::get('user_id');
		$comment->group_product_id = $request->gp_id;
		$comment->comment = $request->comment;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$comment->created_at = now();
		$comment->updated_at = now();
		$comment->save();
	}
	public function editComment(Request $request)
	{
		$cm = Comment::find($request->id);
		echo '<div id="' . $cm->id . '">
				<form>
						<input type="text" class="btn btn-light comment_edit" value="' . $cm->comment . '"/>
						<input type="hidden" name="_token" value="' . csrf_token() . '" /> 
						<button type="button" class="btn btn-success cm_update" data-id_cm="' . $cm->id . '" >Bình luận</button>
						<button type="button" class="btn btn-danger cm_cancel">Hủy</button>  
				</form>
			</div>';
	}
	public function commitComment(Request $request)
	{
		$comment = Comment::find($request->id);
		if ($comment->user_id == Session::get('user_id')) {
			$comment->comment = $request->comment;
			$comment->updated_at = now();
			$comment->save();
		}
	}
	public function deleteComment(Request $request)
	{
		$comment = Comment::find($request->id);
		if ($comment->user_id == Session::get('user_id')) {
			$comment->delete();
		}
	}

	public function sort(Request $request)
	{
		$id = $request->category_id;
		$category = Category::where('id', $id)->first();
		$category_id = $category->id;
		$product = "";
		$val = $request->sort;
		if ($val == 1) {
			$product = DB::table('group_product')
				->join('product', 'group_product.id', '=', 'product.group_product_id')
				->join('category', 'category.id', '=', 'group_product.category_id')
				->select('group_product.*')
				->where('group_product.category_id', $id)
				->where('group_product.status', 1)
				->orderBy('product_price', 'asc')
				->distinct()
				->get();
			// var_dump($product);
			// die();
			// $product=GroupProduct::where('category_id',$id)->where('status',1)->orderBy('group_product_min_price','ASC')->paginate(100);

		} else if ($val == 0) {
			$product = GroupProduct::where('category_id', $id)->where('status', 1)->orderBy('created_at', 'DESC')->paginate(100);
		} else if ($val == 2) {
			$product = DB::table('group_product')
				->join('product', 'group_product.id', '=', 'product.group_product_id')
				->join('category', 'category.id', '=', 'group_product.category_id')
				->select('group_product.*')
				->where('group_product.category_id', $id)
				->where('group_product.status', 1)
				->orderBy('product_price', 'desc')
				->distinct()
				->get();
			// $product=GroupProduct::where('category_id',$id)->where('status',1)->orderBy('group_product_min_price','DESC')->paginate(100);
		}
		$name_page = $category->category_name;
		$slider_active = Slider::where('status', 2)->first();
		$slider = Slider::where('status', 1)->get();

		return view('frontend.pages.sort')->with(compact('product', 'name_page', 'slider_active', 'slider', 'category_id'));
	}
	public function search(Request $request)
	{
		$search = $request->search;

		$product = GroupProduct::where('group_product_name', 'like', '%' . $search . '%')->where('status', 1)->paginate(8);
		$slider_active = Slider::where('status', 2)->first();
		$slider = Slider::where('status', 1)->get();
		return view(
			'frontend.pages.search',
			[
				'product' => $product,
				'name_page' => 'Sản phẩm liên quan đến từ khóa ' . $search,
				'slider_active' => $slider_active,
				'slider' => $slider,
			]
		);
	}



	// function minPrice($gp_id)
	// {
	// 	$group_product=GroupProduct::finf($)
	// }
}
