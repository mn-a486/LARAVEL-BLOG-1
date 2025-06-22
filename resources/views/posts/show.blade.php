@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
    <div class="mt-2 border border-2 rouded p-4 shadow-sm">
        <h2 class="h4">{{ $post->title }}</h2>
        <h3 class="h6 text-secondary">
           by <a href="{{ route('profile.see', $post->user->id) }}" class="text-decoration-none text-secondary">{{ $post->user->name }}</a>
        </h3>
        <p class="fw-light" style="word-wrap: break-word;">{{ $post->body }}</p>

        <img src="{{ asset('storage/images/' . $post->image)}}" alt="{{ $post->image }}" class="w-75 shadow-rouded text-center">
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



    <form action="{{ route('comment.store', $post->id) }}" method="post">
        @csrf

        <div class="input-group mt-5">
            <input type="text" name="comment" id="comment" placeholder="Add a comment..." value="{{ old('comment') }}" class="form-control">
            <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
        </div>
        {{-- Error --}}
        @error('comment')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </form>

    {{-- if the post has comments, show all comments --}}
    @if ($post->comments)
        <div class="mt-2 mb-5">
            @foreach ($post->comments as $comment)
                <div class="row p-2">
                    <div class="col-10">
                        <span class="fw-bold">{{ $comment->user->name }}</span>
                        <span class="small text-muted">{{ $comment->created_at }}</span>
                        <p class="mb-0" style="word-wrap: break-word;">{{ $comment->body }}</p>
                    </div>
                    <div class="text-end">
                        @if (Auth::user()->id == $comment->user->id)
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $comment->id }}">
                                <i class="fas fa-pen"></i> Edit
                            </button>

                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $comment->id }}">
                                <i class="fas fa-trash-can"></i> Delete
                            </button>

                            </form>
                            {{-- モーダル（Pop up) Edit Comment --}}
                            <div class="modal fade" id="editModal{{ $comment->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $comment->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="editCommentForm{{ $comment->id }}" action="{{ route('comment.update', $comment->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $comment->id }}">Edit Comment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <textarea name="edit_comment" class="form-control" rows="4">{{ old('edit_comment', $comment->body) }}</textarea>
                                                {{-- Error --}}
                                                @error('edit_comment') 
                                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Save</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- モーダル（Pop up) Delete Comment --}}
                            <div class="modal fade" id="deleteModal{{ $comment->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $comment->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $comment->id }}">Delete Comment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center">Do you want to delete this comment?</p>
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
                </div>          
            @endforeach

            {{-- モーダルを自動で開くためのJavaScript--}}
            @if($errors->has('edit_comment') && session()->has('open_edit_modal'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const modalElement = document.getElementById('editModal{{ session('open_edit_modal') }}');
                        if (modalElement) {
                            new bootstrap.Modal(modalElement).show();
                        }
                    });
                </script>
            @endif

        </div>
        
    @endif
    
@endsection