@extends('layouts.app')

@section('title', $user->name)

@section('content')
    @include('user.profile.header')

    @if($user->followers->isNotEmpty())
        <h3 class="h5 text-center text-muted">Followers</h3>

        <div class="row justify-content-center">
            <div class="col-4">
                @foreach($user->followers as $follow)
                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            {{-- icon/avatar --}}
                            <a href="{{ route('profile.show', $follow->follower->id)}}">
                                @if($follow->follower->avatar)
                                    <img src="{{ $follow->follower->avatar }}" alt="" class="rounded-circle image-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0 text-truncate">
                            {{-- user name --}}
                            <a href="{{ route('profile.show', $follow->follower_id)}}" class="text-decoration-none text-dark">{{ $follow->follower->name }}</a>
                        </div>
                        <div class="col-auto">
                            {{-- button --}}
                            @if($follow->follower->id != Auth::user()->id)
                                @if($follow->follower->isFollowed())
                                    {{-- unfollow --}}
                                    <form action="{{ route('follow.destroy', $follow->follower->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 shadow-none text-secondary">Following</button>
                                    </form>
                                @else
                                    {{-- follow --}}
                                    <form action="{{ route('follow.store', $follow->follower->id)}}" method="post">
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
        <h3 class="h5 text-center text-muted">No followers.</h3>

    @endif

@endsection