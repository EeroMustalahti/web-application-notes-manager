<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreNoteFormRequest;
use App\Http\Requests\UpdateNoteFormRequest;
use App\Note;
use App\User;
use League\HTMLToMarkdown\HtmlConverter;

class NoteController extends Controller
{
    /**
     * Display a listing of user's notes.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {
        if(session('edit') !== null) {
            $editNote = session('edit');
            return view('notes', compact('user', 'editNote'));
        }

        return view('notes', compact('user'));
    }

    /**
     * Create new note and add it to the user's collection of notes.
     *
     * @param User $user
     * @param StoreNoteFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(User $user, StoreNoteFormRequest $request)
    {
        $request->addNote($user);

        return back()->with('message', 'Note was created');
    }

    /**
     * Show the form for editing note.
     *
     * @param Note $note
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Note $note)
    {
        if(Gate::denies('edit-notes', $note->id)) {
            return back()->with('message', 'You are not authorized to edit this user\'s notes');
        }

        $converter = new HtmlConverter(); // Tämän HtmlConverterin käyttäminen ei onnistunut
        $note->body = $converter->convert($note->body); // utan shell-palvelimella.

        return redirect()
                ->action('NoteController@index', ['user' => $note->user])
                ->with(['edit' => $note, 'message' => 'Note "' . $note->title . '" can now be edited']);
    }

    /**
     * Update note with new information.
     *
     * @param Note $note
     * @param UpdateNoteFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Note $note, UpdateNoteFormRequest $request)
    {
        $request->updateNote($note);

        return back()->with('message', 'Note was updated');
    }

    /**
     * Delete note.
     *
     * @param Note $note
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Note $note, Request $request)
    {
        if(Gate::denies('delete-notes', $note->id)) {
            $unauthorizedMessage = 'You are not authorized to delete this user\'s notes';
            if($request->ajax()) {
                return response(['message' => $unauthorizedMessage, 'success' => false], 200);
            }
            return back()->with('message', $unauthorizedMessage);
        }

        $note->delete();
        $deleteNoteMessage = 'Note "' . $note->title . '" has been deleted';

        if($request->ajax()) {
            return response(['message' => $deleteNoteMessage, 'success' => true], 200);
        }
        return back()->with('message', $deleteNoteMessage);
    }
}
