<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Invoice</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        .clearfix:after {
        content: "";
        display: table;
        clear: both;
        }

        a {
        color: #5D6975;
        text-decoration: underline;
        }

        body {
        position: relative;
        /* width: 21cm;  
        height: 29.7cm;  */
        margin: 0 auto; 
        color: #001028;
        background: #FFFFFF; 
        font-family: Arial, sans-serif; 
        font-size: 12px; 
        font-family: Arial;
        }

        header {
        padding: 10px 0;
        margin-bottom: 30px;
        }

        #logo {
        text-align: center;
        margin-bottom: 10px;
        }

        #logo img {
        width: 90px;
        }

        h1 {
        border-top: 1px solid  #5D6975;
        border-bottom: 1px solid  #5D6975;
        color: #5D6975;
        font-size: 2.4em;
        line-height: 1.4em;
        font-weight: normal;
        text-align: center;
        margin: 0 0 20px 0;
        background: url(dimension.png);
        }

        #project {
        float: left;
        }

        #project span {
        color: #5D6975;
        text-align: right;
        width: 52px;
        margin-right: 10px;
        display: inline-block;
        font-size: 0.8em;
        }

        #company {
        float: right;
        text-align: right;
        }

        #project div,
        #company div {
        white-space: nowrap;        
        }

        table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
        background: #F5F5F5;
        }

        table th,
        table td {
        text-align: center;
        }

        table th {
        padding: 5px 20px;
        color: #5D6975;
        border-bottom: 1px solid #C1CED9;
        white-space: nowrap;        
        font-weight: normal;
        }

        table .service,
        table .desc {
        text-align: left;
        }

        table td {
        padding: 20px;
        text-align: right;
        }

        table td.service,
        table td.desc {
        vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
        font-size: 1.2em;
        }

        table td.grand {
        border-top: 1px solid #5D6975;;
        }

        #notices .notice {
        color: #5D6975;
        font-size: 1.2em;
        }

        footer {
        color: #5D6975;
        width: 100%;
        height: 30px;
        position: absolute;
        bottom: 0;
        border-top: 1px solid #C1CED9;
        padding: 8px 0;
        text-align: center;
        }
    </style>
</head>
<body>
    Here Your Order Detail,
    
    <header class="clearfix">
        <div id="logo">
          <img src="logo.png">
        </div>
        <h1>INVOICE 3-2-1</h1>
        <div id="company" class="clearfix">
          <div>Company Name</div>
          <div>455 Foggy Heights,<br /> AZ 85004, US</div>
          <div>(602) 519-0450</div>
          <div><a href="mailto:company@example.com">company@example.com</a></div>
        </div>
        <div id="project">
          <div><span>COMPANY</span> {{ $last_billing->customer_company_name }}</div>
          @if($last_billing->relWithCustomer->customer_firstname && $last_billing->relWithCustomer->customer_lastname)
            <div><span>NAME</span> {{ $last_billing->relWithCustomer->customer_firstname.' '.  $last_billing->relWithCustomer->customer_lastname}}</div>
          @else
            <div><span>NAME</span> {{ $last_billing->relWithCustomer->customer_username}}</div>
          @endif
          <div><span>ADDRESS</span> {{ $last_billing->appertment_others }}, {{ $last_billing->street_address }}, {{ $last_billing->town_city }},{{ $last_billing->zip_code }}, {{ $last_billing->customer_country }}</div>
          <div><span>EMAIL</span> <a href="mailto:{{ $last_billing->relWithCustomer->customer_email }}"> {{ $last_billing->relWithCustomer->customer_email }}</a></div>
          <div><span>Phone Number</span> <a href="callto:{{ $last_billing->relWithCustomer->customer_phone_number }}"> {{ $last_billing->relWithCustomer->customer_phone_number }}</a></div>
          <div><span>DATE</span> {{ $last_billing->created_at->format('Y-d-m') }}</div>
          <div><span>ESTIMATE DELIVERY DATE</span> </div>
        </div>
      </header>
      <main>
        <table>
          <thead>
            <tr>
              <th class="service">Product Name</th>
              {{-- <th class="desc">DESCRIPTION</th> --}}
              <th>PRICE</th>
              <th>QTY</th>
              <th>TOTAL</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order_details as $od)
            
            <tr>
              {{-- <td class="service">Design</td> --}}
              <td class="desc">{{ $od->rel_to_product->product_title }}</td>
              <td class="unit">{{ $od->rel_to_product->selling_price }}</td>
              <td class="qty">{{ $od->qty }}</td>
              <td class="total">BDT: {{ $od->qty*$od->rel_to_product->selling_price }}</td>
            </tr>
            @endforeach
            <tr>
              <td colspan="3">SUBTOTAL</td>
              @php
                  $subtotal = 0;
              @endphp
              @foreach($order_details as $d)
                @php
                    $subtotal += $d->qty*$d->rel_to_product->selling_price;
                @endphp
              @endforeach
              <td class="total">BDT: {{ $subtotal }}</td>
            </tr>
            {{-- <tr>
              <td colspan="3">TAX 25%</td>
              <td class="total">$1,300.00</td>
            </tr> --}}
            <tr>
              <td colspan="3" class="grand total">GRAND TOTAL</td>
              <td class="grand total">BDT: {{ $subtotal }}</td>
            </tr>
          </tbody>
        </table>
        <div id="notices">
          <div>NOTICE:</div>
          <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
        </div>
      </main>
      <footer>
        Invoice was created on a computer and is valid without the signature and seal.
      </footer>
</body>
</html>