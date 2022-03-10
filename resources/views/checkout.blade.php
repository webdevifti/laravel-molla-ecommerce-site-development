@extends('master')
@section('page_title','Checkout')
@section('MainContent')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('site_assets/assets/images/page-header-bg.jpg') }}">
        <div class="container">
            <h1 class="page-title">Checkout<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="checkout">
            <div class="container">
                @if(session()->has('order_error'))
                    <div class="alert alert-danger">{{ session()->get('order_error') }}</div>
                @endif
                <div class="checkout-discount">
                    <form action="#">
                        <input type="text" class="form-control" required id="checkout-discount-input">
                        <label for="checkout-discount-input" class="text-truncate">Have a coupon? <span>Click here to enter your code</span></label>
                    </form>
                </div><!-- End .checkout-discount -->
                <form action="{{ route('customer.order.process') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-9">
                            <h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
                                <div class="row">
                                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                                    <div class="col-sm-6">
                                        <label>First Name *</label>
                                        @error('firstname') <span style="color: red;">{{ $message }}</span>@enderror
                                        <input type="text" name="firstname" class="form-control" required value="{{ $customer->customer_firstname }}">
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>Last Name *</label>
                                        @error('lastname') <span style="color: red;">{{ $message }}</span>@enderror
                                        <input type="text" name="lastname" class="form-control" required value="{{ $customer->customer_lastname }}">
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <label>Company Name (Optional)</label>
                                <input type="text" name="company_name"  class="form-control">

                                <label>Country *</label>
                                @error('country') <span style="color: red;">{{ $message }}</span>@enderror
                                <input type="text" name="country" class="form-control">
                                <label>Street address *</label>
                                @error('street') <p style="color: red;">{{ $message }}</p>@enderror
                                <input type="text" name="street" class="form-control" placeholder="House number and Street name">
                                @error('appartment') <p style="color: red;">{{ $message }}</p>@enderror
                                <input type="text" name="appartment" class="form-control" placeholder="Appartments, suite, unit etc ..." >

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Town / City *</label>
                                        @error('city') <p style="color: red;">{{ $message }}</p>@enderror
                                        <input type="text" name="city" class="form-control">
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>State / County *</label>
                                        @error('state') <p style="color: red;">{{ $message }}</p>@enderror
                                        <input type="text" name="state" class="form-control">
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Postcode / ZIP *</label>
                                        @error('zip') <p style="color: red;">{{ $message }}</p>@enderror
                                        <input type="text" name="zip" class="form-control">
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>Phone *</label>
                                        @error('phone_number') <p style="color: red;">{{ $message }}</p>@enderror
                                        <input type="tel" name="phone_number" class="form-control" value="{{ $customer->customer_phone_number }}">
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <label>Email address *</label>
                                @error('email') <p style="color: red;">{{ $message }}</p>@enderror
                                <input type="email" name="email" class="form-control" value="{{ $customer->customer_email }}">


                                {{-- <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkout-create-acc">
                                    <label class="custom-control-label" for="checkout-create-acc">Create an account?</label>
                                </div><!-- End .custom-checkbox --> --}}

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkout-diff-address">
                                    <label class="custom-control-label" for="checkout-diff-address">Ship to a different address?</label>
                                </div><!-- End .custom-checkbox -->

                                <label>Order notes (optional)</label>
                                <textarea class="form-control" name="order_notes" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                                
                        </div><!-- End .col-lg-9 -->
                        <aside class="col-lg-3">
                            <div class="summary">
                                <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

                                <table class="table table-summary">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($cart_data as $cart)
                                        <tr>
                                            <td><a href="{{ route('product.detail',$cart->relCartToProduct->product_slug) }}">{{ $cart->relCartToProduct->product_title }}</a></td>
                                            <td>BDT {{ $cart->qty*$cart->relCartToProduct->selling_price }}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="summary-subtotal">
                                            @php
                                                $cart_total = 0;
                                                foreach($cart_data as $cart){
                                                    $cart_total_price = $cart->qty*$cart->relCartToProduct->selling_price;
                                                    $cart_total += $cart_total_price;
                                                }
                                            @endphp
                                            <td>Subtotal:</td>
                                            <td>BDT: {{ $cart_total }}</td>
                                        </tr><!-- End .summary-subtotal -->
                                        <tr>
                                            <td>Shipping:</td>
                                            <td>Free shipping</td>
                                        </tr>
                                        <tr class="summary-total">
                                            <td>Total:</td>
                                            <td>BDT {{ $cart_total }}</td>
                                            <input type="hidden" name="grand_total" value="{{ $cart_total }}">
                                        </tr><!-- End .summary-total -->
                                    </tbody>
                                </table><!-- End .table table-summary -->

                                <div class="accordion-summary" id="accordion-payment">
                                @error('payment_method') <p style="color: red;">{{ $message }}</p>@enderror
                                <label for="cod">
                                    <input type="radio" value="cod" name="payment_method" id="cod" style="margin-right: 10px;">Cash on delivery
                                </label>
                                <label for="brn">
                                    <input type="radio" value="mobile banking" name="payment_method" id="brn" style="margin-right: 10px;">bKash/Rocket/Nagad
                                </label>
                                </div>

                                <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                    <span class="btn-text">Place Order</span>
                                    <span class="btn-hover-text">Proceed to Checkout</span>
                                </button>
                            </div><!-- End .summary -->
                        </aside><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                </form>
            </div><!-- End .container -->
        </div><!-- End .checkout -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
@endsection
        

     