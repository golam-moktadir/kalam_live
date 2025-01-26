@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
   <h4 class="text-decoration-underline">Supplier Info</h4>
   <a class="btn btn-primary btn-sm my-1" id="add-btn" href="javascript:void(0)"><i class="fa-solid fa-plus"></i> Add</a>
   <table id="supplier-table" class="table table-striped table-bordered">
      <thead>
         <tr>
            <th>#</th>
            <th>Supplier Name</th>
            <th>Contact Number</th>
            <th>Address</th>
            <th>Action</th>
         </tr>
      </thead>
   </table>
   <!-- Modal -->
   <div class="modal fade" id="supplier-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h6 class="modal-title" id="">Add Supplier Info</h6>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="container-fluid">
                  <form id='supplier-form'>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="supplier_name" class="form-label">Supplier Name</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="supplier_name" name="supplier_name">
                           <p id="error_supplier_name" class="text-danger"></p>
                        </div>
                        <div class="col-md-6">
                           <label for="contact_number" class="form-label">Contact Number</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="contact_number" name="contact_number">
                           <p id="error_contact_number" class="text-danger"></p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="address" class="form-label">Address</label><span class="text-danger"> </span>
                           <input type="text" class="form-control" id="address" name="address">
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
   var table = $('#supplier-table').DataTable({
            processing: true,
            language: {
               processing: "Loading data, please wait..."
            },
            serverSide: true,
            ajax: "{{ route('supplier-list') }}",
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
            {data: 'supplier_name'},
            {data: 'contact_number'},
            {data: 'address'},
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
      $("#supplier-modal").modal('show');
      $('#supplier-form')[0].reset();
      $("#error_supplier_name").text('');
      $("#error_contact_number").text('');
      action_url = 'supplier-add';
   });

   $("#btn-save").on("click", function(){
      $("#supplier-form").trigger("submit");
   });

   $("#supplier-form").on("submit", function(e){
      e.preventDefault(); 
      var formData = $(this).serialize(); 
      $.ajax({
         url: action_url, 
         type: 'post',
         data: formData,
         success: function(response){
            if(response.errors){
               if(response.errors.supplier_name){
                  $("#error_supplier_name").text(response.errors.supplier_name[0]);
               }
               if(response.errors.contact_number){
                  $("#error_contact_number").text(response.errors.contact_number[0]);
               }
            }
            else if(response.success){
               toastr.success(response.success);
               $('#supplier-modal').modal('hide');
               table.ajax.reload();
            }
            else{
               toastr.error(response.error);
            }
         }
      });
   });

   $('#supplier-table tbody').on('click', '.edit-btn', function (){ 
      var row = table.row($(this).closest('tr')).data(); 
      $("#supplier-modal").modal('show');
      $("#supplier_name").val(row.supplier_name);
      $("#contact_number").val(row.contact_number);
      $("#address").val(row.address);
      $("#error_supplier_name").text('');
      $("#error_contact_number").text('');
      action_url = 'supplier-update/'+row.supplier_id;
   });

   $('#supplier-table tbody').on('click', '.delete-btn', function (){ 
      if(confirm("Press a button!")){
         var row = table.row($(this).closest('tr')).data(); 
         $.ajax({
            url: "supplier-delete/"+row.supplier_id,
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