@extends('layouts.app')

<style> .is-invalid { color: red; } </style>

@section('content')
@if($user)
    <h2>Доброго времени суток, {{ $user->full_name }}</h2>
    <a href="{{ url('logout') }}">Выйти из аккаунта</a>
@else
    <h2>Ввйти в аккаунт</h2>
    <form method="post" action="{{ url('auth') }}">
        @csrf
        <label>E-mail</label>
        <input type="text" name="email" value="{{ old('email') }}"/>
        @error('email')
        <div class='is-invalid'>{{ $message }}</div>
        @enderror
        <br>
        <label>Пароль</label>
        <input type="password" name="password" value="{{ old('password') }}"/>
        @error('password')
        <div class='is-invalid'>{{ $message }}</div>
        @enderror
        <br>
        <input type="submit">
    </form>
    @error('error')
    <div class="is-invalid">{{ $message }}</div>
    @enderror
@endif
@endsection