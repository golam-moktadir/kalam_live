@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
   <h4 class="text-decoration-underline">Look Up Info</h4>
   <a class="btn btn-primary btn-sm my-1" id="add-btn" href="javascript:void(0)"><i class="fa-solid fa-plus"></i> Add</a>
   <table id="lookup-table" class="table table-striped table-bordered">
      <thead>
         <tr>
            <th>#</th>
            <th>Lookup Group</th>
            <th>Lookup Label</th>
            <th>Value</th>
            <th>Order</th>
            <th>Action</th>
         </tr>
      </thead>
   </table>
   <!-- Modal -->
   <div class="modal fade" id="lookup-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h6 class="modal-title" id="">Add Look Up Info</h6>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="container-fluid">
                  <form id='lookup-form'>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="lookup_group" class="form-label">Lookup Group</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="lookup_group" name="lookup_group">
                           <p id="error_lookup_group" class="text-danger"></p>
                        </div>
                        <div class="col-md-6">
                           <label for="lookup_label" class="form-label">Lookup Label</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="lookup_label" name="lookup_label">
                           <p id="error_lookup_label" class="text-danger"></p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="lookup_value" class="form-label">Value</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="lookup_value" name="lookup_value">
                           <p id="error_lookup_value" class="text-danger"></p>
                        </div>
                        <div class="col-md-6">
                           <label for="lookup_order" class="form-label">Order</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="lookup_order" name="lookup_order">
                           <p id="error_lookup_order" class="text-danger"></p>
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
   var table = $('#lookup-table').DataTable({
            processing: true,
            language: {
               processing: "Loading data, please wait..."
            },
            serverSide: true,
            ajax: "{{ route('lookup-list') }}",
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
            {data: 'lookup_group'},
            {data: 'lookup_label'},
            {data: 'lookup_value'},
            {data: 'lookup_order', className: 'text-center'},
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
      $("#lookup-modal").modal('show');
      $('#lookup-form')[0].reset();
      $("#error_user_name").text('');
      $("#error_email").text('');
      $("#error_password").text('');
      action_url = 'lookup-add';
   });

   $("#btn-save").on("click", function(){
      $("#lookup-form").trigger("submit");
   });

   $("#lookup-form").on("submit", function(e){
      e.preventDefault(); 
      var formData = $(this).serialize(); 
      $.ajax({
         url: action_url, 
         type: 'post',
         data: formData,
         success: function(response){
            if(response.errors){
               if(response.errors.lookup_group){
                  $("#error_lookup_group").text(response.errors.lookup_group[0]);
               }
               if(response.errors.lookup_label){
                  $("#error_lookup_label").text(response.errors.lookup_label[0]);
               }
               if(response.errors.lookup_value){
                  $("#error_lookup_value").text(response.errors.lookup_value[0]);
               }
               if(response.errors.lookup_order){
                  $("#error_lookup_order").text(response.errors.lookup_order[0]);
               }
            }
            else if(response.success){
               toastr.success(response.success);
               $('#lookup-modal').modal('hide');
               table.ajax.reload();
            }
            else{
               toastr.error(response.error);
            }
         }
      });
   });

   $('#lookup-table tbody').on('click', '.edit-btn', function (){ 
      var row = table.row($(this).closest('tr')).data(); 
      $("#lookup-modal").modal('show');
      $("#lookup_group").val(row.lookup_group);
      $("#lookup_label").val(row.lookup_label);
      $("#lookup_value").val(row.lookup_value);
      $("#lookup_order").val(row.lookup_order);
      $("#error_lookup_group").text('');
      $("#error_lookup_label").text('');
      $("#error_lookup_value").text('');
      $("#error_lookup_order").text('');
      action_url = 'lookup-update/'+row.lookup_id;
   });

   $('#lookup-table tbody').on('click', '.delete-btn', function (){ 
      if(confirm("Press a button!")){
         var row = table.row($(this).closest('tr')).data(); 
         $.ajax({
            url: "lookup-delete/"+row.lookup_id,
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