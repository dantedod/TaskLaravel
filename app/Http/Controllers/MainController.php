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
    $notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();



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
    if ($id === null) {
      return redirect()->route('home');
    }
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
    return redirect()->route('home');

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
    return redirect()->route('home');

    //load note

    $note = Note::find($id);

    //show delete note confiirm
    return view('delete_note', ['note' => $note]);
  }

  public function deleteNoteConfirm($id)
  {

    //check if id is encrypt
    $id = Operations::decryptId($id);
    return redirect()->route('home');

    //load note
    $note = Note::find($id);
    //1. hard delete
    //$note->delete();

    //2. softdelete
    //$note->deleted_at = date('Y:m:d H:i:s');
    //$note->save();

    //3.soft delete(property SoftDelets in model)
    $note->delete();

    //4.hard delete(property SoftDelets in model)
    //$note->forceDelete();

    //redirect to home
    return redirect()->route('home');
  }
}
