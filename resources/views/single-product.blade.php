@extends('master')
@section('page_title', 'Product Details - '.$product_info->product_title)
@section('MainContent')
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="/shop/{{ $product_info->relCatToProduct->category_slug }}">{{ $product_info->relCatToProduct->category_name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product_info->product_title  }}</li>
            </ol>

            {{-- <nav class="product-pager ml-auto" aria-label="Product">
                <a class="product-pager-link product-pager-prev" href="#" aria-label="Previous" tabindex="-1">
                    <i class="icon-angle-left"></i>
                    <span>Prev</span>
                </a>

                <a class="product-pager-link product-pager-next" href="#" aria-label="Next" tabindex="-1">
                    <span>Next</span>
                    <i class="icon-angle-right"></i>
                </a>
            </nav><!-- End .pager-nav --> --}}
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="product-details-top">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-gallery">
                                    <figure class="product-main-image">
                                        <span class="product-label label-top">{{ $product_info->discount }}%</span>
                                        <img id="product-zoom" src="{{ asset('uploads/products/previews/'.$product_info->product_preview_img) }}" data-zoom-image="{{ asset('uploads/products/previews/'.$product_info->product_preview_img) }}" alt="product image">

                                        <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                            <i class="icon-arrows"></i>
                                        </a>
                                    </figure><!-- End .product-main-image -->

                                    <div id="product-zoom-gallery" class="product-image-gallery">
                                        <a class="product-gallery-item active" href="#" data-image="{{ asset('uploads/products/previews/'.$product_info->product_preview_img) }}" data-zoom-image="{{ asset('uploads/products/previews/'.$product_info->product_preview_img) }}">
                                            <img src="{{ asset('uploads/products/previews/'.$product_info->product_preview_img) }}" alt="product side">
                                        </a>

                                        <a class="product-gallery-item" href="#" data-image="{{asset('uploads/products/previews/'.$product_info->product_preview_img) }}" data-zoom-image="{{ asset('uploads/products/previews/'.$product_info->product_preview_img) }}">
                                            <img src="{{ asset('uploads/products/previews/'.$product_info->product_preview_img) }}" alt="product cross">
                                        </a>

                                        <a class="product-gallery-item" href="#" data-image="{{ asset('uploads/products/previews/'.$product_info->product_preview_img) }}" data-zoom-image="{{asset('uploads/products/previews/'.$product_info->product_preview_img) }}">
                                            <img src="{{asset('uploads/products/previews/'.$product_info->product_preview_img) }}" alt="product with model">
                                        </a>

                                        <a class="product-gallery-item" href="#" data-image="{{ asset('uploads/products/previews/'.$product_info->product_preview_img) }}" data-zoom-image="{{ asset('uploads/products/previews/'.$product_info->product_preview_img)}}">
                                            <img src="{{ asset('uploads/products/previews/'.$product_info->product_preview_img) }}" alt="product back">
                                        </a>
                                    </div><!-- End .product-image-gallery -->
                                </div><!-- End .product-gallery -->
                            </div><!-- End .col-md-6 -->

                            <div class="col-md-6">
                                <div class="product-details product-details-sidebar">
                                    <h1 class="product-title">{{ $product_info->product_title }}</h1><!-- End .product-title -->

                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                        </div><!-- End .ratings -->
                                        <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>
                                    </div><!-- End .rating-container -->
                                    @if($product_info->quantity < 1)
                                        <span class="out-of-stock">Out of stock</span>
                                    @else
                                        <span class="in-stock">In stock</span>
                                    @endif
                                    <div class="product-price">
                                        BDT: {{ $product_info->selling_price }}
                                    </div><!-- End .product-price -->

                                    <div class="product-content">
                                        <p>Sed egestas, ante et vulputate volutpat, eros semper est, vitae luctus metus libero eu augue.</p>
                                    </div><!-- End .product-content -->

                                    {{-- <div class="details-filter-row details-row-size">
                                        <label>Color:</label>

                                        <div class="product-nav product-nav-dots">
                                            <a href="#" class="active" style="background: #333333;"><span class="sr-only">Color name</span></a>
                                            <a href="#" style="background: #efe7db;"><span class="sr-only">Color name</span></a>
                                        </div><!-- End .product-nav -->
                                    </div><!-- End .details-filter-row --> --}}

                                    {{-- <div class="details-filter-row details-row-size">
                                        <label for="size">Size:</label>
                                        <div class="select-custom">
                                            <select name="size" id="size" class="form-control">
                                                <option value="#" selected="selected">Select a size</option>
                                                <option value="s">Small</option>
                                                <option value="m">Medium</option>
                                                <option value="l">Large</option>
                                                <option value="xl">Extra Large</option>
                                            </select>
                                        </div><!-- End .select-custom -->

                                        <a href="#" class="size-guide"><i class="icon-th-list"></i>size guide</a>
                                    </div><!-- End .details-filter-row --> --}}
                                  
                                    <div class="product-details-action">
                                       
                                            <div class="details-action-col">
                                                <label for="qty">Qty:</label>
                                                <div class="product-details-quantity">
                                                    <input type="number" id="qty" class="form-control" value="1" name="product_qty" min="1" max="10" step="1" data-decimals="0" required>
                                                </div><!-- End .product-details-quantity -->

                                                <button onclick="addtocart('{{ $product_info->id }}','{{ (session('LoggedCustomer')) ? $customer->id : '' }}')" {{ ($product_info->quantity < 1 ) ? 'disabled':'' }} class="btn-product btn-cart"><span>add to cart</span></button>
                                            
                                            </div><!-- End .details-action-col -->
                                        <div class="details-action-wrapper">
                                            <a href="javascript:void(0)" onclick="addtowishlist('{{ $product_info->id }}')" class="btn-product btn-wishlist" title="Wishlist"><span>Add to Wishlist</span></a>
                                            {{-- <a href="#" class="btn-product btn-compare" title="Compare"><span>Add to Compare</span></a> --}}
                                        </div><!-- End .details-action-wrapper -->
                                    </div><!-- End .product-details-action -->
                                
                                    <div class="product-details-footer details-footer-col">
                                        <div class="product-cat">
                                            <span>Category:</span>
                                            <a href="/shop/{{ $product_info->relCatToProduct->category_slug }} ">{{ $product_info->relCatToProduct->category_name }} </a>
                                            
                                        </div><!-- End .product-cat -->

                                        <div class="social-icons social-icons-sm">
                                            <span class="social-label">Share:</span>
                                            <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                            <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                            <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                            <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                        </div>
                                    </div><!-- End .product-details-footer -->
                                </div><!-- End .product-details -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-details-top -->

                    <div class="product-details-tab">
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                                <div class="product-desc-content">
                                    {!! $product_info->description !!}
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                                <div class="product-desc-content">
                                    {!! $product_info->addition_information !!}
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                                <div class="product-desc-content">
                                    {!! $product_info->shipping_and_return_condition !!}
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                                <div class="reviews">
                                    <h3>Reviews (2)</h3>
                                    <div class="review">
                                        <div class="row no-gutters">
                                            <div class="col-auto">
                                                <h4><a href="#">Samanta J.</a></h4>
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                                    </div><!-- End .ratings -->
                                                </div><!-- End .rating-container -->
                                                <span class="review-date">6 days ago</span>
                                            </div><!-- End .col -->
                                            <div class="col">
                                                <h4>Good, perfect size</h4>

                                                <div class="review-content">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus cum dolores assumenda asperiores facilis porro reprehenderit animi culpa atque blanditiis commodi perspiciatis doloremque, possimus, explicabo, autem fugit beatae quae voluptas!</p>
                                                </div><!-- End .review-content -->

                                                <div class="review-action">
                                                    <a href="#"><i class="icon-thumbs-up"></i>Helpful (2)</a>
                                                    <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                                </div><!-- End .review-action -->
                                            </div><!-- End .col-auto -->
                                        </div><!-- End .row -->
                                    </div><!-- End .review -->

                                    <div class="review">
                                        <div class="row no-gutters">
                                            <div class="col-auto">
                                                <h4><a href="#">John Doe</a></h4>
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->
                                                    </div><!-- End .ratings -->
                                                </div><!-- End .rating-container -->
                                                <span class="review-date">5 days ago</span>
                                            </div><!-- End .col -->
                                            <div class="col">
                                                <h4>Very good</h4>

                                                <div class="review-content">
                                                    <p>Sed, molestias, tempore? Ex dolor esse iure hic veniam laborum blanditiis laudantium iste amet. Cum non voluptate eos enim, ab cumque nam, modi, quas iure illum repellendus, blanditiis perspiciatis beatae!</p>
                                                </div><!-- End .review-content -->

                                                <div class="review-action">
                                                    <a href="#"><i class="icon-thumbs-up"></i>Helpful (0)</a>
                                                    <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                                </div><!-- End .review-action -->
                                            </div><!-- End .col-auto -->
                                        </div><!-- End .row -->
                                    </div><!-- End .review -->
                                </div><!-- End .reviews -->
                            </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .product-details-tab -->

                    @if($also_like)
                    <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
                    <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                        data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                },
                                "1200": {
                                    "items":4,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>
                        @foreach($also_like as $alp)
                        <div class="product product-7 text-center">
                            <figure class="product-media">
                                <span class="product-label label-new">discount {{ $alp->discount }}%</span>
                                <a href="{{ route('product.detail', $alp->product_slug) }}">
                                    <img src="{{ asset('uploads/products/previews/'.$alp->product_preview_img) }}" alt="Product image" class="product-image">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="javascript:void(0)" onclick="addtowishlist('{{ $alp->id }}')" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                    {{-- <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                    <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a> --}}
                                </div><!-- End .product-action-vertical -->

                                <div class="product-action">
                                    <button onclick="addtocart('{{ $alp->id }}','{{ (session('LoggedCustomer')) ? $customer->id : ''}}')"  class="btn-product btn-cart"><span>add to cart</span></button>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="/shop/{{ $alp->relCatToProduct->category_name }}">{{ $alp->relCatToProduct->category_name }}</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="{{ route('product.detail', $alp->product_slug) }}">{{ $alp->product_title }}</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                   BDT: {{ $alp->selling_price }}
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 20%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 2 Reviews )</span>
                                </div><!-- End .rating-container -->

                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                        @endforeach
                    </div><!-- End .owl-carousel -->
                    @endif
                </div><!-- End .col-lg-9 -->

               
                <aside class="col-lg-3">
                    <div class="sidebar sidebar-product">
                        @if($related_product->count() != 0)
                        <div class="widget widget-products">
                            <h4 class="widget-title">Related Product</h4><!-- End .widget-title -->

                            <div class="products">
                                @foreach($related_product as $rp)
                                <div class="product product-sm">
                                    <figure class="product-media">
                                        <a href="{{ route('product.detail', $rp->product_slug) }}">
                                            <img src="{{ asset('uploads/products/previews/'.$rp->product_preview_img) }}" alt="Product image" class="product-image">
                                        </a>
                                    </figure>

                                    <div class="product-body">
                                        <h5 class="product-title"><a href="{{ route('product.detail', $rp->product_slug) }}">{{ $rp->product_title }}</a></h5><!-- End .product-title -->
                                        <div class="product-price">
                                            BDT: {{ $rp->selling_price }}
                                        </div><!-- End .product-price -->
                                    </div><!-- End .product-body -->
                                </div><!-- End .product product-sm -->
                                @endforeach
                            </div><!-- End .products -->

                            <a href="category.html" class="btn btn-outline-dark-3"><span>View More Products</span><i class="icon-long-arrow-right"></i></a>
                        </div><!-- End .widget widget-products -->
                        @endif
                        <div class="widget widget-banner-sidebar">
                            <div class="banner-sidebar-title">ad box 280 x 280</div><!-- End .ad-title -->
                            
                            <div class="banner-sidebar banner-overlay">
                                <a href="#">
                                    <img src="{{ asset('site_assets/assets/images/blog/sidebar/banner.jpg') }}" alt="banner">
                                </a>
                            </div><!-- End .banner-ad -->
                        </div><!-- End .widget -->
                    </div><!-- End .sidebar sidebar-product -->
                </aside><!-- End .col-lg-3 -->
               
            </div><!-- End .row -->

        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main>
@endsection
@section('site_footer')
@if(session('added_to_cart'))
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '{{ session('added_to_cart') }}'
    })
</script>
@endif
@if(session('error_to_cart'))
<script>
    Swal.fire({
        position: 'top-center',
        icon: 'warning',
        title: '{{ session('error_to_cart') }}',
    })
</script>
@endif
@endsection