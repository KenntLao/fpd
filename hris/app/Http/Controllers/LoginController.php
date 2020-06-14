<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index(){}

    public function logout(){
        $account_mode = $_SESSION['sys_account_mode'];

        session_destroy();
        session_start();
        $_SESSION['sys_login_suc'] = "You have logged out successfully";
        return redirect('/');
    }
}
