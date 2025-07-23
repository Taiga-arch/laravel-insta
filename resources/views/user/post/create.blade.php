@extends('layouts.app')

@section('title', 'Create Post')

@section('content') 
    <form action="{{ route('post.store')}}" method="post" enctype="multipart/form-data">
        @csrf

        <p class="fw-bold">Category <span class="fw-light fs-italic">(up to 3)</span></p>
        <div>
            @forelse($all_categories as $category)
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="categories[]" id="categ_{{ $category->name }}" value="{{ $category->id }}" class="form-check-input">
                    <label for="categ_{{ $category->name }}" class="form-label">{{ $category->name }}</label>
                </div>
            @empty
                <span class="fs-italic">No categories found.Please contact admin to add categories.</span>

            @endforelse
        </div>
        @error('categories')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror

    
        <label for="description" class="form-label fw-bold mt-3">Description</label>
        <textarea name="description" id="desciption" rows="3" placeholder="What's on your mind" class="form-control">{{old('description') }}</textarea>
        @error('description')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror
        

        <label for="image" class="form-label fw-bold mt-3">Image</label>
        <input type="file" name="image" id="image" class="form-control">
        <p class="mb-0 form-text">
            Acceptable formats:jpeg, jpg, png, gif only <br>
            Max size is 1048 KB
        </p>
        @error('image')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror
    
        <button type="submit" class="btn btn-primary px-4 mt-4">Post</button>
    </form>

@endsection
