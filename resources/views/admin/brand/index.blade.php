@extends('admin.master')
@section('page_title','Admin | Brands Master')
@section('MainContent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h3>Brands</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                           
                            <div class="mt-3">
                                <label for="">Brand Name</label>
                                <input type="text" name="brand_name" class="form-control" placeholder="Enter Bran Name">
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
                            <img height="100" width="150" id="pic" alt="">
                                @error('brand_image')
                                    <p style="color:red">{{ $message }}</p>
                               @enderror
                            <div class="mt-3">
                                <button type="submit" class="btn btn-info">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h3>Brands</h3>
                    </div>
                    <div class="card-body">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Brand Name</th>
                                    <th>Brand Image</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Brand Name</th>
                                    <th>Brand Image</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @php
                                    $sl = 0;
                                @endphp
                                @foreach($brands as $b)
                                @php
                                    $sl++
                                @endphp
                                <tr>
                                    <td>{{ $sl }}</td>
                                    <td>{{ $b->brand_name }}</td>
                                    <td><img width="100" src="{{ asset('uploads/brands/'.$b->brand_image) }}" alt=""></td>
                                    <td>{{ $b->created_at->diffForHumans() }}</td>
                                    <td>{{ $b->updated_at->diffForHumans() }}</td>
                                    <td>
                                        @if($b->status == 1)
                                            <a href="{{ route('admin.brand.status',$b->id) }}" class="btn btn-success btn-sm">Active</a>
                                        @else 
                                            <a href="{{ route('admin.brand.status',$b->id) }}" class="btn btn-secondary btn-sm">Inactive</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.brand.edit',$b->id) }}" class="btn btn-info btn-sm">Edit</a>

                                        <a onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" href="/admin/brand/delete/{{ $b->id }}">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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