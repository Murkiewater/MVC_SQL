@extends('layouts.app')

@section('content')
    <h2>Группы пользователя: {{ $user->full_name ?? $user->name ?? '' }}</h2>

    @php $uGroups = $user->groups ?? collect(); @endphp

    @if(empty($uGroups) || $uGroups->isEmpty())
        <p>Нет групп.</p>
    @else
        <ul>
            @foreach($uGroups as $g)
                <li>
                    <a href="{{ url('/groups/' . $g->id) }}">{{ $g->name }}</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
