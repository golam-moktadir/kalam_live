<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Bootstrap demo</title>
<link href="{{asset('build/assets/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('build/assets/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<!-- <link href="{{asset('build/assets/css/style.css')}}" rel="stylesheet"> -->
<link href="{{asset('build/assets/css/all.min.css')}}" rel="stylesheet">
<link href="{{asset('build/assets/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('build/assets/css/toastr.min.css')}}" rel="stylesheet">
<script src="{{asset('build/assets/js/jquery-3.7.1.js')}}"></script>
<script src="{{asset('build/assets/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('build/assets/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('build/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('build/assets/js/toastr.min.js')}}"></script>
<script src="{{asset('build/assets/js/sweetalert.min.js')}}"></script>
<script type="text/javascript">
   $(document).ready(function(){
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
   });
</script>
<style>
   .own-nav-link {
     color: #fff;
   }

   .own-nav-link:hover {
     color: #ccc; 
   }

   .sidebar {
     padding: 60px 0px; 
     background-color: lightblue;
   }

   .main-content { 
     padding: 60px 10px; 
     background-color: antiquewhite;
   }

   .dataTables_wrapper .dataTables_filter {
      margin-bottom: 10px;
   }
</style>
</head>
<body>
   <div class="container-fluid">
      <form id='product-purchase-form'>
         <div class="row">
            <div class="col-md-4">            
               <label for="supplier_id" class="form-label">Supplier Name</label><span class="text-danger"> *</span>
               <select class="form-select" name="supplier_id" id="supplier_id">
                  <option value="">-- Select Supplier Name --</option>
                  @foreach($suppliers as $supplier)
                  <option value="{{ $supplier->supplier_id }}" {{ $single->supplier_id == $supplier->supplier_id ? 'selected' : ''}}>{{ $supplier->supplier_name }}</option>
                  @endforeach
               </select>
               <p id="error_supplier_name" class="text-danger"></p>
            </div>
            <div class="col-md-4">
               <label for="purchase_date" class="form-label">Purchase Date</label><span class="text-danger"> *</span>
               <input type="text" name="purchase_date" id="purchase_date" class="form-control" autocomplete="off" readonly value="{{ $single->purchase_date }}">
               <p id="error_purchase_date" class="text-danger"></p>           
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <a class="btn btn-primary btn-sm my-1" id="add-btn" href="javascript:void(0)"><i class="fa-solid fa-plus"></i> Add</a>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <table id="item-table" class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th class="text-center">#</th>
                        <th class="d-none">Product Id</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total Price</th>
                        <th class="text-center">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                  @php 
                  $i = 0;
                  $total_qty = 0; 
                  $grand_total_price = 0;
                  @endphp
                  @foreach($single->details as $row)
                     @php 
                     $i++;
                     $total_qty += $row->item_qty;
                     $grand_total_price += $row->total_price;
                     @endphp                        
                     <tr>
                        <td class='text-center'>{{$i}}</td>
                        <td class='d-none'>{{$row->product_id}}</td>
                        <td>{{$row->product->product_name}}</td>
                        <td class="text-center editable item_qty">{{$row->item_qty}}</td>
                        <td class="text-end editable item_price">{{$row->item_price}}</td>
                        <td class="text-end total_price">{{$row->total_price}}</td>
                        <td class='text-center'><a href='javascript:void(0)' class='btn btn-sm btn-danger delete-btn'><i class='fa-solid fa-trash'></i></a></td>
                     </tr>
                     @endforeach
                  </tbody>
                  <tfoot>
                     <tr>
                        <td colspan="2">Total</td>
                        <td id="total_qty" align="center">{{ number_format($total_qty, 2, '.', '') }}</td>
                        <td></td>
                        <td id="grand_total_price" align="right">{{ number_format($grand_total_price, 2, '.', '') }}</td>
                        <td></td>
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
      </form>
      <footer class="bg-light text-end p-3 fixed-bottom">
          <button class="btn btn-primary btn-sm" onclick="saveData();"><i class="fa-solid fa-floppy-disk"></i> Save</button>
          <button class="btn btn-danger btn-sm" onclick="window.close();"><i class="fa-solid fa-xmark"></i> Close</button>
      </footer>
   </div>
   <!-- Modal -->
   <div class="modal fade" id="item-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h6 class="modal-title" id="">Add Product Form</h6>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="container-fluid">
                  <form id='item-form'>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="item_id" class="form-label">Product Name</label><span class="text-danger"> *</span>
                           <select class="form-select" id="item_id" name="item_id">
                              <option value="">-- Select Product --</option>
                              @foreach($products as $product)
                              <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                              @endforeach
                           </select>
                           <p id="error_item_id" class="text-danger"></p>
                        </div>
                        <div class="col-md-6">
                           <label for="item_qty" class="form-label">Quantity</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="item_qty" name="item_qty">
                           <p id="error_item_qty" class="text-danger"></p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="item_price" class="form-label">Price</label><span class="text-danger"> *</span>
                           <input type="text" class="form-control" id="item_price" name="item_price">
                           <p id="error_item_price" class="text-danger"></p>
                        </div>
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
               <button type="button" class="btn btn-primary btn-sm" id="item-btn"><i class="fa-solid fa-plus"></i> Add</button>
               <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Close</button>
            </div>
         </div>
      </div>
   </div>
   <script>
   $("#purchase_date").datepicker({
     autoclose:true,
     todayHighlight:true,
     format:'yyyy-mm-dd'
   });

   $("#add-btn").on('click', function(){
      $("#item-modal").modal('show');
      $('#item-form')[0].reset();
      $("#error_item_id").text('');
      $("#error_item_qty").text('');
      $("#error_item_price").text('');
      $("#error_total_price").text('');
   });

   let item_qty = 0;
   let item_price = 0;
   let total_price = 0;
   let regex = /^[0-9]*\.?[0-9]{0,2}?$/;

   $("#item_qty").on('keyup', function(){
      item_qty = $(this).val();
      if(regex.test(item_qty)){
         total_price = (item_qty * item_price).toFixed(2);
         $("#total_price").val(total_price);
      }
      else{
         $(this).val('');
      }
   });

   $("#item_price").on('keyup', function(){
      item_price = $(this).val();
      if(regex.test(item_price)){
         total_price = (item_qty * item_price).toFixed(2);
         $("#total_price").val(total_price);
      }
      else{
         $(this).val('');
      }
   });

   $("#item-btn").on('click', function(){
      let item_id = $("#item_id").val();
      let item_text = $("#item_id option:selected").text();
      if(item_id && total_price){
         let exist = false;
         $("#item-table tbody tr").each(function () {
            if($(this).find("td:nth-child(2)").text() == item_id) {
               exist = true;
               return false; // Break loop
            }
         });

         if(exist){
            alert('This Item Already exist');
         }
         else{
            let row = "";
            row += "<tr>"
            row += "<td class='text-center'></td>";
            row += "<td class='d-none'>"+item_id+"</td>";
            row += "<td>"+item_text+"</td>";
            row += "<td class='text-center editable item_qty'>"+item_qty+"</td>";
            row += "<td class='text-end editable item_price'>"+item_price+"</td>";
            row += "<td class='text-end total_price'>"+total_price+"</td>";
            row += "<td class='text-center'><a href='javascript:void(0)' class='btn btn-sm btn-danger delete-btn'><i class='fa-solid fa-trash'></i></a></td>";
            row += "</tr>";
            $("#item-table tbody").append(row);
            $('#item-modal').modal('hide');
            updateSerialNumbers();
            updateGrandTotal();
            item_qty = 0;
            item_price = 0;
            total_price = 0;
         }
      }
   });

   function updateSerialNumbers(){
      $("#item-table tbody tr").each(function (index) {
         $(this).find("td:first").text(index + 1);
      });
   }

   $(document).on("click", ".editable", function (){
      // if(!$(this).find("input").length){
         let currentText = $(this).text().trim();
         $(this).html('<input type="text" class="form-control number-input" value="' + currentText + '">');
         $(this).find("input").focus();
      //}
   });

   $(document).on("input", ".number-input", function (){
      let value = $(this).val();
      if(!regex.test(value)){
         $(this).val('');
      }
   });

   $(document).on("blur keypress", ".editable input", function (e){
      if(e.type === "blur" || e.which === 13){ 
         let newValue = $(this).val().trim();
         let parentCell = $(this).parent();
         parentCell.text(newValue);

         if(parentCell.hasClass("item_qty") || parentCell.hasClass("item_price")) {
            let item_qty = parentCell.closest("tr").find(".item_qty").text();
            let item_price = parentCell.closest('tr').find(".item_price").text();
            let total_price = item_qty * item_price;
            parentCell.closest('tr').find(".total_price").text(total_price.toFixed(2));
            updateGrandTotal();
         }
       }
   });

   function updateGrandTotal() {
      let total_qty = 0;
      let grand_total_price = 0;
      $(".item_qty").each(function () {
         total_qty += parseFloat($(this).text());
      });

      $(".total_price").each(function () {
         grand_total_price += parseFloat($(this).text());
      });

      $("#total_qty").text(total_qty.toFixed(0));
      $("#grand_total_price").text(grand_total_price.toFixed(2));
   }

   $('#item-table tbody').on('click', '.delete-btn', function (){ 
      if(confirm("Press a button!")){
         $(this).closest('tr').remove(); 
         updateSerialNumbers();
         updateGrandTotal();
      }
   });

   function saveData(){
      let supplier_id = $("#supplier_id").val();
      let purchase_date = $("#purchase_date").val();
      let item_id = [];
      let item_qty = [];
      let item_price = [];
      let total_price = [];
      $("#item-table tbody tr").each(function(){
         item_id.push($(this).find("td:eq(1)").text());
         item_qty.push($(this).find("td:eq(3)").text());
         item_price.push($(this).find("td:eq(4)").text());
         total_price.push($(this).find("td:eq(5)").text());
      });

      $.ajax({
         url: "/product-purchase-update/"+{{ $single->purchase_id }}, 
         type: 'post',
         data: {supplier_id: supplier_id, purchase_date: purchase_date, item_id: item_id, item_qty: item_qty, item_price: item_price, total_price: total_price},
         success: function(response){
            if(response.errors){
               if(response.errors.supplier_id){
                  $("#error_supplier_name").text(response.errors.supplier_id[0]);
               }
               if(response.errors.purchase_date){
                  $("#error_purchase_date").text(response.errors.purchase_date[0]);
               }
               if(response.errors.item_id){
                  toastr.error(response.errors.item_id[0]);
               }
            }
            else if(response.success){
               toastr.success(response.success);
               setTimeout(function(){
                  window.opener.$('#product-purchase-table').DataTable().ajax.reload();
                  window.close();
               }, 1500);
            }
            else{
               toastr.error(response.error);
            }
         }
      });
   }
   </script>
</body>
</html> 