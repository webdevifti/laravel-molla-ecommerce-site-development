@if($all_brands)
<div class="container">
    <hr class="mb-0">
    <div class="owl-carousel mt-5 mb-5 owl-simple" data-toggle="owl" 
        data-owl-options='{
            "nav": false, 
            "dots": false,
            "margin": 30,
            "loop": false,
            "responsive": {
                "0": {
                    "items":2
                },
                "420": {
                    "items":3
                },
                "600": {
                    "items":4
                },
                "900": {
                    "items":5
                },
                "1024": {
                    "items":6
                }
            }
        }'>
        @foreach($all_brands as $brand)
        <a href="#" class="brand">
            <img src="{{ asset('uploads/brands/'.$brand->brand_image) }} " title="{{ $brand->brand_name }}" alt="Brand Name">
        </a>
        @endforeach
      
    </div><!-- End .owl-carousel -->
</div><!-- End .container -->
@else

@endif