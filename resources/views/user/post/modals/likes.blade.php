<div class="modal fade" id="likes-post{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button class="btn btn-sm fw-bold ms-auto" data-bs-dismiss="modal">X</button>
            </div>
            <div class="modal-body">
                <div class="px-5 w-75">
                    @foreach($post->likes as $like)
                        <div class="row align-items-center mx-5 mb-3">
                            <div class="col-auto">
                                @if($like->user->avatar)
                                    <img src="{{ $like->user->avatar }}" alt="" class="rounded-circle image-sm">
                                @else 
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </div>
                            <div class="col ps-0 text-truncate">
                                <a href="{{ route('profile.show', $like->user_id)}}" class="text-decoration-none fw-bold text-dark">{{ $like->user->name }}</a>
                            </div>
                            <div class="col-auto">
                                @if($like->user_id != Auth::user()->id)
                                    @if($like->user->isFollowed())
                                        <form action="{{ route('follow.destroy', $like->user_id)}}" method="post">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn p-0 shadow-none text-secondary">Unfollow</button>
                                        </form>
                                    @else 
                                        <form action="{{ route('follow.store', $like->user_id)}}" method="post">
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
        </div>
    </div>
</div>






