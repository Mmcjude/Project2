@extends('layout')

@section('content')
<h1>{{ $title }}</h1>

@if (count($items) > 0)
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Year</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>{{ $book->name }}</td>
                    <td>{{ $book->author->name }}</td>
                    <td>{{ $book->genre->name }}</td>
                    <td>{{ $book->year }}</td>
                    <td>{{ $book->price }}</td>
                    <td>
                        <a href="/books/edit/{{ $book->id }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="/books/{{ $book->id }}/delete" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No books found.</p>
@endif
<a href="/books/create" class="btn btn-success">Add New Book</a>
@endsection
