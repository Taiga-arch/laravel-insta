@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')
    <form action="{{ route('admin.categories.store')}}" method="post" class="mb-3">
        @csrf 
        <div class="d-flex">
            <input type="text" name="name" value="{{ old('name')}}" placeholder="Add a category..." class="form-control w-auto">
            <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-plus"></i> Add</button>
        </div>
        @error('name')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror
    </form>


    <table class="table table-sm border table-hover align-middle bg-white text-secondary text-center">
        <thead class="text-secondary small text-uppercase table-warning">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Count</th>
                <th>Last Updated</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($all_categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td class="text-dark">{{ $category->name }}</td>
                    <td>{{ $category->categoryPosts->count() }}</td>
                    <td>{{ $category->updated_at }}</td>
                    <td>
                        {{-- edit --}}
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#edit-categ{{ $category->id }}">
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                        {{-- delete --}}
                        <button class="btn btn-sm btn-outline-danger ms-1" data-bs-toggle="modal" data-bs-target="#delete-categ{{ $category->id }}">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>

                        @include('admin.categories.actions')
                    </td>
                </tr>
            @empty
                <tr><td class="text-center" colspan="5">No categories found.</td></tr>
            @endforelse
            <tr>
                <td>0</td>
                <td>Uncategorized</td>
                <td>{{ $uncategorized_count }}</td>
                <td></td><td></td>
            </tr>
        </tbody>
    </table>
    {{ $all_categories->links() }}
@endsection

        