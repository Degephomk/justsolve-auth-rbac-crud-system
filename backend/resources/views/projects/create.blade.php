@extends('layout')

@section('content')
    <h1>Create Project</h1>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Description:</label><br>
        <textarea name="description"></textarea><br><br>

        <label>Status:</label><br>
        <select name="status">
            <option value="open">Open</option>
            <option value="closed">Closed</option>
            <option value="paused">Paused</option>
        </select><br><br>

        <button type="submit">Save</button>
    </form>

    <br>
    <a href="{{ route('projects.index') }}">Back</a>
@endsection
