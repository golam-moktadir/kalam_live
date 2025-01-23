@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
   <h4 class="text-decoration-underline">Product Purchase Info</h4>
   <a class="btn btn-primary btn-sm my-1" href="{{url('product-purchase')}}">Back</a>
   <div class="container-fluid">
      <form id='product-form' method="post" action="{{ url('product-purchase-add') }}">
       @csrf
         <div class="row">
           <div class="col-md-4">            
            <label for="supplier_id" class="form-label">Supplier Name</label><span class="text-danger"> *</span>
            <select class="form-select" name="supplier_id">
               <option value="">-- Select Supplier Name --</option>
               @foreach($suppliers as $supplier)
                  <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</option>
               @endforeach
            </select>
            @error('supplier_id')
            <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="purchase_date" class="form-label">Purchase Date</label><span class="text-danger"> *</span>
            <input type="text" name="purchase_date" id="purchase_date" class="form-control" value="{{old('purchase_date')}}" autocomplete="off">
            @error('purchase_date')
            <p class="text-danger">{{ $message }}</p>
            @enderror            
         </div>
        </div>
<!--          <div class="row my-1">
            <div class="col-md-2">            
               <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#product-modal">Add Product</button>
            </div>
        </div> -->
        <div class="row my-5">
           <div class="col-md-4">
             <input type="submit" class="btn btn-primary btn-sm" value="Save" />
           </div>
         </div>
      </form>
   </div>
   <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Add Product</button>
    <!-- Modal -->
    <div class="modal fade" id="myModal" data-bs-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Modal Title</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               dsdss
            </div>
            <div class="modal-footer">
               <button class="btn btn-danger" data-bs-dismiss='modal'>
                  close
               </button>
            </div>
        </div>
      </div>
    </div>
</main> 
<script>
$("#purchase_date").datepicker({
  autoclose:true,
  todayHighlight:true,
  format:'yyyy-mm-dd'
})
</script>
@endsection