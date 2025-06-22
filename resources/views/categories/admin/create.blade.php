{{-- resources/views/categories/admin/create.blade.php --}}
@extends('layouts.app') {{-- レイアウトファイルを継承 --}}

@section('title', 'Category Creation') {{-- ページのタイトル --}}

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Create new category</h3>
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

                        <form action="{{ route('category.admin.store') }}" method="POST">
                            @csrf {{-- LaravelのCSRF保護のため必須 --}}

                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Add</button>
                            <a href="{{ route('category.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection