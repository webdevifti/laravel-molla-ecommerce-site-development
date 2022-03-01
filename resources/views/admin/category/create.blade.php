@extends('admin.master')
@section('page_title','Admin | Add New Category')
@section('MainContent')
    <!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
       <h1 class="h3 mb-0 text-gray-800">Add Category</h1>
       <a href="{{ route('admin.category') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
               class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
   </div>

   <div class="row">
       <div class="col-lg-4 m-auto col-md-4 col-sm-12">
        {{-- @if(session()->has('success'))
            <div class="alert alert-success">{{ session()->get('success'); }}</div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger">{{ session()->get('error'); }}</div>
        @endif --}}
           <div class="card shadow">
               <div class="card-header">
                   <h3></h3>
               </div>
               <div class="card-body">
                   <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                       @csrf
                       <div class="mt-3">
                           <label for="">Category Name</label>
                           <input type="text" class="form-control" name="category_name" placeholder="Enter Category Name">
                           @error('category_name')
                                <p style="color:red">{{ $message }}</p>
                           @enderror
                       </div>
                       
                       <div class="input-group mt-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload category image</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" oninput="pic.src=window.URL.createObjectURL(this.files[0])" name="category_image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                        <img height="100" width="150" id="pic" alt="">
                            @error('category_image')
                                <p style="color:red">{{ $message }}</p>
                           @enderror
                       <div class="mt-3">
                           <button type="submit" class="btn btn-success">Add</button>
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