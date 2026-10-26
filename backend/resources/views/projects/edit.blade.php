@extends('layout')

@section('content')
    <h1>Edit Project</h1>

    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name:</label><br>
        <input type="text" name="name" value="{{ $project->name }}" required><br><br>

        <label>Description:</label><br>
        <textarea name="description">{{ $project->description }}</textarea><br><br>

        <label>Status:</label><br>
        <select name="status">
            <option value="open" {{ $project->status == 'open' ? 'selected' : '' }}>Open</option>
            <option value="closed" {{ $project->status == 'closed' ? 'selected' : '' }}>Closed</option>
            <option value="paused" {{ $project->status == 'paused' ? 'selected' : '' }}>Paused</option>
        </select><br><br>

        <button type="submit">Update</button>
    </form>

    <br>
    <a href="{{ route('projects.index') }}">Back</a>
@endsection
