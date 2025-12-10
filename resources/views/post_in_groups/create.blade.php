@extends('layouts.app')

@section('content')
<div class="container-auth">
    <h1>Создать пост</h1>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-login">
        <form method="POST" action="{{ route('post-in-groups.store') }}">
            @csrf

            <div class="form-group">
                <label for="group_id">Опубликовать в группу</label>
                <input name="group_id" type="text" value="{{ old('group_id') }}">
                @error('group_id')
                    <div class="is-invalid">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="text">Текст поста</label>
                <textarea 
                    id="text"
                    name="text"
                    rows="5"
                >{{ old('text') }}</textarea>
                @error('text')
                    <div class="is-invalid">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-custom">
                Сохранить пост
            </button>
            
        </form>
    </div>
</div>
@endsection