@extends('admin.master')
@section('page_title','Admin | Edit Sub Category')
@section('MainContent')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Color</h1>
            <a href="{{ route('admin.color') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h3>Edit Color</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.color.update',$color->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mt-3">
                                <label for="">Color Name</label>
                                <input type="text" name="color_name" class="form-control" placeholder="Enter Color Name" value="{{ $color->color_name }}">
                                @error('color_name')
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