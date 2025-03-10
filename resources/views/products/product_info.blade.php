@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
   <h4 class="text-decoration-underline">Product Info</h4>
   <a class="btn btn-primary btn-sm my-1" id="add-btn" href="javascript:void(0)"><i class="fa-solid fa-plus"></i> Add</a>
   <table id="product-table" class="table table-striped table-bordered">
      <thead>
         <tr>
            <th class="text-center">#</th>
            <th class="text-center">Product Name</th>
            <th class="text-center">Whole Sale</th>
            <th class="text-center">Retail</th>
            <th class="text-center">Action</th>
         </tr>
      </thead>
   </table>
   <!-- Modal -->
   <div class="modal fade" id="product-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h6 class="modal-title" id="">Add Product Info</h6>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="container-fluid">
                  <form id='product-form'>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="product_name" class="form-label">Product Name</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="product_name" name="product_name">
                           <p id="error_product_name" class="text-danger"></p>
                        </div>
                        <div class="col-md-6">
                           <label for="whole_sale" class="form-label">Whole Sale</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="whole_sale" name="whole_sale">
                           <p id="error_lookup_label" class="text-danger"></p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="retail" class="form-label">Retail</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="retail" name="retail">
                           <p id="error_lookup_value" class="text-danger"></p>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary btn-sm" id="btn-save"><i class="fa-solid fa-floppy-disk"></i> Save</button>
               <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Close</button>
            </div>
         </div>
      </div>
   </div>
</main> 
<script type="text/javascript">
$(document).ready(function() {
   var table = $('#product-table').DataTable({
            processing: true,
            language: {
               processing: "Loading data, please wait..."
            },
            serverSide: true,
            ajax: "{{ route('product-list') }}",
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
            {data: 'product_name'},
            {data: 'whole_sale', className: 'text-end'},
            {data: 'retail', className: 'text-end'},
            {
               data: null,
               orderable: false,
               searchable: false,
               className: 'text-center',
               render: function(data, type, row){
               let action_links = "";
               action_links += " <a href='javascript:void(0)' class='btn btn-sm btn-success edit-btn'><i class='fa-solid fa-pen-to-square'></i></a>";

               action_links += " <a href='javascript:void(0)' class='btn btn-sm btn-danger delete-btn'><i class='fa-solid fa-trash'></i></a>";
               return action_links;
            }
         }
      ]
   });

   let action_url = null;
   $("#add-btn").on('click', function(){
      $("#product-modal").modal('show');
      $('#product-form')[0].reset();
      $("#error_product_name").text('');
      $("#error_whole_sale").text('');
      $("#error_retail").text('');
      action_url = 'product-add';
   });

   $("#btn-save").on("click", function(){
      $("#product-form").trigger("submit");
   });

   $("#product-form").on("submit", function(e){
      e.preventDefault(); 
      var formData = $(this).serialize(); 
      $.ajax({
         url: action_url, 
         type: 'post',
         data: formData,
         success: function(response){
            if(response.errors){
               if(response.errors.product_name){
                  $("#error_product_name").text(response.errors.product_name[0]);
               }
               if(response.errors.whole_sale){
                  $("#error_whole_sale").text(response.errors.whole_sale[0]);
               }
               if(response.errors.retail){
                  $("#error_retail").text(response.errors.retail[0]);
               }
            }
            else if(response.success){
               toastr.success(response.success);
               $('#product-modal').modal('hide');
               table.ajax.reload();
            }
            else{
               toastr.error(response.error);
            }
         }
      });
   });

   $('#product-table tbody').on('click', '.edit-btn', function (){ 
      var row = table.row($(this).closest('tr')).data(); 
      $("#product-modal").modal('show');
      $("#product_name").val(row.product_name);
      $("#whole_sale").val(row.whole_sale);
      $("#retail").val(row.retail);
      $("#error_product_name").text('');
      $("#error_whole_sale").text('');
      $("#error_retail").text('');
      action_url = 'product-update/'+row.product_id;
   });

   $('#product-table tbody').on('click', '.delete-btn', function (){ 
      if(confirm("Press a button!")){
         var row = table.row($(this).closest('tr')).data(); 
         $.ajax({
            url: "product-delete/"+row.product_id,
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