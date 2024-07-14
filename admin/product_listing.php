<?php include 'header.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="main-content">
   <div class="page-content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="page-title-box d-flex align-items-center justify-content-between">
                  <h4 class="mb-0">Manage Product</h4>
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header d-flex justify-content-end align-items-center gap-2">
                     <div class="btn-actions d-flex gap-2 me-1">
                        <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="pageRedirect()">
                            <i class="bx bx-plus-circle label-icon"></i>Add Product
                        </button>
                     </div>
                  </div>

                  <div class="card-body">
                     <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                           <tr>
                              <th>Id</th>
                              <th>Name</th>
                              <th>SKU</th>
                              <th>MRP</th>
                              <th>Special Price</th>
                              <th>Image</th>
                              <th>Description</th>
                              <th>Availability</th>
                              <th>Related Products</th>
                              <th>Status</th>
                              <th>Display Home</th>
                              <th>Added Date</th>
                              <th>Update Date</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                           $listSql = mysqli_query($conn, "SELECT * FROM products ORDER BY product_id DESC");
                           while($listData = mysqli_fetch_assoc($listSql)) {
                           ?>
                           <tr>
                              <td><?php echo $listData['product_id']; ?></td>
                              <td><?php echo $listData['product_name']; ?></td>
                              <td><?php echo $listData['sku']; ?></td>
                              <td><?php echo $listData['mrp_price']; ?></td>
                              <td><?php echo $listData['special_price']; ?></td>
                              <td><img src="../media/product/<?php echo $listData['product_main_image']; ?>" style="height: 50px; width: 50px;"></td>
                              <td><?php echo $listData['product_description']; ?></td>
                              <td><?php echo $listData['product_availble_status']; ?></td>
                              <td><?php echo $listData['related_products_id']; ?></td>
                              <td>
                                 <div class="square-switch">
                                    <?php $checked = $listData["product_status"] == 1 ? 'checked' : ''; ?>
                                    <input type="checkbox" id="product-switch<?php echo $listData['product_id']; ?>" switch="bool" <?php echo $checked; ?> onclick="changeStatus(<?php echo $listData['product_id']; ?>);" />
                                    <label for="product-switch<?php echo $listData['product_id']; ?>" data-on-label="Yes" data-off-label="No"></label>
                                 </div>
                              </td>
                              <td>
                                 <div class="square-switch">
                                    <?php $checked = $listData["isdisplayhome"] == 1 ? 'checked' : ''; ?>
                                    <input type="checkbox" id="displayhome-switch<?php echo $listData['product_id']; ?>" switch="bool" <?php echo $checked; ?> onclick="displayHome(<?php echo $listData['product_id']; ?>);" />
                                    <label for="displayhome-switch<?php echo $listData['product_id']; ?>" data-on-label="Yes" data-off-label="No"></label>
                                 </div>
                              </td>
                              <td><?php echo $listData['added_on']; ?></td>
                              <td><?php echo $listData['updated_on']; ?></td>
                              <td>
                                 <div class="table-btn-actions">
                                    <button type="button" class="btn btn-success">
                                       <a href="edit_product.php?type=edit&id=<?php echo $listData['product_id']; ?>" style="color:white;">
                                       <i class="bx bxs-edit label-icon"></i></a>
                                    </button>
                                    <button type="button" onclick="deleteProduct(<?php echo $listData['product_id']; ?>)" class="btn btn-danger ">
                                       <i class="mdi mdi-trash-can label-icon"></i>
                                    </button>
                                 </div>
                              </td>
                           </tr>
                           <?php 
                           }
                           ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   function pageRedirect() {
       window.location.href = 'add_product.php';
   }

   function displayHome(id) {
       $.ajax({
           url: 'update_product_isdisplay.php',
           type: 'POST',
           data: { id: id },
           success: function(response) {
               var statusRes = JSON.parse(response);
               if(statusRes.status=='true'){
                   alertify.set('notifier','position', 'top-right');
                   alertify.success("Is Display Status Update Successfully.");
               }
               if(statusRes.status=='false'){
                   alertify.set('notifier','position', 'top-right');
                   alertify.error("Something Went Wrong.Please Try Again.");
               }
           },
           error: function(xhr, status, error) {
               alertify.error(error);
           }
       });
   }

   function changeStatus(id) {
       $.ajax({
           url: 'product_status_update.php',
           type: 'POST',
           data: { id: id },
           success: function(response) {
               var statusRes = JSON.parse(response);
               if(statusRes.status=='true'){
                   alertify.set('notifier','position', 'top-right');
                   alertify.success("Status Update Successfully.");
               }
               if(statusRes.status=='false'){
                   alertify.set('notifier','position', 'top-right');
                   alertify.error("Something Went Wrong.Please Try Again.");
               }
           },
           error: function(xhr, status, error) {
               alertify.error(error);
           }
       });
   }

   function deleteProduct(id) {
       Swal.fire({
           title: 'Are you sure?',
           text: "You won't be able to revert this!",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, delete it!',
           cancelButtonText: 'No, cancel!'
       }).then((result) => {
           if (result.isConfirmed) {
               $.ajax({
                   url: 'delete_product.php',
                   type: 'POST',
                   data: { id: id },
                   success: function(response) {
                       var data = JSON.parse(response);
                       if (data.status == 'true') {
                           Swal.fire({
                               title: "Success",
                               text: "Product deleted successfully.",
                               icon: "success",
                               button: "Okay",
                           }).then(function() {
                               window.location = "product_listing.php";
                           });
                       } else {
                           Swal.fire({
                               title: "Error",
                               text: "Failed to delete product. Please try again.",
                               icon: "error",
                               button: "Okay",
                           });
                       }
                   },
                   error: function(xhr, status, error) {
                       Swal.fire({
                           title: "Error",
                           text: "An error occurred while processing your request.",
                           icon: "error",
                           button: "Okay",
                       });
                   }
               });
           }
       });
   }
</script>

<link rel="stylesheet" href="assets/css/tableGrid.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.10/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/responsive/2.2.10/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function () {
      if (!$.fn.DataTable.isDataTable('#example')) {
          $('#example').DataTable({
              "pagingType": "full_numbers",
              "scrollY": "auto",
              "deferRender": true,
              "scroller": true
          });
      }
      $("#example_filter").prependTo(".card-header");
      $("#example_length").prependTo(".card-header");
  });
</script>

<?php include 'footer.php'; ?>
