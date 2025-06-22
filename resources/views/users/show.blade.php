@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <div class="container">
        <h1 class="mb-4">Profile</h1>
            <div class="row mt-2 mb-5">
                <div class="col-4">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->avatar }}" class="img-thumbnail w-100">
                    @else
                        <i class="fas fa-image fa-10x d-block text-center"></i>
                    @endif
                </div>
                <div class="col-8">
                    <h2 class="display-6">{{ $user->name }}</h2>
                    @if (Auth::user()->id == $user->id)
                    <a href="{{ route('profile.edit') }}" class="text-decoration-none">Edit Profile</a>
                    @endif
                </div>
            </div>

            @if ($user->posts->isNotEmpty())
                <ul class="list-group">
                    @foreach ($user->posts as $post)
                        <li class="list-group-item py-4">
                            <a href="{{ route('post.show', $post->id) }}">
                                <h3 class="h4">{{ $post->title }}</h3>
                            </a>
                            <p class="fw-light mb-0" style="word-wrap: break-word;">
                                @php
                                    $displayBody = Str::limit($post->body, 150); // 200文字で制限
                                @endphp
                                {{ $displayBody }}
                                @if (Str::length($post->body) > 150)
                                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none">See More</a>
                                @endif
                            </p>
                            <div class="col-4">
                                @if ($post->image)
                                    <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="img-thumbnail w-100">
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else {{-- ★追加: 投稿がない場合のメッセージ --}}
                <p class="text-muted text-center mt-3">There are no posts yet.</p>
            @endif
    </div>
@endsection