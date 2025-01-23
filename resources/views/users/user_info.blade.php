@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
   <h4 class="text-decoration-underline">User Info</h4>
   <a class="btn btn-primary btn-sm my-1" id="add-btn" href="javascript:void(0)"><i class="fa-solid fa-plus"></i> Add</a>
   <table id="user-table" class="table table-striped table-bordered">
      <thead>
         <tr>
            <th>Sl</th>
            <th>User Full Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
         </tr>
      </thead>
   </table>
   <!-- Modal -->
   <div class="modal fade" id="user-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h6 class="modal-title" id="">Add User Info</h6>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="container-fluid">
                  <form id='user-form'>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="user_name" class="form-label">Name</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="user_name" name="user_name">
                           <p id="error_user_name" class="text-danger"></p>
                        </div>
                        <div class="col-md-6">
                           <label for="email" class="form-label">Email Address</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="email" name="email">
                           <p id="error_email" class="text-danger"></p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="password" class="form-label">Password</label><span class="text-danger"> *</span>
                           <input type="password" class="form-control" id="password" name="password">
                           <p id="error_password" class="text-danger"></p>
                        </div>
                        <div class="col-md-6">
                           <label for="password_confirmation" class="form-label">Confirm Password</label><span class="text-danger"> *</span>
                           <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                     </div>
<!--                      <div class="row my-1">
                        <div class="col-md-6">
                           <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                           <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Close</button>
                        </div>
                     </div> -->
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
   var table = $('#user-table').DataTable({
            processing: true,
            language: {
               processing: "Loading data, please wait..."
            },
            serverSide: true,
            ajax: "{{ route('user-list') }}",
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
            { data: 'user_name'},
            { data: 'email'},
            { data: 'status', className: 'text-center'},
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
      $("#user-modal").modal('show');
      $('#user-form')[0].reset();
      $("#error_user_name").text('');
      $("#error_email").text('');
      $("#error_password").text('');
      action_url = 'user-add';
   });

   $("#btn-save").on("click", function(){
      $("#user-form").trigger("submit");
   });

   $("#user-form").on("submit", function(e){
      e.preventDefault(); 
      var formData = $(this).serialize(); 
      $.ajax({
         url: action_url, 
         type: 'post',
         data: formData,
         success: function(response){
            if(response.errors){
               if(response.errors.user_name){
                  $("#error_user_name").text(response.errors.user_name[0]);
               }
               if(response.errors.email){
                  $("#error_email").text(response.errors.email[0]);
               }
               if(response.errors.password){
                  $("#error_password").text(response.errors.password[0]);
               }
            }
            else if(response.success){
               toastr.success(response.success);
               $('#user-modal').modal('hide');
               table.ajax.reload();
            }
            else{
               toastr.error(response.error);
            }
         }
      });
   });

   $('#user-table tbody').on('click', '.edit-btn', function (){ 
      var row = table.row($(this).closest('tr')).data(); 
      $("#user-modal").modal('show');
      $("#user_name").val(row.user_name);
      $("#email").val(row.email);
      $("#error_user_name").text('');
      $("#error_email").text('');
      $("#error_password").text('');
      action_url = 'user-update/'+row.id;
   });

   $('#user-table tbody').on('click', '.delete-btn', function (){ 
      if(confirm("Press a button!")){
         var row = table.row($(this).closest('tr')).data(); 
         $.ajax({
            url: "user-delete/"+row.id,
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