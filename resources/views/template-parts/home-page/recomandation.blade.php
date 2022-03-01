@if($recomanded_products)
<div class="container for-you">
    <div class="heading heading-flex mb-3">
        <div class="heading-left">
            <h2 class="title">Recommendation For You</h2><!-- End .title -->
        </div><!-- End .heading-left -->

       <div class="heading-right">
            <a href="#" class="title-link">View All Recommendadion <i class="icon-long-arrow-right"></i></a>
       </div><!-- End .heading-right -->
    </div><!-- End .heading -->

    <div class="products">
        <div class="row justify-content-center">
            @foreach($recomanded_products as $p)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product product-2">
                    <figure class="product-media">
                        <span class="product-label label-circle label-sale">Off {{ $p->discount }}%</span>
                        <a href="{{ route('product.detail', $p->product_slug) }}">
                            <img src="{{ asset('uploads/products/previews/'.$p->product_preview_img) }}" alt="Product image" class="product-image">
                        </a>

                        <div class="product-action-vertical">
                            <a href="javascript:void(0)" onclick="addtowishlist('{{ $p->id }}')" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                        </div><!-- End .product-action -->

                        <div class="product-action">
                            <button onclick="addtocart('{{ $p->id }}','{{ (session('LoggedCustomer')) ? $customer->id : '' }}')" class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></button>
                            
                        </div><!-- End .product-action -->
                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <div class="product-cat">
                            <a href="/shop/{{ $p->relCatToProduct->category_slug }}">{{ $p->relCatToProduct->category_name }}</a>
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="{{ route('product.detail', $p->product_slug) }}">{{ $p->product_title }}</a></h3><!-- End .product-title -->
                        <div class="product-price">
                            <span class="new-price"> BDT: {{ $p->selling_price }}</span>
                            <span class="old-price"> BDT: {{ $p->regular_price }}</span>
                        </div><!-- End .product-price -->
                        <div class="ratings-container">
                            <div class="ratings">
                                <div class="ratings-val" style="width: 40%;"></div><!-- End .ratings-val -->
                            </div><!-- End .ratings -->
                            <span class="ratings-text">( 4 Reviews )</span>
                        </div><!-- End .rating-container -->
                    </div><!-- End .product-body -->
                </div><!-- End .product -->
            </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
            @endforeach
        </div><!-- End .row -->
    </div><!-- End .products -->
</div><!-- End .container -->

@endif