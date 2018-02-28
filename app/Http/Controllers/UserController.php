<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::all()->sortBy('created_at');
        $modeRoleId = Role::where('name', 'moderator')->first()->id;

        return view('users', compact('users', 'modeRoleId'));
    }

    /**
     * Update user's moderator status by giving or removing moderator role.
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(User $user, Request $request)
    {
        if(Gate::denies('make-modes', $user->id)) {
            $unauthorizedMessage = 'You are not authorized to give or remove moderator privileges';
            if($request->ajax()) {
                return response(['message' => $unauthorizedMessage, 'success' => false], 200);
            }
            return back()->with('message', $unauthorizedMessage);
        }

        $toggleModeMessage = $user->toggleModerator();

        if($request->ajax()) {
            return response(['message' => $toggleModeMessage, 'success' => true], 200);
        }
        return back()->with('message', $toggleModeMessage);
    }

    /**
     * Detach all roles from user and delete user.
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(User $user, Request $request)
    {
        if(Gate::denies('delete-users', $user->id)) {
            $unauthorizedMessage = 'You are not authorized to delete users';
            if($request->ajax()) {
                return response(['message' => $unauthorizedMessage, 'success' => false], 200);
            }
            return back()->with('message', $unauthorizedMessage);
        }

        $user->roles()->detach();
        $user->delete();
        $deleteUserMessage = 'User "' . $user->name . '" has been deleted';

        if($request->ajax()) {
            return response(['message' => $deleteUserMessage, 'success' => true], 200);
        }
        return back()->with('message', $deleteUserMessage);
    }
}
