<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="SSLCommerz">
    <title>Example - Hosted Checkout | SSLCommerz</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<body class="bg-light">
<div class="container">
    <div class="py-5 text-center">
        <h2>Hosted Payment - SSLCommerz</h2>
        <p class="lead">Below is an example form built entirely with Bootstrap’s form controls. We have provided this sample form for understanding Hosted Checkout Payment with SSLCommerz.</p>
    </div>

    <div class="row">
        <div class="col-md-6 m-auto order-md-2 mb-4">
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (BDT)</span>
                    <strong>{{$payable_total}} TK</strong>
                </li>
            </ul>
            
            <form action="{{ url('/pay') }}" method="POST" class="needs-validation">
                <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                <input type="hidden" name="firstname" value="{{ $arr['firstname'] }}">
                <input type="hidden" name="lastname" value="{{ $arr['last_name'] }}">
                <input type="hidden" name="country" value="{{ $arr['country'] }}">
                <input type="hidden" name="street" value="{{ $arr['street'] }}">
                <input type="hidden" name="appartment" value="{{ $arr['appartment'] }}">
                <input type="hidden" name="city" value="{{ $arr['city'] }}">
                <input type="hidden" name="state" value="{{ $arr['state'] }}">
                <input type="hidden" name="zip" value="{{ $arr['zip'] }}">
                <input type="hidden" name="phone_number" value="{{ $arr['phone_number'] }}">
                <input type="hidden" name="email" value="{{ $arr['email'] }}">
                <input type="hidden" name="payment_method" value="{{ $arr['payment_method'] }}">
                <input type="hidden" name="company" value="{{ $arr['company'] }}">
                <input type="hidden" name="order_notes" value="{{ $arr['order_notes'] }}">
                <input type="hidden" name="payable_amount" value="{{ $payable_total }}">
                <input type="hidden" name="grand_total" value="{{ $arr['grand_total'] }}">
                <input type="text" name="customer" value="{{ $arr['customer'] }}">
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>
            </form>
        </div>
        
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2019 Company Name</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacy</a></li>
            <li class="list-inline-item"><a href="#">Terms</a></li>
            <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
    </footer>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</html>
