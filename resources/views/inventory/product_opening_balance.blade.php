@extends('admin.master')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 main-content">
   <h4 class="text-decoration-underline">Product Opening Balance</h4>
   <a class="btn btn-primary btn-sm my-1" id="add-btn" href="javascript:void(0)"><i class="fa-solid fa-plus"></i> Add</a>
   <table id="opening-balance-table" class="table table-striped table-bordered">
      <thead>
         <tr>
            <th class="text-center">#</th>
            <th class="text-center">Opening Date</th>
            <th class="text-center">Product Name</th> 
            <th class="text-center">Opening Qty</th>
            <th class="text-center">Product Price</th>
            <th class="text-center">Total Price</th>
           <th class="text-center">Action</th>
         </tr>
      </thead>
   </table>
   <!-- Modal -->
   <div class="modal fade" id="opening-balance-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h6 class="modal-title" id="">Add Product Opening Balance</h6>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="container-fluid">
                  <form id='opening-balance-form'>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="product_id" class="form-label">Product Name</label><span class="text-danger"> *</span>
                           <select class="form-select" id="product_id" name="product_id">
                              <option value="">-- Select Product --</option>
                              @foreach($products as $product)
                              <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                              @endforeach
                           </select>
                           <p id="error_product_id" class="text-danger"></p>
                        </div>
                        <div class="col-md-6">
                           <label for="opening_date" class="form-label">Opening Date</label><span class="text-danger"> *</span>
                           <input type="text" name="opening_date" id="opening_date" class="form-control" autocomplete="off" readonly>
                           <p id="error_opening_date" class="text-danger"></p> 
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="product_qty" class="form-label">Quantity</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="product_qty" name="product_qty">
                           <p id="error_product_qty" class="text-danger"></p>
                        </div>
                        <div class="col-md-6">
                           <label for="product_price" class="form-label">Price</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="product_price" name="product_price">
                           <p id="error_product_price" class="text-danger"></p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="total_price" class="form-label">Total Price</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="total_price" name="total_price" readonly>
                           <p id="error_total_price" class="text-danger"></p>
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
   $("#opening_date").datepicker({
     autoclose:true,
     todayHighlight:true,
     format:'yyyy-mm-dd'
   });

   var table = $('#opening-balance-table').DataTable({
            processing: true,
            language: {
               processing: "Loading data, please wait..."
            },
            serverSide: true,
            ajax: "{{ route('opening-balance-list') }}",
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
            {data: 'trans_date', className: 'text-center'},
            {data: 'product_name'},
            {data: 'svc_qty', className: 'text-center'},
            {data: 'product_price', className: 'text-end'},
            {data: 'total_price', className: 'text-end'},
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
      $("#opening-balance-modal").modal('show');
      $('#opening-balance-form')[0].reset();
      $("#error_product_id").text('');
      $("#error_product_qty").text('');
      $("#error_product_price").text('');
      $("#error_total_price").text('');
      action_url = 'opening-balance-add';
   });

   let product_qty = 0;
   let product_price = 0;
   let total_price = 0;
   //let regex = /^\d*\.?\d{0,2}$/;
   let regex = /^[0-9]*\.?[0-9]{0,2}?$/;

   $("#product_qty").on('keyup', function(){
      product_qty = parseFloat($(this).val());
      product_price = parseFloat($("#product_price").val());

      if(regex.test(product_qty)){
         total_price = (product_qty * product_price).toFixed(2);
         $("#total_price").val(total_price);
      }
      else{
         $(this).val('');
      }
   });

   $("#product_price").on('keyup', function(){
      product_qty = parseFloat($("#product_qty").val());
      product_price = parseFloat($(this).val());
      if(regex.test(product_price)){
         total_price = (product_qty * product_price).toFixed(2);
         $("#total_price").val(total_price);
      }
      else{
         $(this).val('');
      }
   });

   $("#btn-save").on("click", function(){
      $("#opening-balance-form").trigger("submit");
   });

   $("#opening-balance-form").on("submit", function(e){
      e.preventDefault(); 
      var formData = $(this).serialize(); 
      $.ajax({
         url: action_url, 
         type: 'post',
         data: formData,
         success: function(response){
            if(response.errors){
               if(response.errors.product_id){
                  $("#error_product_id").text(response.errors.product_id[0]);
               }
               if(response.errors.opening_date){
                  $("#error_opening_date").text(response.errors.opening_date[0]);
               }
               if(response.errors.product_qty){
                  $("#error_product_qty").text(response.errors.product_qty[0]);
               }
               if(response.errors.product_price){
                  $("#error_product_price").text(response.errors.product_price[0]);
               }
               if(response.errors.total_price){
                  $("#error_total_price").text(response.errors.total_price[0]);
               }
            }
            else if(response.success){
               toastr.success(response.success);
               $('#opening-balance-modal').modal('hide');
               table.ajax.reload();
            }
            else{
               toastr.error(response.error);
            }
         }
      });
   });

   $('#opening-balance-table tbody').on('click', '.edit-btn', function (){ 
      var row = table.row($(this).closest('tr')).data(); 
      $("#opening-balance-modal").modal('show');
      $('#opening-balance-form')[0].reset();
      $("#product_id").val(row.product_id);
      $("#opening_date").val(row.trans_date);
      $("#product_qty").val(row.svc_qty);
      $("#product_price").val(row.product_price);
      $("#total_price").val(row.total_price);
      $("#error_product_id").text('');
      $("#error_product_qty").text('');
      $("#error_product_price").text('');
      $("#error_total_price").text('');
      action_url = 'opening-balance-update/'+row.trans_id;
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