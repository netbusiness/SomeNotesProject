<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;

class NotesController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::updateAuthTokenCookie();
    }

    public function index() {
        return Note::with("owner")->where("owner_id", \Auth::user()->id)->orderBy("created_at", "desc")->get();
    }
    
    public function show($id) {
        $note = Note::with("owner")->find($id);
        if ($note != null && $note->owner_id != \Auth::user()->id) {
            return null; // No
        } else {
            return $note;
        }
    }
    
    public function store(Request $request) {
        $rules = array(
            "title" => "required|max:255",
            "content" => "required"
        );
        
        $this->validate($request, $rules);
        
        $note = new Note();
        $note->owner_id = \Auth::user()->id;
        $note->title = $request->input("title");
        $note->content = $request->input("content");
        $note->save();
        
        return response()->json(array(
            "success" => $note->id
        ));
    }
    
    public function update(Request $request, $id) {
        $rules = array(
            "title" => "required|max:255",
            "content" => "required"
        );
        
        $this->validate($request, $rules);
        
        $note = Note::find($id);
        if ($note != null && $note->owner_id != \Auth::user()->id) {
            return abort(403);
        } elseif ($note == null) {
            return response(422)->json(array(
                "error" => "Note does not exist"
            ));
        }
        
        $note->title = $request->input("title");
        $note->content = $request->input("content");
        $note->save();
        
        return response()->json(array(
            "success" => $note->id
        ));
    }
    
    public function delete($id) {
        $note = Note::find($id);
        if ($note != null && $note->owner_id != \Auth::user()->id) {
            return abort(403);
        } elseif ($note == null) {
            return response(422)->json(array(
                "error" => "Note does not exist"
            ));
        }
        
        $note->delete();
        
        return response()->json(array(
            "success" => true
        ));
    }
}
