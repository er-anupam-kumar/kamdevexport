<a href="{{ url('admin/categories/'.encrypt($category->id).'/edit') }}" class="btn btn-outline-secondary btn-sm" title="Edit">
	<i class="fas fa-pencil-alt" title="Edit"></i>
</a>

<a href="javascript:;" class="btn btn-outline-danger btn-sm del" title="Delete" data-id="{{encrypt($category->id)}}" data-url="{{url('/admin/categories/delete')}}">
	<i class="fas fa-trash-alt" title="Delete"></i>
</a>