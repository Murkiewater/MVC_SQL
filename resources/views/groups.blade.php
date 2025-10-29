@extends('layouts.app')

@section('content')
    <h2>Группы</h2>
    @if($Groups->isEmpty())
        <p>Нет групп.</p>
    @else
        @foreach($Groups as $g)
            <div class="card" style="padding:10px;margin-bottom:8px;">
                <a href="{{ url('/group/' . ($g->id ?? '#')) }}">
                    <strong>{{ $g->name ?? ('Group ' . ($g->id ?? '')) }}</strong>
                </a>
                <div style="font-size:13px;color:#666">id: {{ $g->id ?? '-' }}</div>
            </div>
        @endforeach
    @endif
@endsection
