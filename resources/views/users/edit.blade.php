    @extends('layouts.app')

    @section('title', $user->name)
        
    @section('content')
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="row mt-2 mb-3">
                <div class="col-5">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->avatar }}" class="img-thumbnail w-100">
                    @else
                        <i class="fas fa-image fa-10x d-block text-center"></i>
                    @endif

                    <input type="file" name="avatar" id="avatar" aria-describedby="avatar-info" class="form-control mt-1">
                    <div class="form-text" id="avatar-info">
                        Acceptable formats are jpeg, jpg, png, gif only<br>
                        Maximum file size is 1048kb.
                    </div>
                    {{-- Error --}}
                    @error('avatar')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-2">
                <label for="name" class="form-label text-secondary">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control">
                {{-- Error --}}
                @error('name')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="email" class="form-label text-secondary">Email Address</label>
                <input type="text" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control">
                {{-- Error --}}
                @error('email')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>
        {{-- パスワード変更用のセクションをここに追加 --}}
        <p class="mt-4 mb-2 text-secondary bg-warning text-center">Change Password (Optional)</p>
        <div class="mb-2">
            <label for="password" class="form-label text-secondary">New Password</label>
            <input type="password" name="password" id="password" class="form-control">
            {{-- Error --}}
            @error('password')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="form-label text-secondary">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            {{-- Error --}}
            @error('password_confirmation') 
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

            <button type="submit" class="btn btn-warning px-5">Save</button>
        
        </form>
        
    @endsection
