@extends('layouts.app')

@section('content')
<h1>Посты в группах</h1>

<a href="{{ route('post-in-groups.create') }}" class="btn btn-success mb-3">Создать новый пост</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
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
            <td>
                <form action="{{ route('post-in-groups.edit', $p) }}" method="GET" style="display:inline;">
                    <button type="submit" class="btn btn-sm btn-primary">
                        Редактировать
                    </button>
                </form>

                <form action="{{ route('post-in-groups.destroy', $p) }}" 
                      method="POST" 
                      style="display:inline"
                      onsubmit="return confirm('Удалить этот пост?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        Удалить
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $posts->links() }}
@endsection
