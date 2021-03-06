@extends('master')
@section('page_title','My Dashboard')
@section('MainContent')
    <main class="main">
        <div class="page-header text-center" style="background-image: url({{ asset('site_assets/assets/images/page-header-bg.jpg') }})">
            <div class="container">
                <h1 class="page-title">My Account<span>Shop</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Account</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Account</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->
        @if(session()->has('updated'))
            <p style="color: #fff;text-align:center;font-size: 21px;background: green;">{{ session()->get('updated') }}</p>
        @endif  
        @if(session()->has('orderDone'))
            <p style="color: #fff;text-align:center;font-size: 21px;background: green;">{{ session()->get('orderDone') }}</p>
        @endif
        @if(session()->has('pass_changed'))
            <p style="color: #fff;text-align:center;font-size: 21px;background: green;">{{ session()->get('pass_changed') }}</p>
        @endif
        <div class="page-content">
            <div class="dashboard">
                <div class="container">
                    <div class="row">
                        <aside class="col-md-4 col-lg-3">
                            <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab" aria-controls="tab-orders" aria-selected="false">Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-downloads-link" data-toggle="tab" href="#tab-downloads" role="tab" aria-controls="tab-downloads" aria-selected="false">Downloads</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-address-link" data-toggle="tab" href="#tab-address" role="tab" aria-controls="tab-address" aria-selected="false">Adresses</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">Account Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('customer.logout')  }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('signout-form').submit();">
                                     {{ __('Sign Out') }}
                                 </a>
                                
                                 <form id="signout-form" action="{{ route('customer.logout')  }}" method="POST" class="d-none">
                                     @csrf
                                 </form>
                                   
                                </li>
                            </ul>
                        </aside><!-- End .col-lg-3 -->

                        <div class="col-md-8 col-lg-9">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
                                    <p>Hello <span class="font-weight-normal text-dark">{{ $customer->customer_username }}</span> 
                                    <br>
                                    From your account dashboard you can view your <a href="#tab-orders" class="tab-trigger-link link-underline">recent orders</a>, manage your <a href="#tab-address" class="tab-trigger-link">shipping and billing addresses</a>, and <a href="#tab-account" class="tab-trigger-link">edit your password and account details</a>.</p>
                                </div><!-- .End .tab-pane -->

                                <div class="tab-pane fade" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">
                                    @if($orderPurchase->count() != 0)
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Invoice ID</th>
                                                <th>Payment Method</th>
                                                <th>Payment Status</th>
                                                <th>Grand Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orderPurchase as $order)
                                            <tr>
                                                {{-- <td>{{ $order->relWithBillInfo->customer_company_name }}</td> --}}
                                                <td>{{ $order->orderTrackingID }}</td>
                                                <td>{{ $order->invoiceID }}</td>
                                                <td>{{ ($order->payment_method == 'cod' ? 'Cash on Delivery': $order->payment_method) }}</td>
                                                <td>{{ $order->payment_status }}</td>
                                                <td>BDT: {{ $order->grand_total }}</td>
                                                <td>
                                                    <a class="btn btn-info" href="#orderdetailmodal{{ $order->id }}"  data-toggle="modal" >View Details</a>
                                                    <a href="{{ route('download.pdf') }}" class="btn btn-success">Download Invoice</a>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="orderdetailmodal{{ $order->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" style="max-width: 80% !important" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true"><i class="icon-close"></i></span>
                                                            </button>

                                                            <div style="padding: 10px;">
                                                                @foreach($orderDetails as $od)
                                                                
                                                                <div style="width: 100%; display:flex;align-items:center;justify-content:space-between">
                                                                <p><img style="width: 100px;height: 100px;object-fit:cover" src="{{ asset('uploads/products/previews/'. $od->rel_to_product->product_preview_img) }}" alt=""></p>
                                                                <p>{{ $od->rel_to_product->product_title }}</p>
                                                                <p>{{ $od->qty }}</p>
                                                                <p>{{ $od->rel_to_product->selling_price }}</p>
                                                                <p>Sub Total: {{ $od->qty*$od->rel_to_product->selling_price }}</p>
                                                                </div>
                                                                 
                                                                @endforeach
                                                            </div>
                                                           
                                                        </div><!-- End .modal-body -->
                                                    </div><!-- End .modal-content -->
                                                </div><!-- End .modal-dialog -->
                                            </div><!-- End .modal -->
                                           
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <p>No order has been made yet.</p>
                                        <a href="/shop" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
                                    @endif
                                </div><!-- .End .tab-pane -->

                                <div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="tab-downloads-link">
                                    <p>No downloads available yet.</p>
                                    <a href="category.html" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
                                </div><!-- .End .tab-pane -->

                                <div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
                                    <p>The following addresses will be used on the checkout page by default.</p>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card card-dashboard">
                                                <div class="card-body">
                                                    <h3 class="card-title">Billing Address</h3><!-- End .card-title -->

                                                    <p>User Name<br>
                                                    User Company<br>
                                                    John str<br>
                                                    New York, NY 10001<br>
                                                    1-234-987-6543<br>
                                                    yourmail@mail.com<br>
                                                    <a href="#">Edit <i class="icon-edit"></i></a></p>
                                                </div><!-- End .card-body -->
                                            </div><!-- End .card-dashboard -->
                                        </div><!-- End .col-lg-6 -->

                                        <div class="col-lg-6">
                                            <div class="card card-dashboard">
                                                <div class="card-body">
                                                    <h3 class="card-title">Shipping Address</h3><!-- End .card-title -->

                                                    <p>You have not set up this type of address yet.<br>
                                                    <a href="#">Edit <i class="icon-edit"></i></a></p>
                                                </div><!-- End .card-body -->
                                            </div><!-- End .card-dashboard -->
                                        </div><!-- End .col-lg-6 -->
                                    </div><!-- End .row -->
                                </div><!-- .End .tab-pane -->

                                <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
                                    <form action="{{ route('customer.profile.update',$customer->id) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>First Name *</label>
                                                <input type="text" name="first_name" class="form-control"  value="{{ $customer->customer_firstname }}">
                                                @error('first_name') <span style="color: red">{{ $message }}</span>@enderror
                                            </div><!-- End .col-sm-6 -->

                                            <div class="col-sm-6">
                                                <label>Last Name *</label>
                                                <input type="text" name="last_name" class="form-control" required value="{{ $customer->customer_lastname }}">
                                                @error('last_name') <span style="color: red">{{ $message }}</span>@enderror
                                            </div><!-- End .col-sm-6 -->
                                        </div><!-- End .row -->

                                        <label>Display Name *</label>
                                        <input type="text" readonly value="{{ $customer->customer_username }}" class="form-control" name="user_name" required>
                                        <small class="form-text">This will be how your name will be displayed in the account section and in reviews</small>
                                        @error('user_name') <span style="color: red">{{ $message }}</span>@enderror

                                        <label>Email address *</label>
                                        <input type="email" name="email" value="{{ $customer->customer_email }}" class="form-control" readonly>
                                        @error('email') <span style="color: red">{{ $message }}</span>@enderror

                                        <label>Phone Number *</label>
                                        <input type="text" name="phone_number" class="form-control" required value="{{ $customer->customer_phone_number }}">
                                        @error('phone_number') <span style="color: red">{{ $message }}</span>@enderror

                                        <label>Current password (leave blank to leave unchanged)</label>
                                        <input type="password" name="current_pass" class="form-control">
                                        @if(session()->has('current_pass_not_match'))
                                            <p style="color: red">{{ session()->get('current_pass_not_match') }}</p>
                                        @endif
                                        <label>New password (leave blank to leave unchanged)</label>
                                        <input type="password" name="new_password" class="form-control">

                                        <label>Confirm new password</label>
                                        <input type="password" name="confirm_new_pass" class="form-control mb-2">
                                        @if(session()->has('both_pass_not_macth'))
                                            <p style="color: red">{{ session()->get('both_pass_not_macth') }}</p>
                                        @endif
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>SAVE CHANGES</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </form>
                                </div><!-- .End .tab-pane -->
                            </div>
                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .dashboard -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection