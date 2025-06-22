@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    
    <div class="mb-3">
        <label for="title" class="form-label text-secondary">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholader="Enter title here" autofocus>
        {{-- error --}}
        @error('title')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label for="body" class="form-label text-secondary">Body</label>
        <textarea name="body" id="body" rows="10" class="form-control" placeholder="Start writing...">{{ old('body') }}</textarea>
        {{-- error --}}
        @error('body')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label for="image" class="form-label text-secondary">Image</label>
        <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
        <div class="form-text" id="image-info">
            Acceptable formats are jpeg, jpg, png, gif only.<br>
            Maximum file size is 1048kb.
        </div>
        {{-- error --}}
        @error('image')
            <p class="text-danger small mb-0">{{ $message }}</p>
            {{-- 画像ファイル自体のエラーメッセージに続いて表示 --}}
            <p class="text-danger small">* Please select the image file again.</p>
        @else
            {{-- 画像ファイル自体にエラーはないが、他のエラーでページが再読み込みされた場合 --}}
            @if ($errors->any())
                <p class="text-danger small">* Please select the image file again.</p>
            @endif
        @enderror
    </div>

    <div class="mb-3">
    <label for="category_id" class="form-label text-secondary">Category</label><br>
        @foreach ($categories as $category)
            <label class="form-check form-check-inline">
                <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="form-check-input"
                       {{-- old('categories')は配列なのでin_arrayでチェック --}}
                       {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                <span class="form-check-label">{{ $category->name }}</span>
            </label><br>
        @endforeach
        {{-- error --}}
        @error('categories')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary px-5">Post</button>
    </form>

    @endsection