@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper"> 
        <h2>Пользователи</h2>

        @if($Users->isEmpty())
            <p class="alert alert-info">Нет зарегистрированных пользователей.</p>
        @else
            <div class="main-content-area">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Полное имя</th>
                            <th>Email</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Users as $u)
                            <tr>
                                {{-- ID --}}
                                <td>{{ $u->id ?? '-' }}</td>
                                
                                <td>
                                    <a href="{{ url('/user/' . ($u->id ?? '#')) }}" class="table-link">
                                        {{ $u->full_name ?? $u->name ?? ('User ' . ($u->id ?? '')) }}
                                    </a>
                                </td>
                                
                                <td>{{ $u->email ?? '-' }}</td>
                                <td style="white-space: nowrap;">
                                    <a href="{{ url('/user/' . ($u->id ?? '#')) }}" class="btn-table-action view-btn">
                                        Просмотр
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection