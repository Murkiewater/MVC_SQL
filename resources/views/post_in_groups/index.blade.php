@extends('layouts.app')

@section('content')

@if(session('message'))
    <div class="alert alert-error">
        {{ session('message') }}
    </div>
@endif
<h2>Посты</h2>

<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Пользователь</th>
            <th>Группа</th>
            <th>Текст</th>
            <th>Дата</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
    @foreach($posts as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ optional($p->user)->full_name ?? '—' }}</td>
            <td>{{ optional($p->group)->name ?? '—' }}</td>
            <td>{{ Str::limit($p->text, 80) }}</td>
            <td>{{ \Carbon\Carbon::parse($p->date_of_post)->format('d.m.Y H:i') }}</td>
            <td style="white-space: nowrap;">
                
                <form action="{{ route('post-in-groups.edit', $p) }}" method="GET">
                    <button type="submit" class="btn-action btn-action-edit">
                        Редактировать
                    </button>
                </form>

                <form action="{{ route('post-in-groups.destroy', $p) }}" 
                      method="POST" 
                      style="display:inline"
                      onsubmit="return confirm('Удалить этот пост?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-action-delete">
                        Удалить
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<a href="{{ route('post-in-groups.create') }}" class="btn-custom">
    Создать новый пост
</a>

{{ $posts->links() }}
@endsection