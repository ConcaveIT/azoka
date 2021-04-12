<?php

use Illuminate\Support\Facades\Config;
use Carbon\Carbon;


function cdn($asset ){



    //Check if we added cdn's to the config file

    if( !Config::get('app.cdn') )

        return asset( $asset );



    //Get file name & cdn's

    $cdns = Config::get('app.cdn');

    $assetName = basename( $asset );

    //remove any query string for matching

    $assetName = explode("?", $assetName);

    $assetName = $assetName[0];



    //Find the correct cdn to use

    foreach( $cdns as $cdn => $types ) {

        if( preg_match('/^.*\.(' . $types . ')$/i', $assetName) )

            return cdnPath($cdn, $asset);

    }



    //If we couldnt match a cdn, use the last in the list.

    end($cdns);

    return cdnPath( key( $cdns ) , $asset);



}



function cdnPath($cdn, $asset) {

    return  "//" . rtrim($cdn, "/") . "/" . ltrim( $asset, "/");

}

function categoryImage($image)
{
    $parentUrl = env('PARENT_URL');

    return $parentUrl . '/images/category/' . $image;
}

function productImage($image)
{

    $parentUrl = env('PARENT_URL');

    if (!$image) {
        $image = 'product-demo.jpg';
    }else{
        $imageArray = explode(',',$image);
        if(count($imageArray) > 0){
            if(!$image){
                if(count($imageArray) > 1){
                    $image = $imageArray[1];
                }
            }else{
                $image = $imageArray[0];
            }

        }else{
            $image = 'product-demo.jpg';
        }
    }
    if(!$image){  
        $image = 'product-demo.jpg';
    }

    return $parentUrl . '/images/product/' . $image;
}

function logo($image)
{
    $parentUrl = env('PARENT_URL');

    return $parentUrl . '/logo/' . $image;
}

function brandImage($image){
    $parentUrl = env('PARENT_URL');


    if (!$image) {
        $image = 'product-demo.jpg';
    }else{
        $imageArray = explode(',',$image);
        if(count($imageArray) > 0){
            if(!$image){
                if(count($imageArray) > 1){
                    $image = $imageArray[1];
                }
            }else{
                $image = $imageArray[0];
            }

        }else{
            $image = 'product-demo.jpg';
        }
    }
    if(!$image){  
        $image = 'product-demo.jpg';
    }


    return $parentUrl . '/images/brand/' . $image;
}





function sliderImage($image){
    $parentUrl = env('PARENT_URL');
    return $parentUrl . '/images/slider/' . $image;
}

function get_slug_id($id){
    $result = DB::table('products')->where('id', $id)->first();
    return $result->slug;
}

function get_deal_price($id, $price){
    $data = DB::table('deals')->where('product_id', $id)->where('expire', '>=', Carbon::now())->first();
    if($data){
        $percentage = $data->percentage;
        if($percentage){
            $percentage_price = ($percentage / 100) * $price;
            return $price - $percentage_price;
        }elseif($data->price){
            return $data->price;
        }else{
            return null;
        }
    }else{
        return null;
    }
}


function price_after_offer_or_not($id, $price, $starting_date, $last_date){
    $data = DB::table('deals')->where('product_id', $id)->where('expire', '>=', Carbon::now())->first();
    if($data){
        $percentage = $data->percentage;
        if($percentage){
            $percentage_price = ($percentage / 100) * $price;
            return $price - $percentage_price;
        }elseif($data->price){
            return $data->price;
        }else{
            return null;
        }
    }else{
        if($starting_date && $last_date){
            $data = DB::table('products')->where('id', $id)->where('starting_date', '<=', $starting_date)->where('last_date', '>=', $last_date)->first();
            if($data){
                if($data->promotion_price){
                    return $data->promotion_price;
                }else{
                    return $data->price;
                }
            }else{
                $data = DB::table('products')->where('id', $id)->first();
                if($data){
                    return $data->price;
                }else{
                    return null;
                }
            }
        }else{
            $data = DB::table('products')->where('id', $id)->first();
            if($data){
                return $data->price;
            }else{
                return null;
            }
        }
    }
}


function url_by_catID_and_slug($cat_id, $slug){
    $cats = DB::table('categories')->where('id', $cat_id)->where('is_active', 1)->first();
    if($cats){
        return url('shop').'/'.$cats->name.'/product/'.$slug;
    }else{
        return null;
    }
}


function combo_prodduct_details_by_id($id){
    return $data = DB::table('products')->where('id', $id)->first();
}


function get_varianPrice($product_id, $is_variant){
    if($is_variant == 1){
        $variant_price = DB::table('product_variants')->where('product_id', $product_id)->sum('additional_price');
        if($variant_price && $variant_price > 0){
            return $variant_price;
        }else{
            return 0;
        }
    }else{
        return 0;
    }
    
}


function get_product_name($order_id){
    $order_details = DB::table('order_details')->where('order_id', $order_id)->first();
    if($order_details){
        $product_id = $order_details->product_id;
        $data = DB::table('products')->where('id', $product_id)->first();
        if($data){
            return $data->name;
        }else{
            return ' - ';
        }
        
    }else{
        return ' - ';
    }
}

function sendSms($msisdn, $messageBody){
	$result = [];
	$api_token = 'Azoka-409c118b-0c7a-40ac-9b3f-4e0fe9c2d082';
	$sid = 'AZOKANONOTP';
	$domain = 'https://smsplus.sslwireless.com';
    $params = [
        "api_token" => $api_token,
        "sid" => $sid,
        "msisdn" => '88'.$msisdn,
        "sms" => $messageBody,
        "csms_id" => mt_rand(1000000, 9999999)
    ];
    $url = trim($domain, '/')."/api/v3/send-sms";
    $params = json_encode($params);

	$ch = curl_init(); // Initialize cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($params),
        'accept:application/json'
    ));
    $response = curl_exec($ch);
	curl_close($ch);
}










?>
