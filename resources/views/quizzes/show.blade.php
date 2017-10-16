@extends('layouts.app')

@push('head')
    <meta name="description" content="{{ $title }}">
@endpush

@section('content')
    <div class="pull-right">
        <a href="{{ route('quizzes.edit', $quiz) }}" class="btn btn-default">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    </div>

    <h1>{{ $quiz->title }}</h1>

    @foreach ($quiz->queries as $qq)
        <div class="panel panel-default">
            <div class="panel-heading">
                Points: {{ $qq->pivot->points }}
            </div>
            <div class="panel-body">
                {{ $qq->description }}
            </div>
        </div>
    @endforeach
@endsection
