<?php

namespace App\Http\Controllers;

use App\Models\Note;
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
    //showe new note view

    return view("new_note");
  }

  public function newNoteSubmit(Request $request)
  {
    //Validate request
    $request->validate(
      [
        'text_title' => 'required|min:3|max:200',
        'text_note' => 'required|min:3|max:3000',
      ],
      [
        'text_title.required' => "O title e obrigatorio",
        "text_note.required" => "A nota e obrigatoria",
        "text_note.min" => "A nota precisa conter pelo menos 6 caracteres",
        "text_note.max" => "A nota pode ter no maximo 3000 caracteres",
        "text_title.min" => "O title  precisa conter pelo menos 6 caracteres",
        "text_title.max" => "O title pode ter no maximo 200 caracteres",
      ]

    );
    //get user id
    $id = session('user.id');

    //create new note

    $note = new Note();
    $note->user_id = $id;
    $note->title = $request->text_title;
    $note->text = $request->text_note;
    $note->save();

    //redirect to home
    return redirect()->route('home');
  }

  public function editNote($id)
  {

    $id = Operations::decryptId($id);

    //load note
    $note = Note::find($id);
    //show edit note view

    return view('edit_note', ['note' => $note]);
  }

  public function editNoteSubmit(Request $request)
  {

    //validate request
    $request->validate(
      [
        'text_title' => 'required|min:3|max:200',
        'text_note' => 'required|min:3|max:3000',
      ],
      [
        'text_title.required' => "O title e obrigatorio",
        "text_note.required" => "A nota e obrigatoria",
        "text_note.min" => "A nota precisa conter pelo menos 6 caracteres",
        "text_note.max" => "A nota pode ter no maximo 3000 caracteres",
        "text_title.min" => "O title  precisa conter pelo menos 6 caracteres",
        "text_title.max" => "O title pode ter no maximo 200 caracteres",
      ]

    );

    // check if note_id exists
    if ($request->note_id == null) {
      return redirect()->route('home');
    }

    //decrypt note_id
    $id = Operations::decryptId($request->note_id);

    //load note
    $note = Note::find($id);

    //update note
    $note->title = $request->text_title;
    $note->text =  $request->text_note;
    $note->save();

    //redirect to home
    return  redirect()->route('home');
  }

  public function deleteNote($id)
  {
    $id = Operations::decryptId($id);
    echo "I'm try to delete the note with id:" . $id;
  }
}
