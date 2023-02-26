<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','category','short_description','description','meta_tags','meta_description','featured','status','created_at','updated_at'];

    public static function getAdminProductModel($limit, $offset, $search, $orderby, $order,$status=null,$from_date=null,$to_date=null)
    {

        $q = Product::where('id','!=','');

        $orderby  = $orderby ? $orderby : 'created_at';
        $order    = $order ? $order : 'desc';

        
        if($status!=null){   
            $q->where('status',$status);
        }

        if($from_date!=null && $to_date==null){
            $q->whereDate('products.created_at','>=',$from_date);
        }

        if($to_date!=null && $from_date==null){   
            $q->whereDate('products.created_at','<=',$to_date);
        }

        if($to_date!=null && $from_date!=null){ 
            if($to_date!=$from_date){  
                $q->whereBetween('products.created_at',[$from_date,$to_date]);
            }else{
                $q->whereDate('products.created_at',$from_date);
            }
        }

        if($search && !empty($search))
        {
            $q->where(function($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%')
                ->orWhere('description', 'LIKE', '%'.$search.'%')
                ->orWhere('meta_tags', 'LIKE', '%'.$search.'%')
                ->orWhere('short_description', 'LIKE', '%'.$search.'%');                
            });
        }

        $count = $q->count();

        if ($limit!=-1) {
            $q->limit($limit)->offset($offset);
        }
        $response = $q->orderBy($orderby, $order)->get();
        return ['response' => $response,'count' => $count];
    }

    public function getCategory()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImages()
    {
        return $this->hasMany(ProductImage::Class,'product_id','id');
    }

    public function getSingleImage()
    {
        return $this->belongsTo(ProductImage::Class,'id','product_id');
    }

    public function getVariations()
    {
        return $this->hasMany(ProductVariation::Class,'product_id','id');
    }

    public function getSingleVariant()
    {
        return $this->belongsTo(ProductVariation::Class,'id','product_id');
    }

}
