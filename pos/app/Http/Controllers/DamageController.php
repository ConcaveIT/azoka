<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\CustomerGroup;
use App\Warehouse;
use App\Biller;
use App\Product;
use App\Unit;
use App\Tax;
use App\Product_Warehouse;
use DB;
use App\Damages;
use App\Account;
use App\ProductReturn;
use App\ProductVariant;
use App\Variant;
use App\CashRegister;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DamageController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('returns-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
			
                $lims_return_all = Damages::with('warehouse', 'user')->orderBy('id', 'desc')->get();
            return view('damage.index', compact('lims_return_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create(){
		$allProducts = Product::with('variant')->get();
		return view('damage.create', compact('allProducts'));
    }

    public function update(Request $request){

	   if($request->variant_id == 0){
		   $product = Product::find($request->product_id);
		   if($product->qty >= $request->qty){
			$product->qty = $product->qty - $request->qty ;
		    $product->save();
		   }else{
			   return redirect('damage-sale')->with('not_permitted', 'You can not add damaged item more than your stock!');
		   }

	   }else{
		   $variant = ProductVariant::where('variant_id',$request->variant_id)->first();
		   
		   $product = Product::find($request->product_id);
		   if($product->qty >= $request->qty){
			$product->qty = $product->qty - $request->qty ;
		    $product->save();
		   }else{
			   return redirect('damage-sale')->with('not_permitted', 'You can not add damaged item more than your stock!');
		   }
		   
		   
		   	if($variant->qty >= $request->qty){
				$qty = $variant->qty - $request->qty ;
				$variant->update(['qty' => $qty]);
			}else{
				return redirect('damage-sale')->with('not_permitted', 'You can not add damaged item more than your stock!');
			}
		   
	   }
	   
	   	Damages::insert(
			['product_id' => $request->product_id, 'variant_id' => $request->variant_id, 'qty' => $request->qty,'note' => $request->note, 'created_at' => \Carbon\Carbon::now(),  'updated_at' => \Carbon\Carbon::now()]
	   );
        $message = 'Damaged product listed successfully!';
        return redirect('damage-sale')->with('message', $message);
    }




    public function destroy($id){
        $deleted = Damages::find($id);
		$qty = $deleted->qty;
		
		 if($deleted->variant_id == 0){
		   $product = Product::find($deleted->product_id);
		   $product->qty = $product->qty + $deleted->qty ;
		   $product->save();
	   }else{
		   $variant = ProductVariant::where('variant_id',$deleted->variant_id)->first();
		   $qty = $variant->qty + $deleted->qty ;
		   $variant->update(['qty' => $qty]);
	   }
        $deleted->delete();
		
        return redirect('damage-sale')->with('not_permitted', 'Data deleted successfully');;
    }
}
