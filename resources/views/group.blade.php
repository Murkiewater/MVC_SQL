@extends('layouts.app')

@section('content')
    @if(!$group)
        <p>Группа не найдена.</p>
    @else
        <h2>{{ $group->name }} (id: {{ $group->id }})</h2>

        <h3>Пользователи</h3>
        @php $gUsers = $group->users ?? ($group['users'] ?? collect()); @endphp
        @if(empty($gUsers) || $gUsers->isEmpty())
            <p>Нет пользователей в группе.</p>
        @else
            <ul>
                @foreach($gUsers as $u)
                    <li><a href="{{ url('/user/' . $u->id) }}">{{ $u->full_name ?? $u->name ?? ('User ' . $u->id) }}</a></li>
                @endforeach
            </ul>
        @endif

        <h3>Посты</h3>
        @php $posts = $group->posts ?? ($group['posts'] ?? collect()); @endphp
        @if(empty($posts) || $posts->isEmpty())
            <p>Нет постов в группе.</p>
        @else
            @foreach($posts as $p)
                <div class="card" style="padding:8px;margin-bottom:8px;">
                    <div style="font-size:13px;color:#666"><strong>Автор:</strong>
                        @if(isset($p->user))
                            <a href="{{ url('/user/' . $p->user->id) }}">{{ $p->user->full_name }}</a>
                        @else
                            -
                        @endif
                        &nbsp; • &nbsp; <strong>Дата:</strong> {{ $p->date_of_post ?? '-' }}
                    </div>
                    <p style="margin-top:6px;">{{ $p->text }}</p>
                </div>
            @endforeach
        @endif
    @endif
@endsection