@extends('layouts.app')

@section('title', 'Search Results for "' . $keyword . '"')

@section('content')
    <h1 class="h3 mb-4">Search Results for "{{ $keyword }}"</h1>

    @if ($posts->isNotEmpty())
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h5 card-title"><a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a></h2>
                            <h3 class="h6 card-subtitle text-muted mb-2">by <a href="{{ route('profile.see', $post->user->id) }}" class="text-decoration-none text-secondary">{{ $post->user->name }}</a></h3>
                            <p class="card-text">{{ Str::limit($post->body, 100) }}</p>
                            @if ($post->image)
                                <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="img-fluid rounded w-50 d-block mx-auto mt-2">
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
        </div>
    @else
        <p class="text-muted">No posts found matching "{{ $keyword }}".</p>
    @endif
@endsection