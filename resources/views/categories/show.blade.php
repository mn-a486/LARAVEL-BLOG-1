{{-- resources/views/categories/show.blade.php --}}
@extends('layouts.app')

@section('title', $category->name . ' Category')

@section('content')
    <div class="container">
        <h1 class="mb-4">Posts in "{{ $category->name }}" Category</h1>

        @if ($posts->isNotEmpty())
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h5 card-title">
                                    <a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                                </h2>
                                {{-- カテゴリーの表示 (Optional: 各記事にどのカテゴリーが紐付いているか) --}}
                                <div class="mb-2">
                                    @forelse ($post->categories as $postCategory)
                                        <span class="badge bg-secondary me-1">{{ $postCategory->name }}</span>
                                    @empty
                                        <span class="badge bg-light text-muted">No Category</span>
                                    @endforelse
                                </div>
                                <h3 class="h6 card-subtitle text-muted mb-2">
                                    by <a href="{{ route('profile.see', $post->user->id) }}" class="text-decoration-none text-secondary">{{ $post->user->name }}</a>
                                </h3>
                                <p class="card-text">
                                    {{ Str::limit($post->body, 100) }}
                                    @if (strlen($post->body) > 100)
                                        <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none">See More</a>
                                    @endif
                                </p>
                                @if ($post->image)
                                    <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="img-fluid rounded w-50 d-block mx-auto mt-2">
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ページネーションリンク --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links() }}
            </div>
        @else
            <p class="text-muted">No posts found in the "{{ $category->name }}" category.</p>
        @endif
    </div>
@endsection