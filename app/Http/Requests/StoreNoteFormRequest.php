<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use League\CommonMark\CommonMarkConverter;

class StoreNoteFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user() == $this->route('user');
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
     * Create and add new note to user's collection of notes.
     *
     * @param User $user
     */
    public function addNote(User $user)
    {
        $converter = new CommonMarkConverter(['html_input' => 'strip']);

        $user->notes()->create([
            'title' => $this->title,
            'body' => $converter->convertToHtml($this->body),
        ])->save();
    }
}
