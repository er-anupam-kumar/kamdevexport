@if ($product->status=='1')
<span class="badge rounded-pill badge-soft-success font-size-12 fw-medium">Active</span>
@else
<span class="badge rounded-pill badge-soft-danger font-size-12 fw-medium">Inactive</span>
@endif