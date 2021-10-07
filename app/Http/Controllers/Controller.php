<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use App\Rules\Captcha;
use Session;
use Socialite; //sử dụng Socialite
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use App\Mail\ForgotPW;
use Illuminate\Support\Facades\URL;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    function __construct()
    {
        $category = Category::where('category_status', 1)->get();
        view()->share('category', $category);
    }
    public function getLogin()
    {
        return view('login');
    }
    public function postLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'password' => 'required',
                //'g-recaptcha-response' => new Captcha(),        //dòng kiểm tra Captcha
            ],
            [
                'email.required' => 'Bạn phải nhập email',
                'email.email' => 'Email sai định dạng',
                'password.required' => 'Bạn phải nhập mật khẩu',
            ]
        );
        $pw = md5($request->password);
        $user = User::where('user_email', $request->email)->where('user_password', $pw)->first();
        if ($user) {
            if ($user->user_verify == 0) {
                $thongbao = "Email chưa được xác nhận";
                return redirect('dang-nhap')->with(compact('thongbao'));
            } else {
                if ($user->role == 0) {
                    if ($user->user_avatar != "") {
                        Session::put('admin_avatar', $user->user_avatar);
                    }
                    Session::put('admin_name', $user->user_name);
                    Session::put('admin_id', $user->id);
                    return redirect('admin/dashboard');
                } else {
                    Session::put('user_name', $user->user_name);
                    Session::put('user_id', $user->id);
                    Session::put('user', $user);
                    return redirect('/#');
                }
            }
        } else {
            $thongbao = "Tài khoản hoặc mật khẩu không chính xác";
            return redirect('dang-nhap')->with(compact('thongbao'));
        }
    }
    public function getSignIn()
    {
        return view('signin');
    }
    public function postSignIn(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email|unique:users,user_email',
                'password' => 'required',
                //'g-recaptcha-response' => new Captcha(),        //dòng kiểm tra Captcha
                //|unique:customer,customer_email
                'name' => 'required',

            ],
            [
                'email.required' => 'Bạn phải nhập email',
                'email.email' => 'Email sai định dạng',
                'email.unique' => 'Email đã tồn tại',
                'password.required' => 'Bạn phải nhập mật khẩu',
                'email.unique' => 'Email đã được sử dụng',
                'name.required' => 'Bạn phải điền vào tên của bạn'
            ]
        );
        $new_user = new User;
        $new_user->user_name = $request->name;
        $new_user->user_phone = $request->phone;
        $new_user->user_email = $request->email;
        $new_user->user_password = md5($request->password);
        $new_user->status = 1;
        $new_user->role = 1;
        $new_user->user_verify = 0;
        $new_user->user_point = 0;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $new_user->created_at = now();
        $new_user->updated_at = now();
        $new_user->save();

        $email = $request->email;
        $link = URL::temporarySignedRoute('verify', now()->addMinutes(30), ['id' => $new_user->id]);
        Mail::to($new_user->user_email)->send(new VerifyEmail($email, $link));
        $thongbao = "Đăng kí thành công!Vui lòng xác nhận email của bạn";
        return redirect('dang-ki')->with(compact('thongbao'));
    }
    public function logout()
    {
        Session::flush();
        return redirect('dang-nhap');
    }

    public function verify($id)
    {
        $new_user = User::find($id);
        $new_user->user_verify = 1;
        $new_user->save();
        Session::put('user_name', $new_user->user_name);
        Session::put('user_id', $new_user->id);
        Session::put('user', $new_user);
        return redirect('/#');
    }
    public function forgotPW()
    {
        return view('email.inputEmail');
    }
    public function postForgotPW(Request $request)
    {
        $this->validate(
            $request,
            [

                'new_pw' => 'required',
                'confirm_pw' => 'required|same:new_pw',
            ],
            [

                'new_pw.required' => 'Bạn phải nhập mật khẩu mới',
                'confirm_pw.required' => 'Bạn phải nhập xác nhận mật khẩu mới',
                'confirm_pw.same' => 'Mật khẩu xác nhận sai',
            ]
        );
        $id = $request->id;
        $user = User::find($id);
        $user->user_password = md5($request->new_pw);
        $user->save();
        Session::put('user_name', $user->user_name);
        Session::put('user_id', $user->id);
        Session::put('user', $user);
        return redirect('/#');
    }
    public function inputEmail(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email',

            ],
            [
                'email.required' => 'Bạn phải nhập email',
                'email.email' => 'Email sai định dạng',

            ]
        );
        $user = User::where('user_email', $request->email)->first();
        if ($user) {
            $id = $user->id;
            $email = $user->user_email;
            $link = URL::temporarySignedRoute('verifyPW', now()->addMinutes(30), ['id' => $id]);
            Mail::to($email)->send(new ForgotPW($email, $link));
            $thongbao = "Thành công!Vui lòng kiêm tra email trong hộp thư của bạn";
            return redirect('quen-mat-khau')->with(compact('thongbao'));
        } else {
            $thongbao = "Email không tồn tại";
            return redirect('quen-mat-khau')->with(compact('thongbao'));
        }
    }
}
