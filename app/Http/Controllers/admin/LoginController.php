<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

}
