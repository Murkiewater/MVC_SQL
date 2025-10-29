@extends('layouts.app')

@section('content')
    <h2>Пользователи</h2>
    @if($Users->isEmpty())
        <p>Нет пользователей.</p>
    @else
        @foreach($Users as $u)
            <div class="card" style="padding:10px;margin-bottom:8px;">
                <a href="{{ url('/user/' . ($u->id ?? $u['id'] ?? '#')) }}">
                    <strong>{{ $u->full_name ?? $u->name ?? ('User ' . ($u->id ?? '')) }}</strong>
                </a>
                <div style="font-size:13px;color:#666">id: {{ $u->id ?? '-' }}</div>
                <div style="font-size:13px;color:#666">email: {{ $u->email ?? '-' }}</div>
            </div>
        @endforeach
    @endif
@endsection