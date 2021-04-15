

function sweetAlter(icon, title) {
    Swal.fire({
        backdrop: false,
        position: 'top-end',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: 1500
    });
	
}

$('.wishlistButton').click(function (e) {

    e.preventDefault();

    console.log($('#wishlistCount'));

    let productId = $(this).data('id');

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'POST',
        url: '/wishlist/add',
        data: {
            _token: CSRF_TOKEN,
            productId: productId
        },
        success: function (count) {
            if(count > 0){
               // console.log(count);
                sweetAlter('success', 'Product added to wishlist');
                $('.wishlistCount').text(count);
            }else{
                sweetAlter('error', 'Please login first.');
            }
        }
    });

});

$('.compareButton').click(function (e) {

    e.preventDefault();

    let productId = $(this).data('id');

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'POST',
        url: '/compare/add',
        data: {
            _token: CSRF_TOKEN,
            productId: productId
        },
        success: function (count) {
            sweetAlter('success', 'Product added to compare');
            console.log(count);
            $('.compareCount').text(count);

        }
    });

});












$('#addToCart').click(function (e) {

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

//addToCart
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    productId = $('#productId').val();
    colorId = $("input[name='color']:checked").val();
    sizeId = $("input[name='size']:checked").val();
    typeId = $("input[name='type']:checked").val();
    weightId = $("input[name='weight']:checked").val();
    count = $('#count').val();

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
            if(data == 0){
				sweetAlter('error', 'Stock is limited for this product. Please try to add less item(s).');
			}else{
				sweetAlter('success', 'Product added to cart');
				$('.cart_sub_total').text('BDT ' + data.cart_sub_total);
				let cart_total_amount = parseInt(data.cart_sub_total);
				$('.cart_total_amount').text('BDT ' + cart_total_amount);
				$('.cart_items_quantity').text(data.cart_items_quantity);
				setTimeout(function(){
					location.reload();
				 }, 1000);
			}
        }
    });

});

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




$(".chooseColor").click(function () {
    $(this).addClass("activeOption");
    $(".chooseColor").not(this).removeClass("activeOption");
});

$(".chooseSize").click(function () {
    $(this).addClass("activeOption");
    $(".chooseSize").not(this).removeClass("activeOption");
});


$('.quickButton').click(function (e) {

    var url = $(this).data('url');

    $('#dynamic-content').html('');
    $('#modal-loader').show();

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html'
    }).done(function (data) {
            $('#dynamic-content').html('');
            $('#dynamic-content').html(data);
            $('#modal-loader').hide();
        }).fail(function () {
            $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"/> Something went wrong, Please try again...');
            $('#modal-loader').hide();
        });
});

$('#filter').on('click', function (e) {

    e.preventDefault();
    let amount = $('#amount').val();
    amount = amount.split(' - ');
    minAmount = parseInt(amount[0]);
    maxAmount = parseInt(amount[1]);

    let category = parseInt($('.category:selected').val());
    let brand = parseInt($('.brand:selected').val());
    let size = parseInt($('.size:selected').val());

    if (isNaN(category)) category = -1;
    if (isNaN(brand)) brand = -1;
    if (isNaN(size)) size = -1;

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'POST',
        url: '/filter-product',
        data: {
            _token: CSRF_TOKEN,
            category_id: category,
            brand_id: brand,
            size_id: size,
            min_amount: minAmount,
            max_amount: maxAmount
        },
        success: function (result) {
            console.log(result);
            $('#chooseProduct').html(result);
        }
    });

});

$('#filterShop').on('click', function (e) {

    e.preventDefault();
    let amount = $('#amount').val();
    amount = amount.split(' - ');
    minAmount = parseInt(amount[0]);
    maxAmount = parseInt(amount[1]);

    let category_id = $('#category_id').val();

    let brand = parseInt($('.brand:selected').val());
    let brand_name = $('.brand:selected').text();

    if(brand_name == -1){
        brand_name = 'All Brand';
    }
    if (isNaN(brand)){
        brand = -1;
        brand_name = 'All Brand';
    } 


    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'GET',
        url: '/filter-product-shop',
        data: {
            _token: CSRF_TOKEN,
            brand_id: brand,
            brand_name: brand_name,
            category_id: category_id,
            min_amount: minAmount,
            max_amount: maxAmount
        },
        success: function (result) {
            $('.shop_banner_area').html('<h2 style="font-size: 28px;">Showing Result(s) for '+'"'+brand_name+'"'+'</h2>');
            $('.shop_toolbar').hide();
            if(result == 0){
                $('.shop_toolbar_wrapper').html('<p>There is no product for this brand.</p>');
                $('.shop_toolbar_wrapper').hide();
               // alert('dddddd');
            }else{
                $('#chooseProduct').html(result);
            }
            
        }
    });

});

$('#filterSubShop').on('click', function (e) {

    e.preventDefault();
    let amount = $('#amount').val();
    amount = amount.split(' - ');
    minAmount = parseInt(amount[0]);
    maxAmount = parseInt(amount[1]);

    let sub_category_id = $('#sub_category_id').val();

    let brand = parseInt($('.brand:selected').val());
    let size = parseInt($('.size:selected').val());

    if (isNaN(brand)) brand = -1;
    if (isNaN(size)) size = -1;

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'GET',
        url: '/filter-product-subshop',
        data: {
            _token: CSRF_TOKEN,
            brand_id: brand,
            size_id: size,
            sub_category_id: sub_category_id,
            min_amount: minAmount,
            max_amount: maxAmount
        },
        success: function (result) {
            $('#chooseProduct').html(result);
        }
    });

});

$('.rating').on('click', function (e) {
    e.preventDefault();
    let star = $(this).data('value');
    $('#star').val(star);
});

$('#customerRating').on('click', function (e) {
    e.preventDefault();

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'POST',
        url: '/product/rate',
        data: {
            _token: CSRF_TOKEN,
            product_id: $('#product').val(),
            comment: $('#comment').val(),
            star: $('#star').val()
        },
        success: function (result) {
            console.log(result);
            sweetAlter('success', 'Thank you for your review!');
        }
    });

});

$('input[name="location"]').on('change', function () {
    value = $(this).val();
	console.log(cart_items_quantity); 
	var calQty = Math.ceil(cart_items_quantity/5);
	if(calQty < 1) calQty = 1;
	

    switch (value) { 
        case 'inside_dhaka':

			shipping_cost = calQty * 80;
            $('#shippingCost').text('BDT ' + shipping_cost);


            break;

        case 'outside_dhaka':
            shipping_cost = calQty * 150;
            $('#shippingCost').text('BDT ' + shipping_cost);
            break;
    }

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'POST',
        url: '/set-shipping-cost',
        data: {
            _token: CSRF_TOKEN,
            shipping_cost: shipping_cost
        },
        success: function (data) {
           // console.log(data);
        }
    });

});



$(document).on('click', '#header_cart', function(){
    var data = $(this).attr('data-cart-id');
    $.ajax({
        type: 'GET',
        url: '/remove/headercart/'+data,
        success: function(data) {
            if(data == 1){
                location.reload();
            }
        }
    });
});

$(document).on('click','#searchIcon',function(){
    $(this).next('.dropdown_search').toggle();
    document.getElementById("dropdown_search_input").focus();
});

$(document).on('click','.variant',function(){
	$('#qty_display').html($(this).attr('data-quantity'));
	$('#count').attr('data-cart-limit',$(this).attr('data-quantity'));
});












