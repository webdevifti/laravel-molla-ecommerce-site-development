@if($explore_popular_categories)
<div class="container">
    <h2 class="title text-center mb-4">Explore Popular Categories</h2><!-- End .title text-center -->
    
    <div class="cat-blocks-container">
        <div class="row">
            @foreach ($explore_popular_categories as $exp_po_cat)
                
                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="/shop/{{ $exp_po_cat->category_slug }}" class="cat-block">
                        <figure>
                            <span>
                                <img src="{{ asset('uploads/categories/'.$exp_po_cat->category_image) }}" alt="Category image">
                            </span>
                        </figure>
                        
                        <h3 class="cat-block-title">{{ $exp_po_cat->category_name }}</h3><!-- End .cat-block-title -->
                    </a>
                </div><!-- End .col-sm-4 col-lg-2 -->
            @endforeach
        </div><!-- End .row -->
    </div><!-- End .cat-blocks-container -->
</div>
@endif