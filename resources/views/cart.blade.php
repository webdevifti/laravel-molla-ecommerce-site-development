@extends('master')
@section('page_title','Shopping Cart')
@section('MainContent')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('site_assets/assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    @if($cart_data->count() != 0)
    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                
                                @foreach($cart_data as $cart)
                                <tr id="cartPageItem_{{ $cart->id }}">
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="#">
                                                    <img src="{{ asset('uploads/products/previews/'.$cart->relCartToProduct->product_preview_img) }}" alt="Product image">
                                                </a>
                                            </figure>

                                            <h3 class="product-title">
                                                <a href="{{ route('product.detail',$cart->relCartToProduct->product_slug) }}">{{ $cart->relCartToProduct->product_title }}</a>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">BDT: {{ $cart->relCartToProduct->selling_price }}</td>
                                   
                                   
                                    <td class="quantity-col" width="130px">
                                        <div class="cart-product-quantity">
                                            <input type="button" onclick="decrementValue({{ $cart->id }})" value="-" style="width:100%;background:transparent;border:none;border:1px solid rgb(87, 136, 182)" />
                                            <input type="text" name="quantity" value="{{ $cart->qty }}" maxlength="2" max="10" size="1" id="number_{{ $cart->id }}" class="form-control text-center" style="height: 30px" />
                                            <input type="button" onclick="incrementValue({{ $cart->id }})" value="+" style="width:100%;background:transparent;border:none;border:1px solid rgb(87, 136, 182)" />
                                            </div>
                                    </td>
                                
                                   
                                    <td class="total-col" id="itemTotelPrice_{{ $cart->id }}">BDT: {{ $cart->relCartToProduct->selling_price*$cart->qty }}</td>
                                    <td class="remove-col"><button onclick="removeCart('formCartPage','{{ $cart->id }}')" class="btn-remove"><i class="icon-close"></i></button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table><!-- End .table table-wishlist -->

                        <div class="cart-bottom">
                            <div class="cart-discount">
                                <form action="#">
                                    <div class="input-group">
                                        <input type="text" class="form-control" required placeholder="coupon code">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
                                        </div><!-- .End .input-group-append -->
                                    </div><!-- End .input-group -->
                                </form>
                            </div><!-- End .cart-discount -->

                            {{-- <a href="#" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></a> --}}
                        </div><!-- End .cart-bottom -->
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Your Cart Total Price:</td>
                                        @php
                                        $total_price = 0;
                                        foreach($cart_data as $cp){
                                            $total = $cp->relCartToProduct->selling_price*$cp->qty;
                                            $total_price += $total;
                                        }
                                    @endphp
                                        <td id="final_cart_subtotal">BDT: {{ $total_price }}</td>
                                    </tr><!-- End .summary-subtotal -->
                                    
                                </tbody>
                            </table><!-- End .table table-summary -->

                            <a href="{{ route('checkout') }}" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                        </div><!-- End .summary -->

                        <a href="/shop" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
    @else
        <h3 style="text-align: center;margin: 100px">Your cart is empty</h3>
    @endif
</main><!-- End .main -->
@endsection
        
@section('site_footer')
 
    <script>
        function incrementValue(cart_id)
        {
            var value = parseInt(document.getElementById('number_'+cart_id).value, 10);
            
            value = isNaN(value) ? 0 : value;
            if(value<10){
                value++;
                document.getElementById('number_'+cart_id).value = value;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type:'POST',
                    url:'/cart/increment',
                    data:'cart_id='+cart_id+'&qty='+value,
                    success:function(data){
                        if(data.updated){
                            $('#drpcartqty_'+cart_id).html(data.qty);
                            $('#drpcart_subtotal_'+cart_id).html('Sub total: '+data.subtotal);
                            $('#drptotal_price').html('BDT: '+data.cart_total);
                            $('#final_cart_subtotal').html('BDT: '+data.cart_total);
                            $('#itemTotelPrice_'+cart_id).text('BDT: '+data.cart_item_total_price);
                        }
                        if(data.error){

                        }
                    }
                });
            }
        }
        function decrementValue(cart_id)
        {
            var value = parseInt(document.getElementById('number_'+cart_id).value, 10);
            value = isNaN(value) ? 0 : value;
            if(value>1){
                value--;
                document.getElementById('number_'+cart_id).value = value;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type:'POST',
                    url:'/cart/decrement',
                    data:'cart_id='+cart_id+'&qty='+value,
                    success:function(data){
                        if(data.updated){
                            $('#drpcartqty_'+cart_id).html(data.qty);
                            $('#drpcart_subtotal_'+cart_id).html('Sub total: '+data.subtotal);
                            $('#drptotal_price').html('BDT: '+data.cart_total);
                            $('#final_cart_subtotal').html('BDT: '+data.cart_total);
                            $('#itemTotelPrice_'+cart_id).text('BDT: '+data.cart_item_total_price);
                        }
                        if(data.error){
                            
                        }
                    }
                });
            }

        }
    </script>
  
@endsection