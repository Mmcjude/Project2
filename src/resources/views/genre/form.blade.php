@extends('layout')

@section('content')
    <h1>{{ $title }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">Please fix the validation errors!</div>
    @endif

    <form method="post" action="{{ $genre->exists ? '/genres/patch/' . $genre->id : '/genres' }}">
        @csrf

        @if($genre->exists)
            @method('PATCH') <!-- This ensures that the form is treated as a PATCH request for updating -->
        @endif

        <div class="mb-3">
            <label for="genre-name" class="form-label">Name</label>
            <input
                type="text"
                id="genre-name"
                name="name"
                value="{{ old('name', $genre->name) }}"
                class="form-control @error('name') is-invalid @enderror">
            @error('name')
                <p class="invalid-feedback">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            {{ $genre->exists ? 'Update' : 'Create' }}
        </button>
    </form>
@endsection
