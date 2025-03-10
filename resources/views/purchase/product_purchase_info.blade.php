@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
   <h4 class="text-decoration-underline">Product Purchase Info</h4>
   <a class="btn btn-primary btn-sm my-1" id="add-btn" href="javascript:void(0)"><i class="fa-solid fa-plus"></i> Add</a>
   <table id="product-purchase-table" class="table table-striped table-bordered">
      <thead>
         <tr>
            <th class="text-center">#</th>
            <th class="text-center">Purchase No.</th>
            <th class="text-center">Purchase Date</th>
            <th class="text-center">Supplier Name</th>
            <th class="text-center">Action</th>
         </tr>
      </thead>
   </table>
</main> 
<script type="text/javascript">
$(document).ready(function() {
   var table = $('#product-purchase-table').DataTable({
            processing: true,
            language: {
               processing: "Loading data, please wait..."
            },
            serverSide: true,
            ajax: "{{ route('product-purchase-list') }}",
            columns: [
               {
                  data: null,
                  orderable: false,
                  searchable: false,
                  className: 'text-center',
                  render: function(data, type, row, meta){
                     return meta.row+1;
                  }
               },
              { data: 'purchase_no'},
              { data: 'purchase_date', className:'text-center'},
              { data: 'supplier_name'},
            {
               data: null,
               orderable: false,
               searchable: false,
               render: function(data, type, row){
               let action_links = "";
               action_links += " <a href='javascript:void(0)' class='btn btn-sm btn-success edit-btn'><i class='fa-solid fa-pen-to-square'></i></a>";

               action_links += " <a href='javascript:void(0)' class='btn btn-sm btn-danger delete-btn'><i class='fa-solid fa-trash'></i></button>";
               return action_links;
            }
         }
      ]
   });

   let action_url = null;
   $("#add-btn").on('click', function(){
      window.open('product-purchase-new', 'New Product Purchase Form', 'left=300,width=800,height=600,scrollbars=yes');
   });

   $('#product-purchase-table tbody').on('click', '.edit-btn', function (){ 
      var row = table.row($(this).closest('tr')).data(); 
      window.open('product-purchase-edit/'+row.purchase_id, 'Edit Product Purchase Form', 'left=300,width=800,height=600,scrollbars=yes');
   });

   $('#product-purchase-table tbody').on('click', '.delete-btn', function (){ 
      if(confirm("Press a button!")){
         var row = table.row($(this).closest('tr')).data(); 
         $.ajax({
            url: "product-purchase-delete/"+row.purchase_id,
            success:function(response){
               if(response.success){
                  toastr.success(response.success);
                  table.ajax.reload();
               }
               else{
                  toastr.error(response.error);
               } 
            }
         });
      }
   });
});
</script>
@endsection