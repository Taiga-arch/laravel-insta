@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row gx-5">
        <div class="col-8">
            @if($search)
                <h2 class="h4 text-muted mb-3">Search results for "<span class="fw-bold">{{ $search }}</span>" </h2>
            @endif
            {{-- posts --}}
        @forelse($all_posts as $post)
            <div class="card mb-4">
                @include('user.post.contents.title')
                {{-- image --}}
                <div class="container p-0">
                    <a href="{{ route('post.show', $post->id)}}">
                        <img src="{{ $post->image }}" alt="" class="w-100">
                    </a>
                </div>
                {{-- body --}}
                <div class="card-body">
                    @include('user.post.contents.body')

                    {{-- comments --}}
                    @if($post->comments->isNotEmpty())
                        <hr class="mt-3">
                        @foreach($post->comments->take(3) as $comment)
                            @include('user.post.comments.list-item')

                        @endforeach
                        @if($post->comments->count() > 3)
                            <a href="{{ route('post.show',$post->id)}}" class="text-decoration-none small">
                                View all {{ $post->comments->count() }} comments
                            </a>
                        @endif
                    @endif
                    @include('user.post.comments.create')
                </div>
            </div>
        @empty
            <div class="text-center">
                <h2>Share Photos</h2>
                <p class="text-muted">When you share photos, they'll appear on your profile.</p>
                <a href="{{ route('post.create')}}" class="text-decoration-none">Share your first photo</a>
            </div>
        @endforelse
    </div>
    <div class="col-4">
        {{-- user info --}}
        <div class="row mb-5 shadow-sm bg-white py-3 align-items-center">
            <div class="col-auto">
                <a href="{{ route('profile.show', Auth::user()->id)}}">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="" class="rounded-circle image-md">
                    @else
                         <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                    @endif
                </a>
            </div>
            <div class="col ps-0">
                <a href="{{ route('profile.show', Auth::user()->id)}}" class="text-decoration-none text-dark fw-bold">{{ Auth::user()->name }}</a>
                <p class="mb-0 text-muted small">{{ Auth::user()->email }}</p>
            </div>
        </div>

        {{-- suggestions --}}
        @if($suggested_users)
            <div class="row mb-3">
                <div class="col"><p class="mb-0 text-secondary">Suggestions For You</p></div>
                <div class="col-auto">
                    {{-- see all --}}
                    <a href="{{ route('suggestedUsers')}}" class="text-decoration-none fw-bold text-dark">See all</a>
                </div>
            </div>

            {{-- list suggested users --}}
            @foreach($suggested_users as $user)
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $user->id)}}">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="" class="rounded-circle image-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                            <a href="{{ route('profile.show', $user->id)}}"
                             class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('follow.store', $user->id)}}" method="post">
                            @csrf
                            
                            <button type="submit" class="btn p-0 shadow-none text-primary">Follow</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@endsection
