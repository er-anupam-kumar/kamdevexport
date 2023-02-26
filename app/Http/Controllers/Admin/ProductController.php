<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;
use App\Http\Requests\Admin\Product\Create;
use App\Http\Requests\Admin\Product\Delete;
use App\Http\Requests\Admin\Product\Update;
use Carbon\Carbon;
use Str;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductImage;
use File;

class ProductController extends Controller
{
    

    public function __construct()
    {
        $this->sortable_columns = [
            0 => 'id',
            1 => 'name',
            2 => 'category',
            3 => 'status',
            4 => 'featured',            
            5 => 'created_at',
            6 => 'actions'
        ];
    }
    public function index(Request $request)
    {

        if($request->ajax())
        {
            $limit         = $request->input('length');
            $start         = $request->input('start');
            $search        = $request['search']['value'];
            $orderby       = $request['order']['0']['column'];
            $order         = $orderby != "" ? $request['order']['0']['dir'] : "";
            $draw          = $request['draw'];

            $status        = $request['columns'][3]['search']['value'];
            $date          = $request['columns'][4]['search']['value'];
            $to_date        = $request['columns'][5]['search']['value'];

            $response      = Product::getAdminProductModel($limit, $start, $search, $this->sortable_columns[$orderby], $order,$status,$date,$to_date);

            $returnresult  = $response['response'];
            $totalProduct  = $response['count'];

            if(!$response){
                $products  = [];
                $paging    = [];
            }
            else{
                $products  = $returnresult;
                $paging    = $returnresult;
            }

            $productData = array();
            $i = 1;

            foreach ($products as $product) {
                $u['id']            = $i;
                $u['name']          = $product->name;
                $u['category']      = $product->category;
                $u['sku']           = $product->sku;
                $u['listing_price'] = $product->listing_price;
                $u['sell_price']    = $product->sell_price;
                $u['description']   = $product->description;
                $u['featured']      = $product->featured;

                $u['created_at']    = getDateWithFormat($product->created_at);
                $status             = view('admin.products.status', [
                    'product'       => $product
                ]);
                $u['status']        = $status->render(); 

                $actions            = view('admin.products.actions', [
                    'product'       => $product
                ]);
                $u['actions']       = $actions->render(); 

                $productData[] = $u;
                $i++;

                unset($u);
            }

            $return = [
                "draw"              =>  intval($draw),
                "recordsFiltered"   =>  intval( $totalProduct),
                "recordsTotal"      =>  intval( $totalProduct),
                "data"              =>  $productData
            ];

            return $return;
        }
        
        return view('admin.products.index');
    }

    public function create()
    {   
        $categories = Category::where('id','!=','')->get();
        
        return view('admin.products.create')->with('categories',$categories);
    }

    public function store(Create $request){
        $input = $request->all();

        if(!isset($input['sizes']) || !isset($input['variant_listing_price']) || count($input['variant_listing_price'])==0){
            return response([
                'success'=> false,
                'message'=>'Please add atleast 1 variation .',
            ], 400);

        }

        $product = new Product;

        $product->name              = $input['name'];
        $product->category          = $input['category'];
        $product->short_description = $input['short_description'];
        $product->description       = $input['description'];
        $product->meta_tags         = $input['meta_tags'];
        $product->meta_description  = $input['meta_description'];
        $product->featured          = $input['featured'];

        $product->created_at   = Carbon::now();
        $product->updated_at   = Carbon::now();
        $product->status       = $input['product_status'];

        $product->slug = Str::slug($input['name']);

        $product->save();


        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $key=>$file) {

                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());
                Storage::putFileAs('public/products', $file, $name);
                $path = Storage::url('products/'.$name);

                $image = new ProductImage;
                $image->product_id = $product->id;
                $image->image_url  = $path;
                $image->save();
            }
        }

        if(isset($input['sizes']) && isset($input['variant_listing_price']) && count($input['variant_listing_price'])>0){
            for ($i=0; $i < count($input['variant_listing_price']) ; $i++) { 

                $find_variation = ProductVariation::where('product_id',$product->id)->where('size',$input['sizes'][$i])->first();

                if(!$find_variation){
                    $variation = New ProductVariation;
                    $variation->product_id = $product->id;
                    $variation->sell_price    = $input['variant_sell_price'][$i];
                    $variation->listing_price = $input['variant_listing_price'][$i];
                    $variation->sku  = $input['variant_sku'][$i];
                    $variation->size = $input['sizes'][$i];
                    $variation->quantity   = $input['variant_quantity'][$i];
                    
                    $variation->save();
                }
            }
        }

        return response([
            'success'=> true,
            'message'=>'Product created successfully.',
            'url' => url('admin/products')
        ], 201);

    }

    public function edit($id) {

        $id = decrypt($id);
        $product = Product::where('id', $id)->first();
        $categories = Category::where('id','!=','')->get();

        return view('admin.products.edit')->with('product', $product)->with('images', $product->getImages)->with('variations', $product->getVariations)->with('categories',$categories);
    }

    public function update(Update $request,$id){

        $input = $request->all();
        $id=decrypt($id);
        if(!isset($input['sizes']) || !isset($input['variant_listing_price']) || count($input['variant_listing_price'])==0){
            return response([
                'success'=> false,
                'message'=>'Please add atleast 1 variation .',
            ], 400);
        }

        $product =  Product::find($id);

        $product->name        = $input['name'];
        $product->category    = $input['category'];
        $product->short_description = $input['short_description'];
        $product->description = $input['description'];
        $product->meta_tags   = $input['meta_tags'];
        $product->meta_description  = $input['meta_description'];
        $product->featured    = $input['featured'];
        $product->updated_at  = Carbon::now();
        $product->status      = $input['product_status'];

        $product->slug = Str::slug($input['name']);

        $product->save();


        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $key=>$file) {

                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());
                Storage::putFileAs('public/products', $file, $name);
                $path = Storage::url('products/'.$name);

                $image = new ProductImage;
                $image->product_id = $product->id;
                $image->image_url  = $path;
                $image->save();
            }
        }

        $delete_variation = ProductVariation::where('product_id',$product->id)->delete();
        if(isset($input['sizes']) && isset($input['variant_listing_price']) && count($input['variant_listing_price'])>0){
            for ($i=0; $i < count($input['variant_listing_price']) ; $i++) { 

                $find_variation = ProductVariation::where('product_id',$product->id)->where('size',$input['sizes'][$i])->first();

                if(!$find_variation){
                    $variation = New ProductVariation;
                    $variation->product_id = $product->id;
                    $variation->sell_price    = $input['variant_sell_price'][$i];
                    $variation->listing_price = $input['variant_listing_price'][$i];
                    $variation->sku  = $input['variant_sku'][$i];
                    $variation->size = $input['sizes'][$i];
                    $variation->quantity   = $input['variant_quantity'][$i];
                    
                    $variation->save();
                }
            }
        }
        return response([
            'success'=> true,
            'message'=>'Product updated successfully.',
            'url' => url('admin/products')
        ], 201);
    }

    public function destroy(Delete $request)
    {
        try{
            $input   = $request->all();
            $id      = decrypt($input['id']);

            // $check = ProductVariation::where('product_id',$id)->first();
            // if($check){
            //     return response([
            //         'success'=> false,
            //         'message'=>'Product can not be deleted as it is used in the system.',
            //         'url' => url('admin/products')
            //     ], 400);
            // } 

            $product = Product::find($id);

            // $check = OrderItem::where('product_id',$product->id)->exists();
            // if($check){
            //     return response(['message'=>'This product is already related with some order.'], 400);
            // }

            $product->delete();       

            return response([
                'success'=> true,
                'message'=>'Product deleted successfully.',
                'url' => url('admin/products')
            ], 200);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function destroyImage($id, Request $request) {

        try {

            $image = ProductImage::with('getParentProduct')->findOrFail($id);

            if (!empty($image)) {
                File::delete(public_path() .$image->image_url);
                $image->delete();
            } else {
                throw new ModelNotFoundException();
            }
            $response = array(
                'status' => 'success',
                'message' => 'Product Image successfully deleted.',
            );

        } catch (Exception $e) {
            $response = array(
                'status' => 'failed',
                'message' => 'Product Image not found.',
            );
        }
        return $response;

    }
}
