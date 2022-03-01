@extends('admin.master')
@section('page_title','Admin | Add New Category')
@section('MainContent')
    <!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
       <h1 class="h3 mb-0 text-gray-800">Add Product</h1>
       <a href="{{ route('admin.product') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
               class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
   </div>

   <div class="row">
       <div class="col-lg-12 col-md-12 col-sm-12">
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
                   <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                       @csrf
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="mt-3">
                                    <label for="">Product Category</label>
                                        <select name="product_category" class="form-control" id="productCategory">
                                            <option value="">--Select Product Category--</option>
                                            @foreach($get_cats as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                    @error('product_category')
                                            <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="mt-3">
                                    <label for="">Product Sub Category</label>
                                        <select name="product_subcategory" class="form-control" id="productSubCategory">
                                            <option value="">--Select Product Sub Category--</option>
                                        </select>
                                        @error('product_subcategory')
                                            <p style="color:red">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="mt-3">
                                    <label for="p-t">Discount</label>
                                    <input type="text" class="form-control" placeholder="Discount" name="discount" value="{{ @old('discount') }}" >
                                    <span class="text-info">You can give discount</span>
                                    @error('discount')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="mt-3">
                                    <label for="p-t">Price</label>
                                    <input type="text" class="form-control" placeholder="Product Actual Price" name="price" value="{{ @old('price') }}" >
                                    @error('price')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-10">
                                <div class="mt-3">
                                    <label for="p-t">Product Name/Title</label>
                                    <input type="text" placeholder="Enter Product name or title" name="product_title" class="form-control" value="{{ @old('product_title') }}" >
                                    @error('product_title')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-8 col-sm-2">
                                <div class="mt-3">
                                    <label for="">Product in Stock/Qauntity</label>
                                    <input type="text" name="quantity" placeholder="Qauntity or in stock" class="form-control" value="{{ @old('quantity') }}">
                                    @error('quantity')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mt-3">
                                    <label for="">Product Description</label>
                                    <textarea name="description"  class="form-control ckeditor" id="" cols="30" rows="10" placeholder="Write Product Description">{{ @old('description') }}</textarea>
                                    @error('description')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mt-3">
                                    <label for="">Product Additional Information</label>
                                    <textarea name="additional_info" class="form-control ckeditor"  id="" cols="30" rows="10" placeholder="Write Product Additional Information">{{ @old('additional_info') }}</textarea>
                                    @error('additional_info')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="mt-3">
                                    <label for="">Shipping and return condition</label>
                                    <textarea name="shipping_and_return_condition" class="form-control ckeditor"  id="" cols="30" rows="5">{{ @old('shipping_and_return_condition') }}</textarea>
                                    
                                    @error('shipping_and_return_condition')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="input-group mt-5">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload Product Preview image</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" oninput="pic.src=window.URL.createObjectURL(this.files[0])" name="product_preview_image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                                <img height="200" width="100%" id="pic" alt="">
                                    @error('product_preview_image')
                                        <p style="color:red">{{ $message }}</p>
                                    @enderror
                            </div>
                        </div>
                        {{-- <div class="mt-3">
                            <label for="">Select Multiple Product Thumbnail</label>
                            <input type="file" name="product_thumbnail[]" class="form-control">
                            <span class="text-info">You Should Select Multiple Image</span>
                            @error('product_thumbnail')
                                <p style="color:red">{{ $message }}</p>
                            @enderror

                        </div> --}}
                        
                        <div class="mt-3">
                           <button type="submit" class="btn btn-success btn-lg">Upload Product</button>
                        </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection

@section('FooterScript')

<script>
    $('#productCategory').change(function(){
        var category_id = $('#productCategory').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url:'/admin/getcategory',
            data:{'category_id':category_id},
            success:function(data){
                $('#productSubCategory').html(data);
            }
        });
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