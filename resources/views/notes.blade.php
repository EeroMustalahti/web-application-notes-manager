@extends('layouts.app')

@section('content')
    @if(Auth::check() && (Auth::user() == $user || isset($editNote)))
        <div class="panel panel-default">
            <form action="@if(isset($editNote)) {{url($editNote->id . '/edit')}} @else {{url($user->slug . '/notes')}} @endif" method="post">
                {{ csrf_field() }}
                <div class="panel-heading">
                    @if(isset($editNote))
                        Edit user's {{$user->name}} note "{{$editNote->title}}":
                    @else
                        Write new note for {{$user->name}}:
                    @endif
                </div>
                <div class="panel-body">
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label class="control-label" for="title">Title:</label>
                        <input class="form-control" type="text" name="title" id="title"value="@if(isset($editNote) && !($errors->has('title') || $errors->has('body'))){{$editNote->title}}@else{{old('title')}}@endif">
                        {!!$errors->first('title', '<p class="help-block">:message</p>')!!}
                    </div>
                    <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                        <label class="control-label" for="body">Content:</label>
                        <textarea class="form-control" name="body" id="body">@if(isset($editNote) && !($errors->has('title') || $errors->has('body'))){{$editNote->body}}@else{{old('body')}}@endif</textarea>
                        {!!$errors->first('body', '<p class="help-block">:message</p>')!!}
                    </div>
                    <button type="submit" class="btn btn-primary">@if(isset($editNote)) Edit note @else Add note @endif</button>
                </div>
            </form>
        </div>
    @endif

    @foreach($user->notes as $note)
        <div id="note{{$note->id}}" class="panel panel-default">
        <div class="panel-heading clearfix">
            {{$note->title}}
            @if(Auth::check())
                @can('delete-notes', $note->id)
                    <button class="btn btn-danger pull-right delete-note" value="{{$note->id}}">Delete note</button>
                @endcan
                @can('edit-notes', $note->id)
                    <a class="btn btn-space btn-info pull-right" href="{{ url($note->id . '/edit') }}">Edit note</a>
                @endcan
            @endif
        </div>
            <div class="panel-body">
                {!! $note->body !!}
            </div>
        </div>
    @endforeach
@endsection