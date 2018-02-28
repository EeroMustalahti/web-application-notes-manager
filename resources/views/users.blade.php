@extends('layouts.app')

@section('content')
    @foreach($users as $user)
        <div id="user{{$user->slug}}" class="panel panel-default">
            <div class="panel-heading clearfix">
                Notes of user {{$user->name}}
                @if(Auth::check())
                    @can('delete-users', $user->id)
                        <button class="btn btn-danger pull-right delete-user" value="{{$user->slug}}">Delete user</button>
                    @endcan
                    @can('make-modes', $user->id)
                        <button id="mode{{$user->slug}}" class="btn btn-space btn-info pull-right make-mode" value="{{$user->slug}}">{{$user->roles()->find($modeRoleId) ? 'Remove moderator' : 'Make moderator'}}</button>
                    @endcan
                @endif
                <a class="btn btn-space btn-default pull-right" href="{{ url($user->slug . '/notes') }}">Check notes</a>
            </div>
            <div class="panel-body">
                <ul class="list-inline">
                    @foreach($user->notes as $note)
                        <li class="list-group-item">{{$note->title}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
@endsection