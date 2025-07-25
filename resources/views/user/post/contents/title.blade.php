<div class="card-header bg-white py-3">
    <div class="row align-items-center">
      <div class="col-auto">
            {{-- icon/avatar of post owner --}}
            <a href="{{ route('profile.show', $post->user->id)}}">
                @if($post->user->avatar)
                    <img src="{{ $post->user->avatar }}" alt="" class="rounded-circle image-sm">
                @else
                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                @endif
            </a>
       </div>
        <div class="col ps-0">
            {{-- powt owner's name --}}
            <a href="{{ route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark">
                {{ $post->user->name }}
            </a>
        </div>
        <div class="col-auto">
            {{-- button --}}
            <div class="dropdown">
                <button class="btn btn-sm" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis"></i> {{-- ... --}}
                </button>

                @if($post->user->id == Auth::user()->id)
                    {{-- post owner is logged in --}}
                    <div class="dropdown-menu">
                        {{-- edit --}}
                        <a href="{{ route('post.edit', $post->id)}}" class="dropdown-item">
                            <i class="fa-regular fa-pen-to-square"></i>Edit
                        </a>
                        {{-- delete --}}
                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post{{ $post->id }}">
                            <i class="fa-regular fa-trash-can"></i>Delete
                        </button>
                    </div>
                    {{-- modal window (div) --}}
                    @include('user.post.modals.delete')
                @else

                    <div class="dropdown-menu">
                        @if($post->user->isFollowed())
                            {{-- unfollow --}}
                         <form action="{{ route('follow.destroy', $post->user->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger">Unfollow</button>
                         </form>
                        @else
                            {{-- follow --}}
                            <form action="{{ route('follow.store', $post->user->id)}}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item text-primary">Follow</button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>