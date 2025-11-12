@extends('layouts.app')

@section('content')
<h1>Редактировать пост #{{ $postInGroup->id }}</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('post-in-groups.update', $postInGroup) }}">
    @csrf
    @method('PUT')

    <label>User ID</label>
    <input name="user_id" value="{{ old('user_id', $postInGroup->user_id) }}">

    <label>Group ID</label>
    <input name="group_id" value="{{ old('group_id', $postInGroup->group_id) }}">

    <label>Text</label>
    <textarea name="text">{{ old('text', $postInGroup->text) }}</textarea>

    <label>Date of post</label>
    <input type="datetime-local" name="date_of_post"
           value="{{ old('date_of_post', optional($postInGroup->date_of_post)->format('Y-m-d\TH:i')) }}">

    <button type="submit">Обновить</button>
</form>
@endsection