@extends('layout')

@section('content')
    <h1>{{ $title }}</h1>

    <form action="{{ isset($genre->id) ? '/genres/patch/'.$genre->id : '/genres/put' }}" method="POST">
        @csrf
        @if (isset($genre->id))
            @method('PATCH')
        @endif
        <div class="mb-3">
            <label for="genre-name" class="form-label">Genre Name</label>
            <input type="text" name="name" id="genre-name" class="form-control" value="{{ old('name', $genre->name ?? '') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($genre->id) ? 'Update Genre' : 'Create Genre' }}</button>
    </form>
@endsection
