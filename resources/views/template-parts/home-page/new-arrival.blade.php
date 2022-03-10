@if($new_arrivals_products)
<div class="container new-arrivals">
    <div class="heading heading-flex mb-3">
        <div class="heading-left">
            <h2 class="title">New Arrivals</h2><!-- End .title -->
        </div><!-- End .heading-left -->

       <div class="heading-right">
            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="new-all-link" data-toggle="tab" href="#new-all-tab" role="tab" aria-controls="new-all-tab" aria-selected="true">All</a>
                </li>
                @foreach ($get_all_cats as $key=>$item)
                    @php
                        $a = $item->id
                        
                    @endphp
                <li class="nav-item">
                    <a class="nav-link" id="{{ $item->id }}" data-toggle="tab" href="#{{ $item->id }}" role="tab" aria-controls="{{ $item->id }}" aria-selected="true">{{ $item->category_name }}</a>
                </li>
                @endforeach
            </ul>
       </div><!-- End .heading-right -->
    </div><!-- End .heading -->

    <div class="tab-content tab-content-carousel just-action-icons-sm">
        <div class="tab-pane p-0 fade show active" id="new-all-tab" role="tabpanel" aria-labelledby="new-all-link">
            <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                data-owl-options='{
                    "nav": true, 
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":2
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
                            "items":5
                        }
                    }
                }'>
                @foreach($new_arrivals_products as $allproduct)
                <div class="product product-2">
                    <figure class="product-media">
                        @if($allproduct->quantity < 1)
                        <span style="background: red;color: #fff;font-size: 12px" class="product-label label-circle label-top">Out of stock</span>
                        @else
                        <span class="product-label label-circle label-top">Off {{ $allproduct->discount }}%</span>
                       
                        @endif
                        <a href="{{ route('product.detail', $allproduct->product_slug) }}">
                            <img src="{{ asset('uploads/products/previews/'.$allproduct->product_preview_img) }}" alt="Product image" class="product-image">
                        </a>

                        <div class="product-action-vertical">
                            
                            <a href="javascript:void(0)" onclick="addtowishlist('{{ $allproduct->id }}')" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                        </div><!-- End .product-action -->

                        <div class="product-action">
                            @if($allproduct->quantity < 1)
                                
                            @else 
                            <button onclick="addtocart('{{ $allproduct->id }}','{{ (session('LoggedCustomer')) ? $customer->id : '' }}')" class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></button>
                            @endif
                            {{-- <a href="{{ asset('site_assets/popup/quickView.html') }}" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a> --}}
                        </div><!-- End .product-action -->
                    </figure><!-- End .product-media -->
                    <div class="product-body">
                        <div class="product-cat">
                            <a href="/shop/{{ $allproduct->relCatToProduct->category_slug }}">{{ $allproduct->relCatToProduct->category_name }}</a>
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="{{ route('product.detail', $allproduct->product_slug) }}">{{ $allproduct->product_title }}</a></h3><!-- End .product-title -->
                        <div class="product-price">
                            BDT: {{ $allproduct->selling_price }}
                        </div><!-- End .product-price -->
                        <div class="ratings-container">
                            <div class="ratings">
                                <div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->
                            </div><!-- End .ratings -->
                            <span class="ratings-text">( 4 Reviews )</span>
                        </div><!-- End .rating-container -->
                    </div><!-- End .product-body -->
                </div><!-- End .product -->
                
                @endforeach
            </div><!-- End .owl-carousel -->
        </div><!-- .End .tab-pane -->

        {{-- @foreach($new_arrivals_products as $key=>$product)
           
        <div class="tab-pane p-0 fade" id="{{ $product->category_id }}" role="tabpanel" aria-labelledby="{{ $product->category_id }}">
            <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                data-owl-options='{
                    "nav": true, 
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":2
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
                            "items":5
                        }
                    }
                }'>
               
                <div class="product product-2">
                    <figure class="product-media">
                        <span class="product-label label-circle label-new">{{ $product->discount }}%</span>
                        <a href="product.html">
                            <img src="{{ asset('uploads/products/previews/'.$product->product_preview_img) }}" alt="Product image" class="product-image">
                        </a>

                        <div class="product-action-vertical">
                            <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a>
                        </div><!-- End .product-action -->

                        <div class="product-action">
                            <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></a>
                            <a href="popup/quickView.html" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a>
                        </div><!-- End .product-action -->
                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <div class="product-cat">
                            <a href="/shop/{{ $product->relCatToProduct->category_slug }}">{{ $product->relCatToProduct->category_name }}</a>
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="product.html">{{ $product->product_title }}</a></h3><!-- End .product-title -->
                        <div class="product-price">
                            BDT: {{ $product->product_selling_price }}
                        </div><!-- End .product-price -->
                        <div class="ratings-container">
                            <div class="ratings">
                                <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                            </div><!-- End .ratings -->
                            <span class="ratings-text">( 4 Reviews )</span>
                        </div><!-- End .rating-container -->

                        <div class="product-nav product-nav-dots">
                            <a href="#" style="background: #edd2c8;"><span class="sr-only">Color name</span></a>
                            <a href="#" style="background: #eaeaec;"><span class="sr-only">Color name</span></a>
                            <a href="#" class="active" style="background: #333333;"><span class="sr-only">Color name</span></a>
                        </div><!-- End .product-nav -->
                    </div><!-- End .product-body -->
                </div><!-- End .product -->

            </div><!-- End .owl-carousel -->
        </div><!-- .End .tab-pane -->
        @endforeach --}}
        
    </div><!-- End .tab-content -->
</div><!-- End .container -->
@endif
