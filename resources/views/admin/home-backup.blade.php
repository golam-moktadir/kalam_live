@extends('admin.master')

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
    <h4 class="text-decoration-underline">User Info</h4>
    <a class="btn btn-primary btn-sm my-1" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#user-modal">Add</a>
    <div class="table-responsive">
      <table class="table table-sm table-striped table-bordered border-primary table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Modal -->
    <div class="modal fade modal-lg" id="user-modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title" id="">Add User Info</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
               <form id='user-form'>
                @csrf
                  <div class="row">
                    <div class="col-md-6">
                     <label for="user_name" class="form-label">Name</label>
                     <input type="text" class="form-control" id="user_name" name="user_name">
                     <p id="error_user_name"></p>
                   </div>
                   <div class="col-md-6">
                     <label for="email" class="form-label">Email Address</label>
                     <input type="text" class="form-control" id="email" name="email">
                  </div>
                 </div>
                 <div class="row">
                   <div class="col-md-6">
                     <label for="password" class="form-label">Password</label>
                     <input type="password" class="form-control" id="password" name="password">
                   </div>
                   <div class="col-md-6">
                     <label for="password_confirmation" class="form-label">Confirm Password</label>
                     <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                  </div>
                 </div>
                 <div class="row my-1">
                    <div class="col-md-6">
                      <input type="submit" class="btn btn-primary btn-sm" value="Save" />
                    </div>
                  </div>
               </form>
            </div>
          </div>
<!--           <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-sm">Save changes</button>
          </div> -->
        </div>
      </div>
    </div>
</main>
<script type="text/javascript">
  $(document).ready(function() {
      $('#user-form').on('submit', function(e) {
          e.preventDefault(); 
          var formData = $(this).serialize(); 
          $.ajax({
              url: 'user-add', 
              type: 'post',
              data: formData,
              success: function(response){
                if(response.error.user_name){
                  console.log(response.error.user_name);
                }
              }
          });
      });
  });
</script>

@endsection