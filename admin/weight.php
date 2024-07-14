<?php include 'header.php'; ?>
<script type="text/javascript">
	function deleteData(weight_master_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            jQuery.ajax({
                url: 'delete_weight_master.php',
                type: 'POST',
                data: 'weight_master_id=' + weight_master_id,
                success: function (result) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your data has been deleted.",
                        icon: "success"
                    }).then(() => {
                        // Reload the page after successful deletion
                        window.location.href = window.location.href;
                    });
                }
            });
        }
    });
}
</script>
<div class="main-content">
   <div class="page-content">
      <div class="container-fluid">
         <!-- start page title -->
         <div class="row">
            <div class="col-12">
               <div class="page-title-box d-flex align-items-center justify-content-between">
                  <h4 class="mb-0">Manage Weight Master</h4>
               </div>
            </div>
         </div>
         <!-- end page title -->
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                <div class="card-header d-flex justify-content-end align-items-center gap-2">
                    <div class="btn-actions d-flex gap-2 me-1">
                        <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="pageRedirect()">
                            <i class="bx bx-plus-circle label-icon"></i>Add Weight Master
                        </button>
                    </div>
                  </div>
                  <!-- end card header -->
                  <div class="card-body">
                  	<table id="example" class="table table-striped" style="width:100%">
					        <thead>
					            <tr>
					                <th style="border-right: 0.3px solid grey;">Id</th>
					                <th style="border-right: 0.3px solid grey;">Weight</th>
					                <th style="border-right: 0.3px solid grey;">Added Date</th>
					                <th style="border-right: 0.3px solid grey;">Update Date</th>
					                <th style="border-right: 0.3px solid grey;">Status</th>
                                    <th>Action</th>	
					            </tr>
					        </thead>
					        <tbody>
					        	<?php 
					        		$listSql = mysqli_query($conn,"SELECT * FROM weight_master ORDER BY weight_master.weight_master_id DESC");
					        		while($listData = mysqli_fetch_assoc($listSql)){
					        	?>
					            <tr>
					               <td style="border-right: 0.3px solid black;"><?php echo $listData['weight_master_id']; ?></td>
                                   <td style="border-right: 0.3px solid black;"><?php echo $listData['weight']; ?></td>
					               <td style="border-right: 0.3px solid grey;"><?php echo $listData['added_on']; ?></td>
					               <td style="border-right: 0.3px solid grey;"><?php echo $listData['updated_on']; ?></td>
					               <td style="border-right: 0.3px solid grey;">
					                	<div class="square-switch">
					                		<?php 
					                			if ($listData["weight_status"] == 1) {
					                				$checked = 'checked';
					                			}else{
					                				$checked = '';
					                			}
					                		?>
                                    <input type="checkbox" id="square-switch<?php echo $listData['weight_master_id']; ?>" switch="bool" <?php  echo $checked; ?> onclick="changeStatus(<?php echo $listData['weight_master_id']; ?>);"/>
                                    <label for="square-switch<?php echo $listData['weight_master_id']; ?>" data-on-label="Yes" data-off-label="No"></label>
                                 </div>
                              </td>
                              <td>
                                <div class="table-btn-actions">       
                                    <button type="button" class="btn btn-success waves-effect btn-label waves-light">
                                    <a href="edit_weight.php?type=edit&&id=<?php echo $listData['weight_master_id']; ?>" style="color:white;">
                                    <i class="bx bxs-edit label-icon"></i></a></button>
                                    <button type="button" onclick="deleteData(<?php echo $listData['weight_master_id']; ?>)" class="btn btn-danger waves-effect btn-label waves-light"><i class="mdi mdi-trash-can label-icon"></i></button>
                                </div>
                                </td>
                                  
					            </tr>
					            <?php 
					            	}
					            ?>
					        </tbody>					        
					    </table>
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
            </div>
            <!-- end col -->
         </div>
         <!-- end row -->
      </div>
      <!-- container-fluid -->
   </div>
   <!-- End Page-content -->
  
</div>

<script>
    function pageRedirect() {
        window.location.href = 'add_weight.php';
    }
</script>

<!-- DataTables CSS file -->
<link rel="stylesheet" href="assets/css/tableGrid.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.10/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/responsive/2.2.10/js/dataTables.responsive.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#table-static').DataTable({
            "pagingType": "full_numbers",
            "scrollY": "auto", // Set your desired height
            "deferRender": true,
            "scroller": true // Add any DataTables options as needed
        });
        $("#example_filter").prependTo(".card-header");
        $("#example_length").prependTo(".card-header");
    });

    function changeStatus(id) {
    // Assuming you are using jQuery for simplicity
    $.ajax({
        url: 'update_weight_status.php', // Change this to the actual PHP file handling the update
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
</script>
<!-- end main content-->
<?php include 'footer.php'; ?>