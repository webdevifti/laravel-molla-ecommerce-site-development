@extends('admin.master')
@section('page_title','Admin | Edit Sub Category')
@section('MainContent')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Sub Categories</h1>
            <a href="{{ route('admin.subcategory') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h3>Edit Sub Categories</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.subcategory.update',$sub_category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mt-3">
                                <label for="">Category</label>
                                <select name="category_id" class="form-control" id="">
                                    <option value="">Choose Category</option>
                                    @foreach ($getCategories as $cat)
                                        <option {{ ($cat->id == $sub_category->category_id)? 'selected':'' }} value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="">Sub Category Name</label>
                                <input type="text" name="sub_category_name" class="form-control" placeholder="Enter Sub Category Name" value="{{ $sub_category->sub_category_name }}">
                                @error('sub_category_name')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('FooterScript')
@if(session('success'))
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '{{ session('success') }}'
    })
</script>
@endif
@if(session('error'))
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'error',
        title: '{{ session('error') }}',
    })
</script>
@endif
@endsection