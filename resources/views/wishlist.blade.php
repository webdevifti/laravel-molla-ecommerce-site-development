@extends('master')
@section('page_title','My wishlist')
@section('MainContent')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('site_assets/assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">My Wishlist<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    @if($wishlist_data->count() != 0)
            <div class="page-content">
                <div class="container">
                    <table class="table table-wishlist table-mobile">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Stock Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($wishlist_data as $w)
                            <tr id="wishlist_{{ $w->id }}">
                                <td class="product-col">
                                    <div class="product">
                                        <figure class="product-media">
                                            <a href="{{ route('product.detail', $w->rel_wishToProduct->product_slug) }}">
                                                
                                                <img src="{{ asset('uploads/products/previews/'.$w->rel_wishToProduct->product_preview_img) }}" alt="Product image">
                                            </a>
                                        </figure>

                                        <h3 class="product-title">
                                            <a href="{{ route('product.detail', $w->rel_wishToProduct->product_slug) }}">{{ $w->rel_wishToProduct->product_title }}</a>
                                        </h3><!-- End .product-title -->
                                    </div><!-- End .product -->
                                </td>
                                <td class="price-col">BDT: {{ $w->rel_wishToProduct->selling_price }}</td>
                                @if($w->rel_wishToProduct->quantity < 1)
                                <td class="stock-col"><span class="out-of-stock">Out of stock</span></td>
                                @else
                                <td class="stock-col"><span class="in-stock">In stock</span></td>
                                @endif
                                <td class="action-col">
                                
                                    <button onclick="addtocart('{{ $w->rel_wishToProduct->id }}','{{ $customer->id }}')"  {{ ($w->rel_wishToProduct->quantity < 1) ? 'disabled':'' }} class="btn btn-block btn-outline-primary-2">
                                        Add to cart
                                    </button>
                                </td>
                                <td class="remove-col"><button onclick="removewishlist('{{$w->id}}')" class="btn-remove"><i class="icon-close"></i></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table><!-- End .table table-wishlist -->
                    <div class="wishlist-share">
                        <div class="social-icons social-icons-sm mb-2">
                            <label class="social-label">Share on:</label>
                            <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                            <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                            <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                            <a href="#" class="social-icon" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                            <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                        </div><!-- End .soial-icons -->
                    </div><!-- End .wishlist-share -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
       
    @else
        <h3 style="text-align: center;margin: 100px;">Your wishlist is empty</h3>
    @endif
    
   
</main>
@endsection
        
@section('site_footer')
<script>
    function removewishlist(wishlist_id){
        var counter = $('.count_wishlist').text();
        $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $.ajax({
            type:'POST',
            url:'/wishlist/delete',
            data:'wishlist_id='+wishlist_id,
            success:function(data){
                if(data.success){
                    counter--;
                    $('.count_wishlist').text(counter);
                    $('#wishlist_'+wishlist_id).hide();
                    Swal.fire({
                        position: 'top-center',
                        icon: 'success',
                        title: data.success
                    });
                    
                }
                if(data.empty_wishlist){
                    window.location.href = window.location.href;
                }
                if(data.error){
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: data.error
                    });
                }
            }
        });
    }
</script>
    
@endsection
    