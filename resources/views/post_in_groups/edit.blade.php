@extends('layouts.app')

@section('content')
<div class="container-auth">
    <h1>Редактировать пост #{{ $postInGroup->id }}</h1>

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
        <form method="POST" action="{{ route('post-in-groups.update', $postInGroup) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="text">Text</label>
                <textarea 
                    id="text"
                    name="text"
                    rows="5"
                >{{ old('text', $postInGroup->text) }}</textarea>
                @error('text')
                    <div class="is-invalid">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-custom">
                Обновить пост
            </button>
            
        </form>
    </div>
</div>
@endsection