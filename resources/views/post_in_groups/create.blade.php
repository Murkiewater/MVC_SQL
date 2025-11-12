@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1>Создать пост</h1>

    <form method="POST" action="{{ route('post-in-groups.store') }}">
    @csrf
    <label>User ID</label>
    <input name="user_id" value="{{ old('user_id') }}">

    <label>Group ID</label>
    <input name="group_id" value="{{ old('group_id') }}">

    <label>Text</label>
    <textarea name="text">{{ old('text') }}</textarea>

    <label>Date of post</label>
    <input type="datetime-local" name="date_of_post" value="{{ old('date_of_post') }}">

    <button type="submit">Сохранить</button>
    </form>
@endsection
