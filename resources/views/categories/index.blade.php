{{-- resources/views/categories/index.blade.php --}}
@extends('layouts.app')

@section('title', 'All Categories')

@section('content')
    <div class="container">
        <h1 class="mb-4">Categories</h1>

        {{-- Create new category --}}
        @auth
            @if (Auth::user()->isAdmin())
                <div class="text-end mb-3">
                    <a href="{{ route('category.admin.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-1"></i> Add New Category
                    </a>
                </div>
            @endif
        @endauth

        {{-- 成功メッセージの表示 --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- エラーメッセージの表示 (バリデーションエラーなど) --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        @if ($categories->isNotEmpty())
            <ul class="list-group">
                @foreach ($categories as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('category.show', $category->id) }}" class="text-decoration-none h5 mb-0">
                            {{ $category->name }}
                        </a>
                        <div class="d-flex align-items-center">
                            {{-- そのカテゴリーに属する投稿数を表示 (Optional) --}}
                            <span class="badge bg-primary rounded-pill px-3 py-2 me-5">{{ $category->posts->count() }} Posts</span>
                            @auth
                                @if (Auth::user()->isAdmin())
                                    <a href="{{ route('category.admin.edit', $category->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal-{{ $category->id }}">
                                        <i class="fa-solid fa-trash-can"></i> Delete
                                    </button>
                                @endif
                            @endauth
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">No categories found.</p>
        @endif
    </div>

    {{-- ★ここから追加：BootstrapモーダルのHTMLコード★ --}}
    @foreach ($categories as $category)
    <div class="modal fade" id="deleteCategoryModal-{{ $category->id }}" tabindex="-1" aria-labelledby="deleteCategoryModalLabel-{{ $category->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryModalLabel-{{ $category->id }}">Confirm Category Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Delete category "{{ $category->name }}"? This action cannot be undone.<br>** Note: Posts belonging to this category will not be deleted **
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('category.admin.destroy', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection