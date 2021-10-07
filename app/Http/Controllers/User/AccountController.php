<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Province;
use Illuminate\Support\Str;


class AccountController extends Controller
{
	public function account()
	{
		$id = Session::get('user_id');
		$user = User::find($id);


		return view('frontend.pages.profile')->with(compact('user'));
	}
	public function logout()
	{
		Session::forget('user_id');
		Session::forget('user_name');
		Session::forget('checkout');
		return redirect('/');
	}
	public function editProfile()
	{
		$id = Session::get('user_id');
		$user = User::find($id);
		$tp = Province::all();
		$address = "";
		if ($user->xaid != 0 && $user->maqh != 0 && $user->matp != 0) {
			$address = $user->xa->name_xaphuong . ' - ' . $user->qh->name_quanhuyen . ' - ' . $user->tp->name_city;
		}

		return view('frontend.pages.edit_profile')->with(compact('user', 'tp', 'address'));
	}
	public function postEditProfile(Request $request, $id)
	{
		$user = User::find($id);

		//check thay doi avatar
		$image = $user->user_avatar;
		if ($request->image) {
			$this->validate(
				$request,
				[
					'image' => 'required|mimes:jpeg,jpg,png',
				],
				[
					'image.required' => 'Bạn chưa chọn hình ảnh',
					'image.mimes' => 'Hình ảnh chỉ được phép có đuôi jpeg|jpg|png',
				]
			);
			$file = $request->file('image');
			//luu anh
			$name = $file->getClientOriginalName();
			do {
				$hinh = Str::random(3) . "_" . $name;
			} while (file_exists("img/avatar" . $hinh));
			$file->move("img/avatar", $hinh);
			$image = $hinh;
			$user->user_avatar = $image;
		}

		//check thay doi address
		if ($request->xaid || $request->maqh || $request->matp) {
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
			$user->xaid = $request->xaid;
			$user->maqh = $request->maqh;
			$user->matp = $request->matp;
		}

		$this->validate(
			$request,
			[
				'name' => 'required',
				'phone' => 'required',
			],
			[
				'name.required' => 'Bạn phải nhập họ tên',
				'phone.required' => 'Bạn phải nhập số điện thoại',
			]
		);

		$user->user_name = $request->name;
		$user->user_phone = $request->phone;
		$user->save();

		$id = Session::get('user_id');
		$user = User::find($id);
		$tp = Province::all();
		$address = "";
		if ($user->xaid != 0 && $user->maqh != 0 && $user->matp != 0) {
			$address = $user->xa->name_xaphuong . ' - ' . $user->qh->name_quanhuyen . ' - ' . $user->tp->name_city;
		}
		$thongbao = "Thành công";
		return view('frontend.pages.edit_profile')->with(compact('user', 'tp', 'address', 'thongbao'));
	}

	public function changePW()
	{
		$id = Session::get('user_id');
		$user = User::find($id);
		return view('frontend.pages.changePW')->with(compact('user'));
	}
	public function postchangePW(Request $request)
	{
		$this->validate(
			$request,
			[
				'pw' => 'required',
				'new_pw' => 'required',
				'confirm_pw' => 'required|same:new_pw',
			],
			[
				'pw.required' => 'Bạn phải nhập mật khẩu cũ',
				'new_pw.required' => 'Bạn phải nhập mật khẩu mới',
				'confirm_pw.required' => 'Bạn phải nhập xác nhận mật khẩu mới',
				'confirm_pw.same' => 'Mật khẩu xác nhận sai',
			]
		);
		$id = Session::get('user_id');
		$user = User::find($id);
		if (md5($request->pw) == $user->user_password) {
			$user->user_password = md5($request->new_pw);
			$user->save();

			$thongbao = "Đổi mật khẩu thành công";
			return view('frontend.pages.changePW')->with(compact('thongbao', 'user'));
		} else {

			$thongbao = "Mật khẩu sai";
			return view('frontend.pages.changePW')->with(compact('thongbao', 'user'));
		}
	}
}
