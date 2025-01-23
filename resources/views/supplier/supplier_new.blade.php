@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
   <h4 class="text-decoration-underline">Supplier Info</h4>
   <a class="btn btn-primary btn-sm my-1" href="{{url('supplier-info')}}">Back</a>
   <div class="container-fluid">
      <form method="post" action="{{ url('supplier-add') }}">
       @csrf
         <div class="row">
           <div class="col-md-4">            
            <label for="supplier_name" class="form-label">Supplier Name</label><span class="text-danger"> *</span>
            <input type="text" class="form-control" name="supplier_name" value="{{ old('supplier_name') }}">
            @error('supplier_name')
            <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="contact_number" class="form-label">Contact Number</label><span class="text-danger"> *</span>
            <input type="text" class="form-control" name="contact_number" value="{{old('contact_number')}}">
            @error('contact_number')
            <p class="text-danger">{{ $message }}</p>
            @enderror
         </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" name="address" value="{{old('address')}}">
            @error('address')
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