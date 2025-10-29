@extends('layouts.app')

@section('content')
    @if(!$user)
        <p>Пользователь не найден.</p>
    @else
        <h2>{{ $user->full_name ?? $user->name ?? ('User ' . $user->id) }} (id: {{ $user->id }})</h2>

        <div class="card" style="padding:10px;margin-bottom:12px;">
            <div><strong>Email:</strong> {{ $user->email ?? '-' }}</div>
            <div><strong>Создан:</strong> {{ $user->created_at ?? '-' }}</div>
        </div>

        <h3>Группы</h3>
        @php $uGroups = $user->groups ?? ($user['groups'] ?? collect()); @endphp
        @if(empty($uGroups) || $uGroups->isEmpty())
            <p>Нет групп</p>
        @else
            <ul>
                @foreach($uGroups as $g)
                    <li><a href="{{ url('/group/' . $g->id) }}">{{ $g->name }}</a></li>
                @endforeach
            </ul>
        @endif

        <h3>Друзья</h3>
        @php
            $friends = $user->friends(); 
        @endphp

        @if($friends->isEmpty())
            <p>Нет друзей</p>
        @else
            <ul>
                @foreach($friends as $f)
                    <li><a href="{{ url('/user/' . $f->id) }}">{{ $f->full_name ?? $f->name ?? ('User ' . $f->id) }}</a></li>
                @endforeach
            </ul>
        @endif

        <h3>Посты в группах</h3>
        @php $posts = $user->postsInGroups ?? ($user['postsInGroups'] ?? collect()); @endphp
        @if(empty($posts) || $posts->isEmpty())
            <p>Нет постов.</p>
        @else
            @foreach($posts as $p)
                <div class="card" style="padding:8px;margin-bottom:8px;">
                    <div style="font-size:13px;color:#666">
                        <strong>Группа:</strong>
                        @if(isset($p->group))
                            <a href="{{ url('/group/' . $p->group->id) }}">{{ $p->group->name }}</a>
                        @else
                            <span>-</span>
                        @endif
                        &nbsp; • &nbsp; <strong>Дата:</strong> {{ $p->date_of_post ?? '-' }}
                    </div>
                    <p style="margin-top:6px;">{{ $p->text }}</p>
                </div>
            @endforeach
        @endif
    @endif
@endsection