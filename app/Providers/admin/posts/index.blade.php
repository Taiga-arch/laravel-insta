@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
    <table class="table border table-hover align-middle bg-white text-secondary">
        <thead class="text-secondary small text-uppercase table-primary">
            <tr>
                <th></th>
                <th></th>
                <th>Category</th>
                <th>Owner</th>
                <th>Created At</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($all_posts as $post)
                <tr>
                    <td class="text-center">{{ $post->id }}</td>
                    <td>
                        <a href="{{ route('post.show', $post->id)}}">
                            <img src="{{ $post->image }}" alt="" class="image-lg">
                        </a>
                    </td>
                    <td>
                        {{-- categories --}}
                        @forelse($post->categoryPosts as $category_post)
                            <div class="badge bg-secondary bg-opacity-50">{{ $category_post->category->name }}</div>
                        @empty 
                            Uncategorized
                        @endforelse
                    </td>
                    <td>
                        <a href="{{ route('profile.show', $post->user_id)}}" class="text-decoration-none text-dark">{{ $post->user->name }}</a>
                    </td>
                    <td>{{ $post->created_at }}</td>
                    <td>
                        {{-- status --}}
                        @if($post->trashed())
                            <i class="fa-solid fa-circle-minus"></i> Hidden
                        @else
                            <i class="fa-solid fa-circle text-primary"></i> Visible
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm" data-bs-toggle="dropdown">...</button>

                            <div class="dropdown-menu">
                                @if($post->trashed())
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#unhide-post{{ $post->id }}">
                                        <i class="fa-solid fa-eye"></i> Unhide Post {{ $post->id }}
                                    </button>
                                @else 
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post{{ $post->id }}">
                                        <i class="fa-solid fa-eye-slash"></i> Hide Post {{ $post->id }}
                                    </button>
                                @endif 
                            </div>
                        </div>
                        @include('admin.posts.status')
                    </td>
                </tr>
            @empty
                <tr><td class="text-center" colspan="7">No posts found.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $all_posts->links() }}
@endsection