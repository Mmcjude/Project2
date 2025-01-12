@extends('layout')

@section('content')
    <h1>Genres</h1>
    <a href="/genres/create" class="btn btn-primary">Create Genre</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($genres as $genre)
                <tr>
                    <td>{{ $genre->name }}</td>
                    <td>
                        <a href="/genres/edit/{{ $genre->id }}" class="btn btn-warning">Edit</a>
                        <form action="/genres/delete/{{ $genre->id }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
