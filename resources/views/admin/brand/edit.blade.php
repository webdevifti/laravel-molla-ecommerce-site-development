@extends('admin.master')
@section('page_title','Admin | Edit Sub Category')
@section('MainContent')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Brand</h1>
            <a href="{{ route('admin.brand') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h3>Edit Brand</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.brand.update',$brand->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mt-3">
                                <label for="">Brand Name</label>
                                <input type="text" name="brand_name" class="form-control" placeholder="Enter Bran Name" value="{{ $brand->brand_name }}">
                                @error('brand_name')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload brand image</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" oninput="pic.src=window.URL.createObjectURL(this.files[0])" name="brand_image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                            <img height="100" src="{{ asset('uploads/brands/'.$brand->brand_image) }}" width="150" id="pic" alt="">
                                @error('brand_image')
                                    <p style="color:red">{{ $message }}</p>
                               @enderror
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