<style>
    .signle_variant_label{
        width: 63px;
        display: inline-block;
    }
    .signle_variant{
        display: inline-block;
        padding-right: 20px;
        text-align: center;
        padding-top: 20px;
    }

    .signle_variant_first{
        padding-top: 0px;
    }
    .signle_variant_label {
        width: 75px;
    }
    .price_font{
        font-size: 18px;
    }
</style>


<div class="modal_body">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="modal_tab">
                    <div class="tab-content product-details-large">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" >
                            <div class="modal_tab_img">
                                <a href="#"><img src="{{ productImage($data->image) }}" alt=""></a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <div class="modal_tab_img">
                                <a href="#"><img src="{{ productImage($data->image) }}" alt=""></a>
                            </div>
                        </div>

                    </div>
                    <div class="modal_tab_button">
                        <ul class="nav product_navactive owl-carousel" role="tablist">
                            <li >
                                <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false">
                                    <img src="{{ productImage($data->image) }}" alt=""></a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">
                                    <img src="{{ productImage($data->image) }}" alt=""></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12">
                <div class="modal_right">
                    <div class="modal_title mb-3">
                        <h2>{{ $data->name }}</h2>
                    </div>
                    <div class="modal_price mb-3">
                        <strong class="price_font" style="font-size: 18px">Price: </strong>
                        <span id="updatedPrice">
                            @if($deal=get_deal_price($data->id, $data->price))
                                {{$deal}}
                                <span class="old_price">BDT {{ $data->price }}</span>
                            @elseif($data->promotion_price)
                                {{ $data->promotion_price }}
                                <span class="old_price">BDT {{ $data->price }}</span>
                            @else
                                BDT {{ $data->price }}
                            @endif
                        </span>
                    </div>
                    {{-- <div class="modal_description mb-3">
                        {!! $data->product_details !!}
                    </div> --}}
                    <div class="variants_selects">
                    @php
                        $size_variant = DB::table('product_variants')->where('product_id', $data->id)->where('variant_by', 'size')->get();
                        $color_variant = DB::table('product_variants')->where('product_id', $data->id)->where('variant_by', 'color')->get();
                        $weight_variant = DB::table('product_variants')->where('product_id', $data->id)->where('variant_by', 'weight')->get();
                    @endphp
                    @if(count($size_variant) > 0 || count($color_variant) > 0 || count($weight_variant) > 0)
                    <div class="product_variant color">
                        <h3>Available Options</h3>
                        @if(count($size_variant) > 0)
                            <div class="signle_variant_label">
                                <h3 for=""> <strong>Size:</strong> </h3>
                            </div>
                            @foreach ($size_variant as $size_data)
                                <div class="signle_variant signle_variant_first">
                                    <input type="radio" class="variant"
                                        data-item-code="{{ $size_data->item_code }}" 
                                        name="{{  $size_data->variant_by }}" value="{{$size_data->id }}"
                                        data-add-price="{{  $size_data->additional_price??0 }}" 
                                        data-quantity="{{  $size_data->qty }}">
                                        <br>
                                        <label for="">{{ $size_data->variant_name }}</label>
                                </div>
                            @endforeach
                            <br>
                        @endif
                        
                        @if(count($color_variant) > 0)
                            <div class="signle_variant_label">
                                <h3 for=""> <strong>Color:</strong> </h3>
                            </div>
                            @foreach ($color_variant as $color_data)
                                <div class="signle_variant">
                                    <input type="radio" class="variant"
                                        data-item-code="{{ $color_data->item_code }}" 
                                        name="{{  $color_data->variant_by }}" value="{{$color_data->id }}"
                                        data-add-price="{{  $color_data->additional_price??0 }}" 
                                        data-quantity="{{  $color_data->qty }}">
                                        <br>
                                        <label for="">{{ $color_data->variant_name }}</label>
                                </div>
                            @endforeach
                            <br>
                        @endif
                        
                        @if(count($weight_variant) > 0)
                            <div class="signle_variant_label">
                                <h3 for="" style="padding-right: 10px;"> <strong>Weight:</strong> </h3>
                            </div>
                            @foreach ($weight_variant as $weight_data)
                                <div class="signle_variant">
                                    <input type="radio" class="variant"
                                        data-item-code="{{ $weight_data->item_code }}" 
                                        name="{{  $weight_data->variant_by }}" value="{{$weight_data->id }}"
                                        data-add-price="{{  $weight_data->additional_price??0 }}" 
                                        data-quantity="{{  $weight_data->qty }}">
                                        <br>
                                        <label for="">{{ $weight_data->variant_name }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @endif

                    <div class="mt-2">
                        <label for="">Inventory : {!! $data->qty > 0 ? $data->qty : 0 !!} products available</label>
                    </div>
                        <div class="modal_add_to_cart">
                            <form action="">
                                <input type="hidden" id="productPrice" value="{{price_after_offer_or_not($data->id, $data->price, $data->starting_date, $data->last_date) }}">
                        
                                <input type="hidden" id="productId_modal" value="{{ $data->id }}" required>
                                <input min="1" max="100" step="1" value="1" id="count_modal" type="number">

                                @if($data->qty > 0)
                                    <a id="addToCartModal" class="customButton py-3 px-5">Add to Cart</a>
                                @else
                                    <p class="ml-2 font-bold text-danger">Out of Stock!</p>
                                @endif
                            </form>
                        </div>
                    <div class="modal_social">
                        <h2>Share this product</h2>
                        <ul>
                            <li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url_by_catID_and_slug($data->category_id, $data->slug)) }}"><i class="fa fa-facebook"></i></a></li>
                            <li class="instagram"><a href="https://www.instagram.com/sharer.php?u={{ urlencode(url_by_catID_and_slug($data->category_id, $data->slug)) }}"><i class="fa fa-instagram"></i></a></li>
                            <li class="twitter"><a href="https://twitter.com/share?url={{ urlencode(url_by_catID_and_slug($data->category_id, $data->slug)) }}"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $('input[name="size"]').click(function () {
        var color_price = $('input[name="color"]:checked').attr('data-add-price') ?? 0;
        var type_price = $('input[name="type"]:checked').attr('data-add-price') ?? 0;
        var weight_price = $('input[name="weight"]:checked').attr('data-add-price') ?? 0;
        var additional_price = $(this).attr('data-add-price');
        var product_price = $('#productPrice').val();
        var new_price = parseInt(product_price)+parseInt(additional_price)+parseInt(color_price)+parseInt(type_price)+parseInt(weight_price);
        $('#updatedPrice').text('BDT '+new_price);
    
        var original_price = $(this).attr('data-original-price');
        var original_and_variant = parseInt(original_price)+parseInt(additional_price)+parseInt(color_price)+parseInt(type_price)+parseInt(weight_price);
        $('.old_price ').text('BDT '+original_and_variant);
    
    });
    
    $('input[name="type"]').click(function () {
        var size_price = $('input[name="size"]:checked').attr('data-add-price') ?? 0;
        var color_price = $('input[name="color"]:checked').attr('data-add-price') ?? 0;
        var weight_price = $('input[name="weight"]:checked').attr('data-add-price') ?? 0;
        var additional_price = $(this).attr('data-add-price');
        var product_price = $('#productPrice').val();
        var new_price = parseInt(product_price)+parseInt(additional_price)+parseInt(size_price)+parseInt(color_price)+parseInt(weight_price);
        $('#updatedPrice').text('BDT '+new_price);
    
        var original_price = $(this).attr('data-original-price');
        var original_and_variant = parseInt(original_price)+parseInt(additional_price)+parseInt(size_price)+parseInt(weight_price)+parseInt(color_price);
        $('.old_price ').text('BDT '+original_and_variant);
    });
    
    $('input[name="color"]').click(function () {
        var size_price = $('input[name="size"]:checked').attr('data-add-price') ?? 0;
        var type_price = $('input[name="type"]:checked').attr('data-add-price') ?? 0;
        var weight_price = $('input[name="weight"]:checked').attr('data-add-price') ?? 0;
        var additional_price = $(this).attr('data-add-price');
        var product_price = $('#productPrice').val();
        var new_price = parseInt(product_price)+parseInt(additional_price)+parseInt(size_price)+parseInt(type_price)+parseInt(weight_price);
        $('#updatedPrice').text('BDT '+new_price);
    
        var original_price = $(this).attr('data-original-price');
        var original_and_variant = parseInt(original_price)+parseInt(additional_price)+parseInt(size_price)+parseInt(type_price)+parseInt(weight_price);
        $('.old_price ').text('BDT '+original_and_variant);
    });
    
    
    $('input[name="weight"]').click(function () {
        var size_price = $('input[name="size"]:checked').attr('data-add-price') ?? 0;
        var type_price = $('input[name="type"]:checked').attr('data-add-price') ?? 0;
        var color_price = $('input[name="color"]:checked').attr('data-add-price') ?? 0;
        var additional_price = $(this).attr('data-add-price');
        var product_price = $('#productPrice').val();
        var new_price = parseInt(product_price)+parseInt(additional_price)+parseInt(size_price)+parseInt(type_price)+parseInt(color_price);
        $('#updatedPrice').text('BDT '+new_price);
    
        var original_price = $(this).attr('data-original-price');
        var original_and_variant = parseInt(original_price)+parseInt(additional_price)+parseInt(size_price)+parseInt(type_price)+parseInt(color_price);
        $('.old_price ').text('BDT '+original_and_variant);
    });    
    </script>
<script>

    $('#addToCartModal').click(function (e) {
        if ($("input[name='size']").length != 0 && !$("input[name='size']").is(':checked')) {
            return alert('Please select size');
        }
        if ($("input[name='color']").length != 0 && !$("input[name='color']").is(':checked')) {
            return alert('Please select color');
        }
        if ($("input[name='type']").length != 0 && !$("input[name='type']").is(':checked')) {
            return alert('Please select type');
        }

        if ($("input[name='weight']").length != 0 && !$("input[name='weight']").is(':checked')) {
            return alert('Please select weight');
        }
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        productId = $('#productId_modal').val();
        colorId = $("input[name='color']:checked").val();
        sizeId = $("input[name='size']:checked").val();
        typeId = $("input[name='type']:checked").val();
        weightId = $("input[name='weight']:checked").val();
        count = $('#count_modal').val();

        $.ajax({
            type: 'POST',
            url: '/cart/add',
            data: {
                _token: CSRF_TOKEN,
                product_id: productId,
                color_id: colorId,
                size_id: sizeId,
                type_id: typeId,
                weight_id: weightId,
                count: count,
            },
            success: function (data) {
                sweetAlter('success', 'Product added to cart');
                $('.cart_sub_total').text('BDT ' + data.cart_sub_total);
                let cart_total_amount = parseInt(data.cart_sub_total);
                $('.cart_total_amount').text('BDT ' + cart_total_amount);
                $('.cart_items_quantity').text(data.cart_items_quantity);
                setTimeout(function(){
                    location.reload();
                }, 1000);
            }
        });

    });
</script>
