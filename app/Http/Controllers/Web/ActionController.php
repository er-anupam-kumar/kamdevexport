<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use App\Models\Product;
use App\Models\ProductVariation;
use Auth;
use Illuminate\Http\Request;
use Session;

class ActionController extends Controller
{
    public function actions(Request $request)
    {
        $input = $request->all();

        switch ($input['action']) {
            case 'cart':
            return $this->cart($input);
            break;

            case 'favourite':
            return $this->favourite($input);
            break;
            
            default:
            return $this->quick($input);
            break;
        }
    }

    public function favourite($input)
    {
        $variant = decrypt($input['variant']);
        $find = Favourite::where('variation_id',$variant)->where('customer_id',Auth::id())->first();

        if ($find) {
            $executed = 'removed';
            $message  = 'Product removed from your favourite list';
            $find->delete();
        }else{
            $executed = 'added';
            $message  = 'Product added to your favourite list';

            $favourite = new Favourite;
            $favourite->customer_id = Auth::id();
            $favourite->variation_id = $variant;
            $favourite->save();
        }

        return response([
            'success'   => true,
            'message'   => $message,
            'executed'  =>$executed
        ],200);
    }

    public function cart($input)
    {
        $id = decrypt($input['variant']);
        $variant = ProductVariation::find($id);
        $product = Product::find($variant->product_id);

        $cart = Session::get('cart');
        if(!$cart){
            $cart = [];
        }

        if (inMyCart($variant->id)) {
            $executed = 'removed';
            $message  = 'Product removed from your cart';
            
            $delete_key = null;

            foreach ($cart as $key => $item) {
                if ($item['product_id']==$variant->product_id && $item['sku']==$variant->sku) {
                    $delete_key = $key;
                }
            }

            if ($delete_key>=0) {
                unset($cart[$delete_key]);
            }

        }else{
            $executed = 'added';
            $message  = 'Product added to your cart';
            $quantity = $input['quantity']??1;
            $item = [
                'product_id'   => $variant->product_id,
                'customer_id'  => Auth::id(),
                'product_name' => $product->name,
                'listing_price'=> $variant->listing_price,
                'sell_price'   => $variant->sell_price,
                'sku'          => $variant->sku,
                'attr'         => $product->attribute,
                'attr_value'   => $variant->attr_value,
                'unit'         => $variant->unit,
                'quantity'     => $quantity,
                'tax_rate'     => $product->tax_rate,
                'tax'          => round($quantity*$variant->sell_price*$product->tax_rate/100),
                'total'        => round($quantity*$variant->sell_price),
            ];
            array_push($cart, $item);
        }

        Session::put('cart', $cart);

        if (Auth::check()) {
            updateSessionCartToDB();
        }        

        return response([
            'success'   => true,
            'message'   => $message,
            'executed'  => $executed
        ],200);
    }

    public function quick($input)
    {
        $id = decrypt($input['variant']);
        $variant = ProductVariation::find($id);
        $product = Product::find($variant->product_id);

        return response([
            'success'   => true,
            'product'   => $product,
            'variant'   => $variant
        ],200);
    }
}
