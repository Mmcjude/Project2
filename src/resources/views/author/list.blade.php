@extends('layout')

@section('content')
    <h1>{{ $title }}</h1>

    <!-- Success Flash Message -->
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
                @foreach($items as $author)
                    <tr>
                        <td>{{ $author->id }}</td>
                        <td>{{ $author->name }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="/authors/update/{{ $author->id }}" class="btn btn-primary btn-sm">Edit</a>

                            <!-- Delete Button with Confirmation -->
                            <form action="/authors/{{ $author->id }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this author?');">
                                @csrf
                                @method('DELETE') <!-- Correct HTTP method -->
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No authors found.</p>
    @endif

    <a href="/authors/create" class="btn btn-success mt-3">Add New Author</a>
@endsection
