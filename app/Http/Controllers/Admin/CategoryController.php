<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Category\Create;
use App\Http\Requests\Admin\Category\Delete;
use App\Http\Requests\Admin\Category\Update;
use App\Models\Category;
use App\Models\Product;
use Auth;
use Carbon\Carbon;
use Str;
use Storage;
use File;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->sortable_columns = [
            0 => 'id',
            1 => 'name',
            2 => 'featured',
            3 => 'status',
            4 => 'actions'
        ];
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $limit          = $request->input('length');
            $start          = $request->input('start');
            $search         = $request['search']['value'];
            $orderby        = $request['order']['0']['column'];
            $order          = $orderby != "" ? $request['order']['0']['dir'] : "";
            $draw           = $request['draw'];

            $status         = $request['columns'][3]['search']['value'];
            // $date           = $request['columns'][4]['search']['value'];
            $response       = Category::getAdminCategoryModel($limit, $start, $search, $this->sortable_columns[$orderby], $order,$status);

            $returnresult   = $response['response'];
            $totalCategory  = $response['count'];

            if(!$response){
                $categories = [];
                $paging     = [];
            }
            else{
                $categories = $returnresult;
                $paging     = $returnresult;
            }

            $categoryData = array();
            $i = 1;

            foreach ($categories as $category) {
                $u['id']               = $i;
                $u['name']             = $category->name;
                $u['description']      = $category->description;
                $u['meta_tags']        = $category->meta_tags;
                $u['meta_description'] = $category->meta_description;
                $u['featured']         = $category->featured;
                // $u['created_at']    = getDateWithFormat($category->created_at);
                $status             = view('admin.categories.status', [
                    'category'      => $category
                ]);
                $u['status']        = $status->render(); 

                $actions            = view('admin.categories.actions', [
                    'category'      => $category
                ]);
                $u['actions']       = $actions->render(); 

                $categoryData[] = $u;
                $i++;

                unset($u);
            }

            $return = [
                "draw"              =>  intval($draw),
                "recordsFiltered"   =>  intval( $totalCategory),
                "recordsTotal"      =>  intval( $totalCategory),
                "data"              =>  $categoryData
            ];

            return $return;
        } 

        return view('admin.categories.index');
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Create $request){

        $input = $request->all();

        $category = new Category;
        $category->name              = $input['name'];
        $category->description       = $input['description'];
        $category->meta_description  = $input['meta_description'];
        $category->meta_tags         = $input['meta_tags'];
        $category->featured          = $input['featured'];
        $category->created_at   = Carbon::now();
        $category->updated_at   = Carbon::now();
        $category->status       = $input['category_status'];
        $category->slug = Str::slug($input['name']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());
            Storage::putFileAs('public/categories', $file, $name);
            $path = Storage::url('categories/'.$name);
            $category->image_url  = $path;
        }
        $category->save();

        return response([
            'success'=> true,
            'message'=>'Category created successfully.',
            'url' => url('admin/categories')
        ], 201);
    }
    
    public function edit($id)
    {   
        $id       = decrypt($id);
        $category = Category::find($id);
        
        if(!$category){
            return abort(404);
        }

        return view('admin.categories.edit')
        ->with('category',$category);
    }
    public function update(Update $request, $id)
    {
        try{

            $input  = $request->all();
            $id     = decrypt($id);
            $category   = Category::find($id);
            
            $category->name              = $input['name'];
            $category->description       = $input['description'];
            $category->meta_description  = $input['meta_description'];
            $category->meta_tags         = $input['meta_tags'];
            $category->featured          = $input['featured'];
            $category->created_at   = Carbon::now();
            $category->updated_at   = Carbon::now();
            $category->status       = $input['category_status'];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $name = $timestamp . '-' . uniqid() . '-' . str_replace([' ', ':'], '-', $file->getClientOriginalName());
                Storage::putFileAs('public/categories', $file, $name);
                $path = Storage::url('categories/'.$name);
                $category->image_url  = $path;
            }
            
            $category->save();

            return response([
                'success'=> true,
                'message'=>'Categories updated successfully.',
                'url' => url('admin/categories/'.encrypt($id).'/edit')
            ], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function destroy(Delete $request)
    {
        try{
            $input = $request->all();
            $id   = decrypt($input['id']); 

            $category = Category::find($id);

            $check = Product::where('category',$category->name)->exists();
            if($check){
                return response(['message'=>'This category is already related with some products.'], 400);
            }
            $category->delete();       

            return response([
                'success'=> true,
                'message'=>'Categories deleted successfully.',
                'url' => url('admin/categories')
            ], 200);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function destroyImage($id, Request $request) {

        try {

            $category = Category::findOrFail($id);

            if (!empty($category)) {
                File::delete(public_path() .$category->image_url);
                $category->image_url = Null;
                $category->save();

            } else {
                throw new ModelNotFoundException();
            }
            $response = array(
                'status' => 'success',
                'message' => 'Category Image successfully deleted.',
            );

        } catch (Exception $e) {
            $response = array(
                'status' => 'failed',
                'message' => 'Category Image not found.',
            );
        }
        return $response;
    }
}
