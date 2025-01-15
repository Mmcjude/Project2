@extends('layout')

@section('content')
<h1>{{ $title }}</h1>

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
                        <a href="/genres/edit/{{ $genre->id }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="/genres/delete/{{ $genre->id }}" method="POST" class="d-inline">
                            @csrf
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
<a href="/genres/create" class="btn btn-success">Add New Genre</a>
@endsection
