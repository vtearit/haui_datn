<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ward;
use App\Models\District;
use App\Models\Province;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return view('admin.pages.user.display')->with(compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.user.add');
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
                'email' => 'required|unique:users,user_email',
                'pw' => 'required'


            ],
            [
                'name.required' => 'Bạn chưa nhập tên',
                'email.unique' => 'Email đã tồn tại',
                'email.required' => 'Bạn chưa nhập email',
                'pw.required' => 'Bạn chưa nhập password'
            ]
        );
        $user = new User();
        $user->user_name = $request->name;
        $user->user_email = $request->email;
        $user->user_password = md5($request->pw);
        $user->status = $request->status;
        $user->role = 1;
        $user->user_verify = 0;
        $user->save();
        $thongbao = "Thêm khách hàng thành công";
        return view('admin.pages.user.add')->with(compact('thongbao'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $tinh_thanh_pho = Province::all();
        return view('admin.pages.user.edit')->with(compact('user', 'tinh_thanh_pho'));
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
        $hinh = "";
        if ($request->avatar != "") {
            $this->validate(
                $request,
                [
                    'avatar' => 'required|mimes:jpeg,jpg,png',

                ],
                [
                    'avatar.required' => 'Bạn chưa chọn hình ảnh',
                    'avatar.mimes' => 'Hình ảnh chỉ được phép có đuôi jpeg|jpg|png',
                ]
            );
            $file = $request->file('avatar');
            //luu anh
            $name = $file->getClientOriginalName();
            do {
                $hinh = Str::random(3) . "_" . $name;
            } while (file_exists("img/avatar" . $hinh));
            $file->move("img/avatar", $hinh);
        }



        $user = User::find($id);
        $user->user_name = $request->name;
        $user->status = $request->status;
        $user->user_verify = $request->verify;
        $user->user_phone = $request->phone;
        if ($request->pw) {
            $user->user_password = md5($request->pw);
        }
        if ($request->xaid != "") {
            $user->xaid = $request->xaid;
            $user->maqh = $request->maqh;
            $user->matp = $request->matp;
        }
        if ($request->avatar != "") {
            $user->user_avatar = $hinh;
        }
        $user->save();
        $thongbao = 'Cập nhật thành công';
        return redirect('admin/khach-hang/sua/' . $id)->with(compact('thongbao'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        $user->status = 0;
        $user->save();
        $user = User::all();
        $thongbao = "Ẩn khách hàng thành công";
        return view('admin.pages.user.display')->with(compact('user', 'thongbao'));
    }
}
