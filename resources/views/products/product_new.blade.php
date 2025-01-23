@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
   <h4 class="text-decoration-underline">Product Info</h4>
   <a class="btn btn-primary btn-sm my-1" href="{{url('product-info')}}">Back</a>
   <div class="container-fluid">
      <form id='product-form' method="post" action="{{ url('product-add') }}">
       @csrf
         <div class="row">
           <div class="col-md-4">            
            <label for="product_name" class="form-label">Product Name</label><span class="text-danger"> *</span>
            <input type="text" class="form-control" name="product_name" value="{{ old('product_name') }}">
            @error('product_name')
            <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="whole_sale" class="form-label">Whole Sale</label><span class="text-danger"> *</span>
            <input type="text" class="form-control" name="whole_sale" value="{{old('whole_sale')}}">
            @error('whole_sale')
            <p class="text-danger">{{ $message }}</p>
            @enderror
         </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="retail" class="form-label">Retail</label><span class="text-danger"> *</span>
            <input type="text" class="form-control" name="retail" value="{{old('retail')}}">
            @error('retail')
            <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="row my-1">
           <div class="col-md-4">
             <input type="submit" class="btn btn-primary btn-sm" value="Save" />
           </div>
         </div>
      </form>
   </div>
</main> 
@endsection