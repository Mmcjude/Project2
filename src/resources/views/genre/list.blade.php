@extends('layout')

@section('content')
    <h1>{{ $title }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (count($items) > 0)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $genre)
                    <tr>
                        <td>{{ $genre->id }}</td>
                        <td>{{ $genre->name }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="/genres/edit/{{ $genre->id }}" class="btn btn-primary btn-sm">Edit</a>

                            <!-- Delete Button with Form -->
                            <form action="/genres/delete/{{ $genre->id }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this genre?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No genres found.</p>
    @endif

    <a href="/genres/create" class="btn btn-success mt-3">Add New Genre</a>
@endsection
