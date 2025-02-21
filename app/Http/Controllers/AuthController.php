<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function login()
  {
    return view('login');
  }

  public function loginSubmit(Request $request)
  {
    echo "login Submit";
  }

  public function logout()
  {
    echo "logout";
  }
}
