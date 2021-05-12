@extends('layouts.app')

@section('content')

    {{--タスク一覧--}}
    @include('tasks.index')

<h1>タスク一覧</h1>

{{--
    @if (count($tasks) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>タスク</th>
                    <th>ステータス</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    {{-- タスク詳細ページへのリンク --}}
                    
{{--
                    <td>{!! link_to_route('tasks.show', $tasks->id, ['task' => $tasks->id]) !!}</td>
                    <td>{{ $tasks->content }}</td>
                    <td>{{ $tasks->status}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    
    {{-- タスク作成ページへのリンク --}}
    
{{--
    
    {!! link_to_route('tasks.create', '新規メッセージの投稿', [], ['class' => 'btn btn-primary']) !!}
    
    --}}

@endsection