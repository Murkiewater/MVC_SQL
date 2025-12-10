@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper"> 
        <h2>Группы</h2>

        @if($Groups->isEmpty())
            <p class="alert alert-info">Нет зарегистрированных групп.</p>
        @else
            <div class="main-content-area">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 10%">ID</th>
                            <th>Название</th>
                            <th style="width: 25%">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Groups as $g)
                            <tr>
                                <td>{{ $g->id ?? '-' }}</td>
                                
                                <td>
                                    <a href="{{ url('/group/' . ($g->id ?? '#')) }}" class="table-link">
                                        {{ $g->name ?? ('Group ' . ($g->id ?? '')) }}
                                    </a>
                                </td>
                                
                                <td style="white-space: nowrap;">
                                    <a href="{{ url('/group/' . ($g->id ?? '#')) }}" class="btn-table-action view-btn">
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