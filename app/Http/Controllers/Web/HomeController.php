<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductVariation;
use Exception;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function index()
    {
        $products = Product::where('status','1')->get();
        $categories = Category::where('status','1')->get();
        $banners = Banner::where('status','1')->get();
        return view('web.home.index')->with('categories',$categories)->with('products',$products)->with('banners',$banners);
    }
    public function shop()
    {
        $q = Product::where('status','1');

        if (request()->has('range') && request()->range!='') {
            $min_range = explode('-',request()->range)[0];
            $max_range = explode('-',request()->range)[1];

            $q->whereHas('getVariations',function($query) use ($min_range,$max_range) {
                $query->whereBetween('listing_price', [$min_range, $max_range]);
            });
        }

        if (request()->has('category') && request()->category!='') {
            $category = Category::where('slug',request()->category)->first();

            if ($category) {
                $q->where('category',$category->name);
            }
        }

        if (request()->has('tag') && request()->tag!='') {
            $tag = request()->tag;

            $q->where(function($query) use ($tag) {
                $query->where('name', 'LIKE', '%'.$tag.'%')
                ->orWhere('category', 'LIKE', '%'.$tag.'%')
                ->orWhere('meta_tags', 'LIKE', '%'.$tag.'%')
                ->orWhere('description', 'LIKE', '%'.$tag.'%');
            });
        }

        if (request()->has('sort_by') && request()->sort_by!='') {
            $sort_by = request()->sort_by;

            if ($sort_by=='latest') {
                $q->orderBy('created_at','DESC');
            }

            if ($sort_by=='name_asc') {
                $q->orderBy('name','ASC');
            }

            if ($sort_by=='name_desc') {
                $q->orderBy('name','DESC');
            }

            if ($sort_by=='price_asc') {
                $q->whereHas('getVariations',function($query) use ($sort_by) {
                    $query->orderBy('listing_price', 'ASC');
                });
            }

            if ($sort_by=='price_desc') {
                $q->whereHas('getVariations',function($query) use ($sort_by) {
                    $query->orderBy('listing_price', 'DESC');
                });
            }

            if ($sort_by=='featured') {
                $q->where('featured','Yes');
            }
        }else{
            $q->orderBy('created_at','DESC');
        }

        $products = $q->inRandomOrder()->paginate(24)->withQueryString();

        $tags = [];
        foreach ($products as $key => $product) {
            $taglist = explode(',', $product->meta_tags);
            foreach ($taglist as $key => $tagname) {
                if (!in_array(strtolower($tagname), $tags)) {
                    array_push($tags, strtolower($tagname));
                }
            }
        }

        $categories = Category::where('status','1')->get();

        return view('web.shop.index')->with('products',$products)->with('categories',$categories)->with('tags',$tags);
    }
    public function product($slug){
        $product = Product::where('slug',$slug)->first();

        if (request()->has('v_id') && request()->v_id!='') {
            try{
                $v_id = decrypt(request()->v_id);
                $variant = ProductVariation::find($v_id);
            }catch(Exception $e){
                return abort(404);
            }
        }else{
            $variant = $product->getSingleVariant;
        }

        return view('web.product.index')->with('product',$product)->with('variant',$variant);
    }
    public function checkout()
    {
        return view('web.checkout.index');
    }
    public function about_us()
    {
        return view('web.about_us.index');
    }
    public function cart()
    {
        return view('web.cart.index');
    }
    public function privacy_policy()
    {
        return view('web.privacy_policy.index');
    }
    public function terms_and_conditions()
    {
        return view('web.terms_and_conditions.index');
    }
}
