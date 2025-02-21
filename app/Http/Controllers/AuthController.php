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
    //form validation
    $request->validate(
      [
        'text_username' => 'required|email',
        'text_password' => 'required|min:6|max:16',
      ],
      [
        'text_username.required' => "O username e obrigatorio",
        "text_username.email" => "O email precisa ser valido",
        "text_password.required" => "A senha e obrigatoria",
        "text_password.min" => "A senha precisa conter pelo menos 6 caracteres",
        "text_password.max" => "A senha pode ter no maximo 16 caracteres",
      ]

    );

    //get user input
    $username = $request->input('text_username');
    $password = $request->input('text_password');

    echo 'ok';
  }

  public function logout()
  {
    echo "logout";
  }
}
