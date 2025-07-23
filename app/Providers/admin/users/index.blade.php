@extends('layouts.app')

@section('title', 'Admin: Users')

@section('content')
    <form action="{{ route('admin.users')}}" method="get" class="mb-3">
        <input type="text" name="search" value="{{ $search }}" placeholder="search names" class="form-control form-control-sm w-auto ms-auto">
    </form>

    <table class="table border table-hover align-middle bg-white text-secondary">
        <thead class="text-secondary small text-uppercase table-success">
            <tr>
                <th></th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($all_users as $user)
                <tr>
                    {{-- avatar --}}
                    <td>
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="" class="rounded-circle image-md d-block mx-auto">
                        @else 
                            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-md"></i>
                        @endif 
                    </td>
                    {{-- user name --}}
                    <td>
                        <a href="{{ route('profile.show', $user->id)}}" class="text-decoration-none fw-bold text-dark">{{ $user->name }}</a>
                    </td>
                    {{-- email, etc. --}}
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    {{-- status --}}
                    <td>
                        @if($user->trashed())
                            <i class="fa-regular fa-circle"></i> Inactive
                        @else 
                            <i class="fa-solid fa-circle text-success"></i> Active
                        @endif 
                    </td>
                    {{-- button --}}
                    <td>
                        @if($user->id != Auth::user()->id)
                            <div class="dropdown">
                                <button class="btn btn-sm fw-bold" data-bs-toggle="dropdown">...</button>

                                <div class="dropdown-menu">
                                    @if($user->trashed())
                                        {{-- activate --}}
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate-user{{ $user->id }}">
                                            <i class="fa-solid fa-user-check"></i> Activate {{ $user->name }}
                                        </button>
                                    @else
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user{{ $user->id }}">
                                            <i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @include('admin.users.status')
                        @endif 
                    </td>
                </tr>
            @empty
                <tr><td class="text-center" colspan="6">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $all_users->links() }}
@endsection