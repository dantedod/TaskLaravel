<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    //check if users existe

    $user = User::where('username', $username)
      ->where('deleted_at', null)
      ->first();

    if (!$user) {
      return redirect()->back()->withInput()->with('loginError', 'username ou password incorretos');
    }

    //check if password is correct
    if (!password_verify($password, $user->password)) {
      return redirect()->back()->withInput()->with('loginError', 'username ou password incorretos');
    }

    //update last login
    $user->last_login = date('Y-m-d H:i:s');
    $user->save();

    //login user  
    session([
      'user' => [
        'id' => $user->id,
        'username' => $user->username
      ]
    ]);

    echo 'Logado com sucesso';
  }


  public function logout()
  {
    //logout from the applicaiton

    session()->forget('user');
    return redirect()->to('login');
  }
}
