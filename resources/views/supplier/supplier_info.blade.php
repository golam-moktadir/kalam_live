@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
    <h4 class="text-decoration-underline">Supplier Info</h4>
    <a class="btn btn-primary btn-sm my-1" href="{{url('supplier-new')}}">Add</a>
    @if (session('success'))
        <p class="text-success">{{ session('success') }} </p>
    @endif
      <div class="table-responsive">
      <table class="table table-sm table-striped table-bordered border-primary table-hover">
         <thead>
             <tr>
                 <th scope="col">#</th>
                 <th scope="col">Supplier Name</th>
                 <th scope="col">Contact Number</th>
                 <th scope="col">Address</th>
                 <th scope="col">Action</th>
             </tr>
         </thead>
         <tbody>
             @php
                 $index = 1;
             @endphp
             @foreach($suppliers as $supplier)
             <tr>
                 <td>{{ $index++ }}</td>
                 <td>{{ $supplier->supplier_name }}</td>
                 <td>{{ $supplier->contact_number }}</td>
                 <td>{{ $supplier->address }}</td>
                 <td>
                    <a href="{{url('supplier-edit/'.$supplier->supplier_id) }}" class="btn btn-success btn-sm">Edit</a>
                    <a href="{{url('supplier-delete/'.$supplier->supplier_id) }}" class="btn btn-primary btn-sm">Delete</a>
                 </td>
             </tr>
             @endforeach
         </tbody>
      </table>
      </div>
</main> 
@endsection