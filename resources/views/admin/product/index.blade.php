@extends('admin.master')
@section('page_title','Admin | All Products')
@section('MainContent')
    
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
       <h1 class="h3 mb-0 text-gray-800">Products</h1>
       <a href="{{ route('admin.product.add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
               class="fas fa-plus fa-sm text-white-50"></i> Add New Product</a>
   </div>
   @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger mb-2">{{ $error }}</div>
        @endforeach
    @endif
   
   <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Products Data</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form action="{{ route('admin.product.bulk') }}" method="POST">
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
                        <th>Product</th>
                        <th>Category</th>
                        <th>Added By</th>
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
                        <th>Product</th>
                        <th>Category</th>
                        <th>Added By</th>
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
                    @foreach ($get_products as $p)
                    @php
                        $sl++
                    @endphp
                        <tr>
                            <td><input type="checkbox" class="markCheck" name="mark[]" value="{{ $p->id }}" /></td>
                        </form>
                            <td>{{ $sl }}</td>
                            <td>{{ $p->product_title }}</td>
                            <td>{{ $p->relCatToProduct->category_name }}</td>
                            <td>{{ $p->relUserToProduct->name }}</td>
                            <td>
                                <img width="100" src="{{ asset('uploads/products/previews/'.$p->product_preview_img) }}" alt="">
                            </td>
                            <td>{{ $p->created_at->diffForHumans() }}</td>
                            <td>{{ $p->updated_at->diffForHumans() }}</td>
                            <td>
                                @if($p->status == 1)
                                    <a href="/admin/product/{{ $p->id }}/status" class="btn btn-success btn-sm">Active</a>
                                @else
                                    <a href="/admin/product/{{ $p->id }}/status" class="btn btn-secondary btn-sm">Inactive</a>
                                @endif
                            </td>
                            <td>
                                <a href="/admin/product/{{ $p->id }}/edit" class="btn btn-info btn-sm">Edit</a>
                                <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#viewDetail_{{ $p->id }}">
                                    <i class="fas fa-eye fa-sm fa-fw mr-2 text-gray-400"></i>
                                    View Details
                                </a>
                                <a onclick="return confirm('Are you sure?')" href="{{ route('admin.product.delete',$p->id) }}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <div class="modal fade" id="viewDetail_{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Product Details Information</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if($p->status == 1)
                                        <p><strong>Status: <span class="badge badge-success">Active</span></strong></p>
                                    @else
                                        <p><strong>Status: <span class="badge badge-danger">Deactive</span></strong></p>
                                    @endif
                                    <p><strong>Title: </strong>{{ $p->product_title }}</p>
                                    <p><strong>Product Added By: </strong>{{ $p->relUserToProduct->name }}</p>
                                    <p><strong>Category: </strong>{{ $p->relCatToProduct->category_name }}</p>
                                    <p><strong>Sub Category: </strong> {{ $p->relSubCatToProduct->sub_category_name }}</p>
                                    <p><strong>Discount: </strong><span class="badge badge-info">{{ $p->discount }}%</span></p>
                                    <p><strong>Selling Price: </strong>{{ $p->selling_price }}</p>
                                    <p><strong>Regular Price: </strong>{{ $p->regular_price }}</p>
                                    <p><strong>Preview Image: </strong><img src="{{ asset('uploads/products/previews/'.$p->product_preview_img) }}" /></p>
                                    <p><strong>Description: </strong>{!! $p->description !!}</p>
                                    <p><strong>Additional Information: </strong>{!! $p->addition_information !!}</p>
                                    <p><strong>Return Condition: </strong>{!! $p->shipping_and_return_condition !!}</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
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