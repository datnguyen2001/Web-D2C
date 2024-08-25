<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\ShopModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login ()
    {
        $title = 'Admin';
        return view('admin.login', compact('title'));
    }

    public function doLogin (Request $request)
    {
        $bodyData = $request->all();
        $check = AdminModel::where('phone', $bodyData['username'])
            ->exists();
        if (!$check) {
            return redirect()->route('admin.login')->with(['alert'=>'danger', 'message' => 'Số điện thoại không tồn tại']);
        }
        $dataAttemptAdmin = [
            'phone' => $bodyData['username'],
            'password' => $bodyData['password'],
        ];
        if (Auth::guard('admin')->attempt($dataAttemptAdmin)) {
            return redirect()->route('admin.index');
        }
        return redirect()->route('admin.login')->with(['alert'=>'danger', 'message' => 'Tài khoản hoặc mật khẩu không chính xác']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()
            ->route('admin.login')
            ->with(['alert' => 'success', 'message' => 'Đăng xuất thành công']);
    }

    public function shopLogin ()
    {
        $title = 'Shop';
        return view('shop.login', compact('title'));
    }

    public function shopDoLogin (Request $request)
    {
        $arr = [
            'email' => trim($request->get('email')),
            'password' => trim($request->get('password')),
        ];
        $user = User::where('email', $arr['email'])->value('id');
        if (empty($user)) {
            return redirect()->back()->with('error', 'Tài khoản không tồn tại');
        }
        if (Auth::guard('web')->attempt($arr)) {
            return redirect()->route('shop');
        } else {
            return back()->with(['error' => 'Tài khoản hoặc mật khẩu không đúng']);
        }
    }

    public function shopLogout()
    {
        Auth::guard('web')->logout();
        toastr()->success('Đăng xuất thành công');
        return redirect()->route('login');
    }

}
