<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','image_url','status','description','featured','created_at','updated_at'];

    public static function getAdminCategoryModel($limit, $offset, $search, $orderby, $order,$status=null)
    {

        $q = Category::where('id','!=','');

        $orderby  = $orderby ? $orderby : 'created_at';
        $order    = $order ? $order : 'desc';

        
        if($status!=null){   
            $q->where('status',$status);
        }

        if($search && !empty($search))
        {
            $q->where(function($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%')
                ->orWhere('description', 'LIKE', '%'.$search.'%')
                ->orWhere('meta_tags', 'LIKE', '%'.$search.'%')
                ->orWhere('meta_description', 'LIKE', '%'.$search.'%');
            });
        }

        $count = $q->count();

        if ($limit!=-1) {
            $q->limit($limit)->offset($offset);
        }
        $response = $q->orderBy($orderby, $order)->get();
        return ['response' => $response,'count' => $count];
    }
}
