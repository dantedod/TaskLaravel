<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{

  public function index()
  {
    $id = session('user.id');
    $notes = User::find($id)->notes()->get()->toArray();



    return view('home', ['notes' => $notes]);
  }

  public function newNote()
  {
    echo 'i create a the new route';
  }

  public function editNote($id)
  {

    $id = Operations::decryptId($id);
    echo "I'm editing note with id:" . $id;
  }

  public function deleteNote($id)
  {
    $id = Operations::decryptId($id);
    echo "I'm try to delete the note with id:" . $id;
  }
}
