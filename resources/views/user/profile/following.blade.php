@extends('layouts.app')

@section('title', $user->name)

@section('content')
    @include('user.profile.header')

    @if($user->follows->isNotEmpty())
        <h3 class="h5 text-center text-muted">Following</h3>

        <div class="row justify-content-center">
            <div class="col-4">
                @foreach($user->follows as $follow)
                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            {{-- icon/avatar --}}
                            <a href="{{ route('profile.show', $follow->following->id)}}">
                                @if($follow->following->avatar)
                                    <img src="{{ $follow->following->avatar }}" alt="" class="rounded-circle image-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0 text-truncate">
                            {{-- user name --}}
                            <a href="{{ route('profile.show', $follow->following_id)}}" class="text-decoration-none text-dark">{{ $follow->following->name }}</a>
                        </div>
                        <div class="col-auto">
                            {{-- button --}}
                            @if($follow->following->id != Auth::user()->id)
                                @if($follow->following->isFollowed())
                                    {{-- unfollow --}}
                                    <form action="{{ route('follow.destroy', $follow->following->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 shadow-none text-secondary">Following</button>
                                    </form>
                                @else
                                    {{-- follow --}}
                                    <form action="{{ route('follow.store', $follow->following->id)}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn p-0 shadow-none text-primary">Follow</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @else
        <h3 class="h5 text-center text-muted">Not following anyone.</h3>

    @endif

@endsection