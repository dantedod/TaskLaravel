<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{

  public function index()
  {
    $id = session('user.id');
    $user = User::find($id)->toArray();
    $notes = User::find($id)->notes()->get()->toArray();

    echo '<pre>';
    print_r($user);
    print_r($notes);

    die();
    return view('home', $user);
  }

  public function newNote()
  {
    echo 'i create a the new route';
  }
}
