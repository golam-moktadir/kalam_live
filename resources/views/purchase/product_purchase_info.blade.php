@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
    <h4 class="text-decoration-underline">Product Purchase Info</h4>
    <a class="btn btn-primary btn-sm my-1" href="{{url('product-purchase-new')}}">Add</a>
    @if (session('success'))
        <p class="text-success">{{ session('success') }} </p>
    @endif
      <div class="table-responsive">
      <table class="table table-sm table-striped table-bordered border-primary table-hover">
         <thead>
             <tr>
                 <th scope="col">#</th>
                 <th scope="col">Purchase No</th>
                 <th scope="col">Whole Sale</th>
                 <th scope="col">Retail</th>
                 <th scope="col">Action</th>
             </tr>
         </thead>
         <tbody>
             @php
                 $index = 1;
             @endphp
             @foreach($purchases as $purchase)
             <tr>
                 <td>{{ $index++ }}</td>
                 <td>{{ $purchase->purchase_no }}</td>
                 <td>{{ $purchase->supplier_name }}</td>
                 <td>{{ $purchase->purchase_date }}</td>
                 <td>
                     <a href="{{url('product-pruchase-edit/'.$purchase->purchase_id) }}" class="btn btn-success btn-sm">Edit</a>
                     <a href="{{url('product-pruchase-delete/'.$purchase->purchase_id) }}" class="btn btn-primary btn-sm">Delete</a>
                 </td>
             </tr>
             @endforeach
         </tbody>
      </table>
      </div>
</main> 
@endsection