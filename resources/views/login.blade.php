@extends('layouts.app')


@section('content')
    @auth
        <div class="container-auth">
            <h2>Доброго времени суток, {{ Auth::user()->full_name ?? 'Пользователь' }}</h2>
            <a href="{{ url('logout') }}" class="btn-custom">Выйти из аккаунта</a>
        </div>
    @else
        <div class="container-auth">
            <h2>Войти в аккаунт</h2>
            
            <div class="card-login">
                <div class="container">
                    <form method="post" action="{{ url('auth') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input 
                                type="text" 
                                id="email"
                                name="email" 
                                value="{{ old('email') }}"
                                class="@error('email') is-invalid-input @enderror"
                            />
                            @error('email')
                                <div class='is-invalid'>{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input 
                                type="password" 
                                id="password"
                                name="password"
                                class="@error('password') is-invalid-input @enderror"
                            />
                            @error('password')
                                <div class='is-invalid'>{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn-custom w-100">
                            Войти
                        </button>
                    </form>
                </div>
            </div>

            @error('error')
                <div class="is-invalid text-center mt-3">{{ $message }}</div>
            @enderror

        </div>
    @endauth
@endsection