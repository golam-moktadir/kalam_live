@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
   <h4 class="text-decoration-underline">Look Up Info</h4>
   <a class="btn btn-primary btn-sm my-1" href="{{url('lookup-info')}}">Back</a>
   <div class="container-fluid">
      <form id='lookup-form' method="post" action="{{ url('lookup-update') }}">
       @csrf
         <div class="row">
           <div class="col-md-4">            
            <label for="lookup_group" class="form-label">Lookup Group</label><span class="text-danger"> *</span>
            <input type="hidden" name="lookup_id" value="{{ $lookup->lookup_id }}">
            <input type="text" class="form-control" name="lookup_group" value="{{ $lookup->lookup_group }}">
            @error('lookup_group')
            <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="lookup_label" class="form-label">Lookup Label</label><span class="text-danger"> *</span>
            <input type="text" class="form-control" name="lookup_label" value="{{ $lookup->lookup_label }}">
            @error('lookup_label')
            <p class="text-danger">{{ $message }}</p>
            @enderror
         </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="lookup_value" class="form-label">Value</label><span class="text-danger"> *</span>
            <input type="text" class="form-control" name="lookup_value" value="{{ $lookup->lookup_value }}">
            @error('lookup_value')
            <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="lookup_order" class="form-label">Order</label><span class="text-danger"> *</span>
            <input type="text" class="form-control" name="lookup_order" value="{{ $lookup->lookup_order }}">
            @error('lookup_order')
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