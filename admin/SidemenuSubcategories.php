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
                  <h4 class="mb-0">Manage Sub Categories</h4>
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header d-flex justify-content-end align-items-center gap-2">
                     <div class="btn-actions d-flex gap-2 me-1">
                        <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="pageRedirect()">
                            <i class="bx bx-plus-circle label-icon"></i>Add sub Category
                        </button>
                     </div>
                  </div>

                  <div class="card-body">
                     <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                           <tr>
                              <th style="border-right: 0.3px solid grey;">Id</th>
                              <th style="border-right: 0.3px solid grey;">Name</th>
                              <th style="border-right: 0.3px solid grey;">Images</th>
                              <th style="border-right: 0.3px solid grey;">Categories Name</th>
                              <th style="border-right: 0.3px solid grey;">Added Date</th>
                              <th style="border-right: 0.3px solid grey;">Update Date</th>
                              <th style="border-right: 0.3px solid grey;">Status</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                           $listSql = mysqli_query($conn, "SELECT subcategories.*, categories.categories_name FROM subcategories LEFT JOIN categories ON subcategories.categories_id = categories.categories_id");
                           while($listData = mysqli_fetch_assoc($listSql)) {
                           ?>
                           <tr>
                              <td style="border-right: 0.3px solid black;"><?php echo $listData['sub_categories_id']; ?></td>
                              <td style="border-right: 0.3px solid grey;"><?php echo $listData['sub_categories_name']; ?></td>
                              <td><img src="../media/<?php echo $listData['sub_categories_images']; ?>" style="height: 50px; width: 50px;"></td>
                              <td style="border-right: 0.3px solid grey;"><?php echo $listData['categories_name']; ?></td>
                              <td style="border-right: 0.3px solid grey;"><?php echo $listData['added_on']; ?></td>
                              <td style="border-right: 0.3px solid grey;"><?php echo $listData['update_on']; ?></td>
                              <td style="border-right: 0.3px solid grey;">
                                 <div class="square-switch">
                                    <?php 
                                    $checked = $listData["status"] == 1 ? 'checked' : '';
                                    ?>
                                    <input type="checkbox" id="square-switch<?php echo $listData['sub_categories_id']; ?>" switch="bool" <?php echo $checked; ?> onclick="changeStatus(<?php echo $listData['sub_categories_id']; ?>);" />
                                    <label for="square-switch<?php echo $listData['sub_categories_id']; ?>" data-on-label="Yes" data-off-label="No"></label>
                                 </div>
                              </td>
                              <td>
                                 <div class="table-btn-actions">
                                    <button type="button" class="btn btn-success">
                                        <a href="editsubcategories.php?type=edit&id=<?php echo $listData['sub_categories_id']; ?>&categories_id=<?php echo $listData['categories_id']; ?>" style="color:white;">
                                        <i class="bx bxs-edit label-icon"></i></a>
                                    </button>
                                    <button type="button" onclick="deleteCategory(<?php echo $listData['sub_categories_id']; ?>)" class="btn btn-danger ">
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
       window.location.href = 'add_subcategories_new.php';
   }

   function changeStatus(id) {
       $.ajax({
           url: 'update_sub_category_status.php',
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

 function deleteCategory(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you really want to delete this category? This process cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'subcategories_delete.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status == 'true') {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The category has been successfully deleted.',
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        }).then(function() {
                            window.location = "index.php";
                        });
                    } else {
                        Swal.fire({
                            title: 'Deletion Failed',
                            text: 'There was an issue deleting the category. Please try again later.',
                            icon: 'error',
                            confirmButtonText: 'Okay'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Server Error',
                        text: 'An error occurred while processing your request. Please try again later.',
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    });
                }
            });
        } else {
            Swal.fire({
                title: 'Cancelled',
                text: 'Your category is safe.',
                icon: 'info',
                confirmButtonText: 'Okay'
            });
        }
    });
}


</script>

<!-- DataTables CSS and JS -->
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
