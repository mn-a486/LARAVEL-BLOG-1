{{-- resources/views/categories/admin/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Category: ' . $category->name)

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Edit Category: {{ $category->name }}</h3>
                    </div>
                    <div class="card-body">
                        {{-- エラーメッセージ表示エリア --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- PATCHメソッドを使って更新 --}}
                        <form action="{{ route('category.admin.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PATCH') {{-- PATCHメソッドを使うため --}}

                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $category->name) }}" autofocus> {{-- old()でエラー時に値を保持、なければ$category->nameを表示 --}}
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Edit</button>
                            <a href="{{ route('category.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection