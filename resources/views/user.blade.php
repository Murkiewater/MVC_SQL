@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper"> 
        
        @if(!$user)
            <h2 class="alert alert-error">Пользователь не найден.</h2>
        @else
            
            <h2 class="user-title">{{ $user->full_name ?? $user->name ?? ('User ' . $user->id) }}</h2>
            
            <div class="user-info-card card-login">
                <div class="info-row">
                    <strong>ID:</strong> <span>{{ $user->id }}</span>
                </div>
                <div class="info-row">
                    <strong>Email:</strong> <span>{{ $user->email ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <strong>Создан:</strong> <span>{{ $user->created_at ?? '-' }}</span>
                </div>
            </div>

            
            <h3>Группы</h3>
            @php $Groups = $user->groups ?? ($user['groups'] ?? collect()); @endphp
            @if(empty($Groups) || $Groups->isEmpty())
                <p class="alert alert-info">Пользователь не состоит в группах.</p>
            @else
                <table class="data-table small-table">
                    <thead>
                        <tr>
                            <th style="width: 30%">ID Группы</th>
                            <th style="width: 50%">Название</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Groups as $g)
                            <tr>
                                <td>{{ $g->id }}</td>
                                <td>
                                    <a href="{{ url('/group/' . $g->id) }}" class="table-link">{{ $g->name }}</a>
                                </td>
                                <td>
                                    <a href="{{ url('/group/' . $g->id) }}" class="btn-table-action view-btn">Просмотр</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            
            <h3>Друзья</h3>
            @php $friends = $user->friends(); @endphp

            @if($friends->isEmpty())
                <p class="alert alert-info">Нет друзей.</p>
            @else
                <table class="data-table small-table">
                    <thead>
                        <tr>
                            <th style="width: 30%">ID Друзей</th>
                            <th style="width: 50%">Имя</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($friends as $f)
                            <tr>
                                <td>{{ $f->id }}</td>
                                <td>
                                    <a href="{{ url('/user/' . $f->id) }}" class="table-link">
                                        {{ $f->full_name ?? $f->name ?? ('User ' . $f->id) }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('/user/' . $f->id) }}" class="btn-table-action view-btn">Просмотр</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            
            <h3>Посты в группах</h3>
            @php $posts = $user->postsInGroups ?? ($user['postsInGroups'] ?? collect()); @endphp
            
            @if(empty($posts) || $posts->isEmpty())
                <p class="alert alert-info">Нет постов в группах.</p>
            @else
                @foreach($posts as $p)
                    <div class="post-card">
                        <div class="post-meta">
                            {{-- Группа --}}
                            <div class="meta-item">
                                <strong>Группа:</strong>
                                @if(isset($p->group))
                                    <a href="{{ url('/group/' . $p->group->id) }}" class="meta-link">{{ $p->group->name }}</a>
                                @else
                                    <span>(Удалена)</span>
                                @endif
                            </div>
                            
                            <div class="meta-item">
                                <strong>Дата:</strong> {{ \Carbon\Carbon::parse($p->date_of_post)->format('d.m.Y H:i') }}
                            </div>
                        </div>
                        
                        <p class="post-text">{{ $p->text }}</p>
                    </div>
                @endforeach
            @endif

        @endif
    </div>
@endsection