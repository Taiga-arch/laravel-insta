<div class="mt-2">
    <a href="{{ route('profile.show', $comment->user_id)}}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
    &nbsp;
    <span>{{ $comment->body }}</span>
    <div>
        <span class="text-muted xsmall">{{ date('D,M d Y',strtotime($comment->created_at)) }}</span>
        {{-- delete --}}
        @if($comment->user_id == Auth::user()->id)
            <form action="{{ route('comment.destroy', $comment->id)}}" method="post" class="d-inline">
                @csrf
                @method('DELETE')
                &middot;
                <button type="submit" class="btn xsmall p-0 text-danger shadow-none">Delete</button>
            </form>
        @endif
    </div>
</div>