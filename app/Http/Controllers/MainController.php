<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{

  public function index()
  {
    echo 'I inside the app';
  }

  public function newNote()
  {
    echo 'i create a the new route';
  }
}
