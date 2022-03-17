@extends('admin.master')
@section('page_title','Admin | All Categories')
@section('MainContent')
    
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
       <h1 class="h3 mb-0 text-gray-800">Banners</h1>
       <a href="{{ route('admin.banner.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
               class="fas fa-plus fa-sm text-white-50"></i> Add New Banner</a>
   </div>
   @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger mb-2">{{ $error }}</div>
        @endforeach
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger">{{ session()->get('error') }}</div>
    @endif
   <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Banner Data</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form action="{{ route('admin.banner.bulk') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-lg-3 mb-3 d-flex align-items-center justify-content-between">
                <select name="bulk_options" class="form-control">
                    <option value="">Select Options</option>
                     <option value="active">Active</option>
                     <option value="inactive">Inactive</option>
                 </select>
                 <button type="submit" name="bulkSubmit" value="bulk_submit" class="btn btn-info">Done</button>
                </div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                       
                        <th><input type="checkbox" id="markAll"></th>
                        <th>SL</th>
                        <th>Product Name</th>
                        <th>Regular Price</th>
                        <th>Selling Price</th>
                        <th>Special Notes</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th><input type="checkbox" id="markAll"></th>
                        <th>SL</th>
                        <th>Product Name</th>
                        <th>Regular Price</th>
                        <th>Selling Price</th>
                        <th>Special Notes</th>
                        <th>Image</th>
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
                    @foreach ($banners as $banner)
                    @php
                        $sl++
                    @endphp
                        <tr>
                            <td><input type="checkbox" class="markCheck" name="mark[]" value="{{ $banner->id }}" /></td>
                        </form>
                            <td>{{ $sl }}</td>
                            <td>{{ $banner->product_name }}</td>
                            <td>{{ $banner->regular_price }}</td>
                            <td>{{ $banner->selling_price }}</td>
                            <td>{{ $banner->special_notes }}</td>
                            <td>
                                <img width="100" src="{{ asset('uploads/banners/'.$banner->product_image) }}" alt="">
                            </td>
                            <td>{{ $banner->created_at->diffForHumans() }}</td>
                            <td>{{ $banner->updated_at->diffForHumans() }}</td>
                            <td>
                                @if($banner->status == 1)
                                    <a href="/admin/banner/{{ $banner->id }}/status" class="btn btn-success btn-sm">Active</a>
                                @else
                                    <a href="/admin/banner/{{ $banner->id }}/status" class="btn btn-secondary btn-sm">Inactive</a>
                                @endif
                            </td>
                            <td>
                              
                                <a onclick="return confirm('Are you sure?')" href="{{ route('admin.banner.delete',$banner->id) }}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection

@section('FooterScript')
<script>

    $(function(e){
        $('#markAll').on('click',function(){
            $('.markCheck').prop('checked', $(this).prop('checked'));
        })
    });
</script>
@endsection