@extends('layouts.app')

@section('content')
    <h2>Пользователи группы: {{ $group->name ?? '' }}</h2>

    @php $gUsers = $group->users ?? collect(); @endphp

    @if(empty($gUsers) || $gUsers->isEmpty())
        <p>Нет пользователей.</p>
    @else
        <ul>
            @foreach($gUsers as $u)
                <li>
                    <a href="{{ url('/users/' . $u->id) }}">{{ $u->full_name ?? $u->name ?? ('User ' . $u->id) }}</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
