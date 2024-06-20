<?php include 'header.php'; ?>

<script type="text/javascript">
    function deleteData(second_leval_category_id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data and dependent data also deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery.ajax({
                    url: 'delete_second_leval_category.php',
                    type: 'POST',
                    data: 'second_leval_category_id=' + second_leval_category_id,
                    success: function (result) {
                        var statusRes = JSON.parse(result);
                        if (statusRes.status == 'true') {
                            Swal.fire({
                                title: "Deleted!",
                                text: statusRes.msg,
                                icon: "success"
                            }).then(() => {
                                window.location.href = window.location.href;
                            });
                        }
                        if (statusRes.status == 'false') {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: statusRes.msg
                            });
                        }
                    }
                });
            }
        });
    }
</script>
<div class="main-content">
   <div class="page-content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="page-title-box d-flex align-items-center justify-content-between">
                  <h4 class="mb-0">Manage Categories and Subcategories</h4>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header d-flex justify-content-end align-items-center gap-2">
                    <div class="btn-actions d-flex gap-2 me-1">
                    </div>
                  </div>
                  <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Category Id</th>
                                <th>Category Name</th>
                                <th>Category Status</th>
                                <th>Added Date</th>
                                <th>Update Date</th>
                                <th>Subcategory Id</th>
                                <th>Subcategory Name</th>
                                <th>Subcategory Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $listSql = mysqli_query($conn,"SELECT c.categories_id, c.categories_name, c.categories_status, c.added_on, c.update_on, sc.sub_categories_id, sc.sub_categories_name, sc.status as sub_categories_status 
                                    FROM categories c
                                    LEFT JOIN subcategories sc ON c.categories_id = sc.categories_id
                                    ORDER BY c.categories_id DESC, sc.sub_categories_id DESC");

                                while($listData = mysqli_fetch_assoc($listSql)) {
                                    $categoryId = $listData['categories_id'];
                                    $subCategoryId = $listData['sub_categories_id'];
                            ?>
                            <tr>
                                <td><?php echo $listData['categories_id']; ?></td>
                                <td><?php echo $listData['categories_name']; ?></td>
                                <td><?php echo $listData['categories_status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                                <td><?php echo $listData['added_on']; ?></td>
                                <td><?php echo $listData['update_on']; ?></td>
                                <td><?php echo $listData['sub_categories_id']; ?></td>
                                <td><?php echo $listData['sub_categories_name']; ?></td>
                                <td><?php echo $listData['sub_categories_status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                                <td>
                                    <div class="table-btn-actions">
                                        <button type="button" class="btn btn-success">
                                        <a href="editsubcategories.php?type=edit&id=<?php echo $listData['sub_categories_id']; ?>&categories_id=<?php echo $currentId; ?>" style="color:white;">
                                        <i class="bx bxs-edit label-icon"></i></a>
                                    </button>
                                    <button type="button" onclick="deleteSubCategory(<?php echo $listData['sub_categories_id']; ?>)" class="btn btn-danger ">
                                        <i class="mdi mdi-trash-can label-icon"></i>
                                    </button>
                                        <!-- <?php if(editStatus('second_level_category')) { ?>
                                            <button type="button" class="btn btn-success waves-effect btn-label waves-light">
                                                <a href="edit_second_level_category.php?type=edit&id=<?php echo $subCategoryId; ?>" style="color:white;">
                                                <i class="bx bxs-edit label-icon"></i></a>
                                            </button>
                                        <?php } ?>
                                        <?php if(deleteStatus('second_level_category')) { ?>     
                                           <button type="button" onclick="deleteData(<?php echo $subCategoryId; ?>)" class="btn btn-danger waves-effect btn-label waves-light"><i class="mdi mdi-trash-can label-icon"></i></button>
                                        <?php } ?> -->
                                    </div>
                                </td>   
                            </tr>
                            <?php } ?>
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
        window.location.href = 'add_second_leval_category.php';
    }
</script>

<link rel="stylesheet" href="assets/css/tableGrid.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.10/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/responsive/2.2.10/js/dataTables.responsive.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "pagingType": "full_numbers",
            "scrollY": "auto",
            "deferRender": true,
            "scroller": true
        });
        $("#example_filter").prependTo(".card-header");
        $("#example_length").prependTo(".card-header");
    });

    function changeStatus(id) {
        $.ajax({
            url: 'update_second_leval_category_status.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                var statusRes = JSON.parse(response);
                if(statusRes.status=='true') {
                    alertify.set('notifier','position', 'top-right');
                    alertify.success("Status Update Successfully.");
                }
                if(statusRes.status=='false') {
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

<?php include 'footer.php'; ?>
