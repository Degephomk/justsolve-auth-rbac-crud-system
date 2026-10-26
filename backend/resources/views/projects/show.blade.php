@extends('layout')

@section('content')
    <h1>{{ $project->name }}</h1>

    <p>{{ $project->description }}</p>
    <p>Status: <strong>{{ $project->status }}</strong></p>

    <a href="{{ route('projects.edit', $project->id) }}">Edit</a><br><br>

    <a href="{{ route('projects.index') }}">Back</a>
@endsection
