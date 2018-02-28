<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Gate;
use App\Note;
use League\CommonMark\CommonMarkConverter;

class UpdateNoteFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('edit-notes', $this->route('note')->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'body' => 'required',
        ];
    }

    /**
     * Response when request fails the validation.
     *
     * @param array $errors
     * @return \Illuminate\Http\RedirectResponse
     */
    public function response(array $errors)
    {
        $note = $this->route('note');
        return redirect()
            ->action('NoteController@index', ['user' => $note->user])
            ->withErrors($errors)
            ->withInput()
            ->with(['edit' => $note, 'message' => 'There were errors in given inputs. Try again to edit note "'. $note->title . '"".']);
    }

    /**
     * Update note with new information.
     *
     * @param Note $note
     */
    public function updateNote(Note $note)
    {
        $note->title = $this->title;
        $converter = new CommonMarkConverter(['html_input' => 'strip']);
        $note->body = $converter->convertToHtml($this->body);
        $note->save();
    }
}
