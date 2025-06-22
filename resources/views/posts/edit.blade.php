@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="title" class="form-label text-secondary">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title) }}" autofocus>
            @error('title')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="body" class="form-label text-secondary">Body</label>
            <textarea name="body" id="body" cols="30" rows="10" class="form-control">{{ old('body', $post->body) }}</textarea>
            @error('body')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label for="image" class="form-label text-secondary">Image</label>
                <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="w-100 img-thumbnail">
                <input type="file" name="image" id="image" class="form-control mt-1">
            </div>
            <div class="form-text" id="image-info">
                Acceptable formats are jpeg, jpg, png, gif only.<br>
                Maximum file size is 1048kb.
            </div>
                @error('image')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label text-secondary">Categories</label><br>
                @foreach ($categories as $category)
                    <label>
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                            {{ $post->categories->contains($category->id) ? 'checked' : '' }}>
                        {{ $category->name }}
                    </label><br>
                @endforeach
        </div>
        <button type="submit" class="btn btn-warning px-5">Save</button>
    </form>
@endsection