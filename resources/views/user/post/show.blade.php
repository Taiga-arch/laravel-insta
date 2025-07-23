@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
    <style>
        .col-4 {
            overflow-y:scroll;
        }
        .card-body {
            position:absolute;
            top:65px;
        }
    </style>
    <div class="row shadow border">
        <div class="col p-0 border-end">
            {{-- image --}}
            <img src="{{ $post->image }}" alt="" class="w-100">
        </div>
        <div class="col-4 px-0 bg-white">
            <div class="card border-0">
                @include('user.post.contents.title')
                <div class="card-body w-100">
                    @include('user.post.contents.body')

                    {{-- comments --}}
                    @include('user.post.comments.create')

                    @foreach($post->comments as $comment)
                        @include('user.post.comments.list-item')

                    @endforeach
                </div>
            </div>
        </div>
    </div>


@endsection
