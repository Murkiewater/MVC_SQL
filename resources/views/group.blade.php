@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper"> 
        
        @if(!$group)
            <h2 class="alert alert-error">Группа не найдена.</h2>
        @else
            
            <h2>{{ $group->name }}</h2>
            
            <div class="group-info-card card-login">
                <div class="info-row">
                    <strong>ID:</strong> <span>{{ $group->id }}</span>
                </div>
                <div class="info-row">
                    <strong>Создана:</strong> <span>{{ $group->created_at ?? '-' }}</span>
                </div>
            </div>
            
            <h3>Пользователи</h3>
            @php $gUsers = $group->users ?? ($group['users'] ?? collect()); @endphp
            @if(empty($gUsers) || $gUsers->isEmpty())
                <p class="alert alert-info">Нет пользователей в группе.</p>
            @else
                <table class="data-table small-table">
                    <thead>
                        <tr>
                            <th style="width: 10%">ID</th>
                            <th>Имя</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gUsers as $u)
                            <tr>
                                <td>{{ $u->id }}</td>
                                <td>
                                    <a href="{{ url('/user/' . $u->id) }}" class="table-link">
                                        {{ $u->full_name ?? $u->name ?? ('User ' . $u->id) }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('/user/' . $u->id) }}" class="btn-table-action view-btn">Просмотр</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            
            <h3>Посты</h3>
            @php $posts = $group->posts ?? ($group['posts'] ?? collect()); @endphp
            @if(empty($posts) || $posts->isEmpty())
                <p class="alert alert-info">Нет постов в группе.</p>
            @else
                @foreach($posts as $p)
                    <div class="post-card">
                        <div class="post-meta">
                            {{-- Автор --}}
                            <div class="meta-item">
                                <strong>Автор:</strong>
                                @if(isset($p->user))
                                    <a href="{{ url('/user/' . $p->user->id) }}" class="meta-link">
                                        {{ $p->user->full_name ?? $p->user->name ?? ('User ' . $p->user->id) }}
                                    </a>
                                @else
                                    <span>(Удален)</span>
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