@extends('layout')

@section('content')

<h1>{{ $title }}</h1>

@if ($errors->any())
    <div class="alert alert-danger">Please fix the errors!</div>
@endif

<!-- Form for creating or editing an author -->
<form method="post" action="{{ $author->exists ? '/authors/' . $author->id : '/authors' }}">
    @csrf

    <!-- Author Name Field -->
    <div class="mb-3">
        <label for="author-name" class="form-label">Author Name</label>
        <input
            type="text"
            id="author-name"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $author->name) }}">
        @error('name')
            <p class="invalid-feedback">{{ $errors->first('name') }}</p>
        @enderror
    </div>

    <!-- Submit Button (Save) -->
    <button type="submit" class="btn btn-primary">Save</button>
</form>

<!-- Delete form for authors -->
@if($author->exists)
    <form action="/authors/{{ $author->id }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this author?');">
        @csrf
        @method('DELETE') <!-- This will ensure the form uses the DELETE HTTP method -->
        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
    </form>
@endif

@endsection
