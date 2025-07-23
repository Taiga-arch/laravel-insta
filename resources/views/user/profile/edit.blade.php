@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="{{ route('profile.update')}}" method="post" class="bg-white shadow rounded-3 p-5" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <h2 class="h4 mb-3 text-secondary">Update Profile</h2>
                <div class="row mb-3">
                    {{-- icon/avatar --}}
                    <div class="col-4">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="" class="rounded-circle image-xl">
                        @else
                        <i class="fa-solid fa-circle-user text-secondary icon-xl d-block text-center"></i>
                        @endif
                    </div>
                    <div class="col-auto align-self-end">
                        {{-- avatar --}}
                        <input type="file" name="avatar" class="form-control form-control-sm w-auto">
                        <p class="mb-0 form-text">
                            Acceptable formats: jpeg, jpg,png,gif only <br>
                            Max file size is 1048 KB
                        </p>
                        @error('avatar')
                            <p class="mb-0 text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- name --}}
                <label for="name" class="form-label fw-bold">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="form-control">
                @error('name')
                    <p class="mb-0 text-danger small">{{ $message }}</p>
                @enderror

                {{-- email --}}
                <label for="email" class="form-label fw-bold mt-3">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email)}}" class="form-control">
                @error('email')
                    <p class="mb-0 text-danger small">{{ $message }}</p>
                @enderror

               
               
               
                {{-- introduction --}}
                <label for="intro" class="form-label fw-bold mt-3">Introduction</label>
                <textarea name="introduction" id="intro" rows="3" class="form-control">{{ old('introduction', Auth::user()->introduction) }}</textarea>
                @error('introduction')
                    <p class="mb-0 text-danger small">{{ $message }}</p>
                @enderror

                <button type="submit" class="btn btn-warning mt-3 px-5">Save</button>
            </form>

            {{-- UPDATE PASSWORD --}}
            <form action="{{ route('profile.updatePassword')}}" method="post" class="bg-white shadow rounded-3 p-5 mt-5">
                @csrf
                @method('PATCH')

                @if(session('change_password_success'))
                    <p class="mb-3 text-success fw-bold">{{ session('change_password_success') }}</p>
                @endif

                <h3 class="h4 text-muted mb-3">Update Password</h3>

                <label for="old-password" class="form-label fw-bold">Old Password</label>
                <input type="password" name="old_password" id="old-password"
                class="form-control">
                @if(session('wrong_current_password'))
                     <p class="mb-0 text-danger small">{{ session('wrong_current_password') }}</p>
                @endif

                <label for="new-password" class="form-label fw-bold">New Password</label>
                <input type="password" name="new_password" id="new-password"
                class="form-control">
                @if(session('same_current_password'))
                    <p class="mb-0 text-danger small">{{ session('same_current_password') }}</p>
                @endif

                <label for="confirm-new" class="form-label fw-bold mt-3">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" id="new-password" class="form-control">
                @error('new_password')
                    <p class="mb-0 text-danger small">{{ $message }}</p>
                @enderror

                <button type="submit" class="btn btn-warning px-5 mt-3">Update Password</button>



            </form>
        </div>
    </div>

