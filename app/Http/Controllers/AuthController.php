<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SysUserRole;
use Auth;
use NCU\OpenID\NetIDReturn;
use NetID;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['logout']]);
        $this->middleware('guest', ['only' => ['auth']]);
    }
    
    // public function login()
    // {
    //     return view('auth.login');
    // }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('layouts.index');
    }
    
    public function auth()
    {
        $rc = NetID::doLogin(null);
    
        if (is_string($rc)) {
            return redirect($rc);
        }
    
        switch ($rc->returnCode) {
            case NetIDReturn::LOGIN_OK:
            case NetIDReturn::REDIRECT_REQUEST:
                return $this->doLoginAndRedirect($rc);
            case NetIDReturn::LOGIN_FAILED:
            case NetIDReturn::CANCELED_AUTHENTICATION:
            case NetIDReturn::ACCOUNT_NOT_ACCEPTABLE:
            case NetIDReturn::ROLE_NOT_ACCEPTABLE:
            case NetIDReturn::ERROR_EXCEPTION:
                break;
        }
    
        return redirect()->route('layouts.index')->with('error', '登入失敗');
    }
    
    private function doLoginAndRedirect($rc)
    {
        if ($user = SysUserRole::find($rc->account)) {
            Auth::login($user);
            return redirect()->route('layouts.index');
        }
    
        return redirect()->route('layouts.index')->with('error', '您帳號尚未註冊為系統使用者');
    }
}
