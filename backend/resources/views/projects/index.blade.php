@extends('layout')

@section('content')
    <h1>Projects</h1>

    <a href="{{ route('projects.create') }}">Create New Project</a>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <ul>
        @foreach ($projects as $project)
            <li>
                <a href="{{ route('projects.show', $project->id) }}">
                    {{ $project->name }}
                </a>

                <a href="{{ route('projects.edit', $project->id) }}">Edit</a>

                <form action="{{ route('projects.destroy', $project->id) }}"
                      method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
