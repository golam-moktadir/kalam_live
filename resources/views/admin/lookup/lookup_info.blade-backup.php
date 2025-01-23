@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
    <h4 class="text-decoration-underline">Look Up Info</h4>
    <a class="btn btn-primary btn-sm my-1" href="{{url('lookup-new')}}">Add</a>
    @if (session('success'))
        <p class="text-success">{{ session('success') }} </p>
    @endif
      <div class="table-responsive">
      <table class="table table-sm table-striped table-bordered border-primary table-hover">
         <thead>
             <tr>
                 <th scope="col">#</th>
                 <th scope="col">Lookup Group</th>
                 <th scope="col">Lookup Label</th>
                 <th scope="col">Value</th>
                 <th scope="col">Order</th>
                 <th scope="col">Action</th>
             </tr>
         </thead>
         <tbody>
             @php
                 $index = 1;
             @endphp
             @foreach($lookups as $lookup)
             <tr>
                 <th scope="row">{{ $index++ }}</th>
                 <td>{{ $lookup->lookup_group }}</td>
                 <td>{{ $lookup->lookup_label }}</td>
                 <td>{{ $lookup->lookup_value }}</td>
                 <td>{{ $lookup->lookup_order }}</td>
                 <td>
                     <a href="{{url('lookup-edit/'.$lookup->lookup_id) }}" class="btn btn-success btn-sm">Edit</a>
                     <a href="{{url('lookup-delete/'.$lookup->lookup_id) }}" class="btn btn-primary btn-sm">Delete</a>
                 </td>
             </tr>
             @endforeach
         </tbody>
      </table>
      </div>
</main> 
@endsection