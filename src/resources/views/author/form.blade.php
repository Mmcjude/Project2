@extends('layout')

@section('content')

<h1>{{ $title }}</h1>

@if ($errors->any())
    <div class="alert alert-danger">Please fix the errors!</div>
@endif

<form method="post" action="{{ $author->exists ? '/authors/patch/' . $author->id : '/authors/put' }}">
    @csrf

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

    <button type="submit" class="btn btn-primary">Save</button>
</form>

@endsection
