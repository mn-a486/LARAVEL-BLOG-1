@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container">
        <h1 class="mb-4">All Posts</h1>
            @forelse ($all_posts as $post)
                <div class="mt-2 border border-2 rouded p-4">
                    <a href="{{ route('post.show', $post->id) }}">
                        <h2 class="h4">{{ $post->title }}</h2>
                    </a>
                    <h3 class="h6 text-secondary">
                       by <a href="{{ route('profile.see', $post->user->id) }}" class="text-decoration-none text-secondary">{{ $post->user->name }}</a>
                    </h3>
                                            
                    <p class="fw-light mb-0" style="word-wrap: break-word;">
                        {{ Str::limit($post->body, 150) }}
                        @if (Str::length($post->body) > 150)
                            <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none">See More</a>
                        @endif
                    </p>
                    <div class="col-4">
                        @if ($post->image)
                            <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="img-thumbnail w-100">
                        @endif
                    </div>
                    <p class="mt-3"><strong>Categories:</strong>
                        @foreach ($post->categories as $category)
                            <span class="badge bg-secondary">{{ $category->name }}</span>
                        @endforeach
                    </p>

                    {{-- action buttons --}}
                    @if (Auth::user()->id == $post->user_id)
                    <div class="me-2 text-end">
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-pen"></i> Edit
                        </a>


                            {{-- <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fa-solid fa-trash-can"></i> Delete</button> --}}
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $post->id }}">
                        <i class="fas fa-trash-can"></i> Delete
                        </button>
                        </form>
                    </div>

                                {{-- モーダル（Pop up) --}}
                    <div class="modal fade" id="editModal{{ $post->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $post->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                        <form action="{{ route('post.delete', $post->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $post->id }}">Delete Post</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center">Do you want to delete this post?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endif
                </div>
            @empty
                <div class="text-center" style="margin-top: 100px">
                    <h2 class="text-secondary">No Posts Yet</h2>
                    <a href="{{ route('post.create') }}" class="text-decoration-none">Create a new post</a>
                </div>
            @endforelse
    </div>
@endsection