<?php include "header.php"; ?>

<!-- Submit Action  -->
<?php 
    if(isset($_POST['submit'])){
        $weight = mysqli_real_escape_string($conn,$_POST['weight']);
        $added_on = date('y-m-d h:i:s');
        $updated_on = date('y-m-d h:i:s');

        $checkSql = mysqli_query($conn,"SELECT * FROM weight_master WHERE weight = '$weight'");
        if(mysqli_num_rows($checkSql)>0){
        ?>  
        <script type="text/javascript">
            swal({
                title: "Warning",
                text: "Data Already Exist.",
                icon: "error",
                button: "Okay",
            });
        </script>
        <?php
        }else{
            $insertSql = mysqli_query($conn,"INSERT INTO `weight_master`(`weight`, `weight_status`, `added_on`, `updated_on`) VALUES ('$weight','1','$added_on','$updated_on')");
            if($insertSql){ ?>
                <script type="text/javascript">
                    swal({
                        title: "Success",
                        text: "Data Added Successfully.",
                        icon: "success",
                        button: "Okay", 
                    }).then(function() {
                       window.location = "weight.php";
                    });
                </script>
            <?php }else{ ?>
                <script type="text/javascript">
                    swal({
                        title: "Warning",
                        text: "Somthing Went Wrong.",
                        icon: "error",
                        button: "Okay",
                    });
                </script>
        <?php }
        }
    }
?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Product</h4>
                            <h6 style="color:red;">You can add simple and configurable product using configure option dropdown</h6>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="mb-3">
                                                <label class="form-label" for="validationCustom03">Is Configure Product (Product Type)</label>
                                                <select class="form-control is_configure_product" name="is_configure_product"
                                                id="choices-single-default"
                                                placeholder="Is Configure Product" onchange="isConfigureProduct();" required>
                                                <option value="">Is Configure Product</option>
                                                <option value="1">Yes</option>
                                                <option value="0" selected>No</option>    
                                                </select>
                                            <span class="is_configure_product_error" style="color:red;"></span>
                                        </div>

                                        <div class="mb-3">
                                                <label class="form-label" for="validationCustom03">Select Main Category</label>
                                                <select class="form-control main_category_id" data-trigger name="main_category_id"
                                                id="choices-single-default"
                                                placeholder="Select Main Category" onchange="get_sub_cat();"  required>
                                                <option value="">Select Main Category</option>
                                                <?php 
                                                
                                                    $getCategory = mysqli_query($conn, "SELECT * FROM categories WHERE categories_status = 1");

                                                        if (mysqli_num_rows($getCategory) > 0) {
                                                            while ($getCategoryData = mysqli_fetch_assoc($getCategory)) {
                                                ?> 
                                                        <option value="<?php echo $getCategoryData['categories_id']; ?>"><?php echo $getCategoryData['categories_name'];?></option>
                                                                
                                                <?php
                                                        }
                                                    }
                                                ?>
                                                </select>
                                            <span class="main_category_id_error" style="color:red;"></span>
                                        </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="validationCustom03">Select Sub Category</label>
                                                <select class="form-control sub_category_id" name="sub_category_id"
                                                    id="choices-single-default"
                                                    placeholder="Select Sub Category" required>
                                                    <option value="">Select Sub Category</option>

                                                </select>
                                                <span class="sub_category_id_error" style="color:red;">
                                                </span>
                                            </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Product Name</label>
                                            <input type="text" class="form-control product_name" id="validationCustom03" placeholder="Enter Product Name" name="product_name" required>
                                            <span class="product_name_error" style="color:red;"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Product SKU</label>
                                            <input type="text" class="form-control sku" id="validationCustom03" placeholder="Enter Product SKU" name="sku" required>
                                            <span class="sku_error" style="color:red;"></span>
                                        </div>

                                        <div id="product_weight_box" class="row is_configure_product_div" style="display:none;">
                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label class="form-label" for="validationCustom03">Select Weight</label>
                                                    <select class="form-control" name="weight_values[]"
                                                    placeholder="Select Weight" id="weight_values_1"  required>
                                                    <option value="">Select Weight</option>
                                                    <?php 
                                                        $getWeight = mysqli_query($conn, "SELECT * FROM weight_master WHERE weight_status = 1");

                                                            if (mysqli_num_rows($getWeight) > 0) {
                                                                while ($getWeightData = mysqli_fetch_assoc($getWeight)) {
                                                    ?> 
                                                            <option value="<?php echo $getWeightData['weight']; ?>"><?php echo $getWeightData['weight'];?></option>
                                                                    
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                    <span class="weight_values_error" style="color:red;"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="mb-3"> <label class="form-label" for="validationCustom03">MRP Price</label> 
                                                <input type="text" class="form-control" id="validationCustom03" placeholder="Enter MRP Price" name="configure_mrp_price[]" required="">
                                                <span class="configure_mrp_price_error" style="color:red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3"> <label class="form-label" for="validationCustom03">Special Price</label> 
                                                <input type="text" class="form-control" id="validationCustom03" placeholder="Enter Special Price" name="configure_special_price[]" required=""> 
                                                <span class="configure_special_price_error" style="color:red;"></span> 
                                              </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3"> <label class="form-label" for="validationCustom03">Qty</label> 
                                                <input type="text" class="form-control" id="validationCustom03" placeholder="Enter Qty" name="configure_qty[]" required=""> 
                                                <span class="configure_qty_error" style="color:red;"></span> 
                                              </div>
                                            </div>


                                            <div class="col-md-3" style="margin-top:7px;">
                                                  <label class="form-label" for="validationCustom03"></label>
                                                <div class="mb-3">
                                                    <button class="form-control btn btn-success waves-effect btn-label waves-light" id="validationCustom03" name="button" type="button" onclick="addMoreWeight();"><i class="bx bx-plus-circle label-icon"></i>Add More</button>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="mb-3" id="mrp_price_div">
                                            <label class="form-label" for="validationCustom03">MRP Price</label>
                                            <input type="text" class="form-control mrp_price" id="validationCustom03" placeholder="Enter MRP Price" name="mrp_price" required>
                                            <span class="mrp_price_error" style="color:red;"></span>
                                        </div>

                                        <div class="mb-3" id="special_price_div">
                                            <label class="form-label" for="validationCustom03">Special Price</label>
                                            <input type="text" class="form-control special_price" id="validationCustom03" placeholder="Enter Special Price" name="special_price" required>
                                            <span class="special_price_error" style="color:red;"></span>
                                        </div>

                                        <div class="mb-3" id="qty_div">
                                            <label class="form-label" for="validationCustom03">Qty</label>
                                            <input type="text" class="form-control qty" id="validationCustom03" placeholder="Enter Qty" name="qty" required>
                                            <span class="qty_error" style="color:red;"></span>
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Product Image</label>
                                            <input type="file" class="form-control product_main_image" id="product_main_image" placeholder="Enter Product Image" name="product_main_image" required>
                                            <span class="product_main_image_error" style="color:red;"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Product Multiple Image</label>
                                           <button type="button" class="form-control btn btn-success waves-effect btn-label waves-light" onclick="addMoreProductImage();"><i class="bx bx-plus-circle label-icon"></i>Add Images</button>
                                        </div>

                                        <div id="product_images_add_div" class="mb-3">
                                             
                                        </div>


                                        <div class="mb-3">
                                                <label class="form-label" for="validationCustom03">Product Available Status</label>
                                                <select class="form-control product_available_status" data-trigger name="is_configure_product"
                                                id="choices-single-default"
                                                placeholder="Product Available Status"  required>
                                                <option value="">Select Product Available Status</option>
                                                <option value="in_stock">In Stock</option>
                                                <option value="out_of_stock">Out Of Stock</option>    
                                                </select>
                                            <span class="product_available_status_error" style="color:red;"></span>
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Related Product Id</label>
                                            <input type="text" class="form-control related_product_ids" id="validationCustom03" placeholder="Enter Related Product Id (Like : 20, 30, 40)" name="related_product_ids" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Is Home Display?</label>
                                            <input type="checkbox" class="form-check-input form-control is_home_display" id="customSwitchsizelg">
                                        </div>
                                        

                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Product Description</label>
                                            <textarea name="editor1" class="form-control product_description" id="editor1"></textarea>
                                            <span class="editor1_error" style="color:red;"></span>
                                        </div>



                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Meta Title</label>
                                            <input type="text" class="form-control meta_title" id="validationCustom03" placeholder="Enter Meta Title" name="meta_title" required>
                                            <span class="meta_title_error" style="color:red;"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Meta Keyword</label>
                                            <input type="text" class="form-control meta_keyword" id="validationCustom03" placeholder="Enter Meta Keyword" name="meta_keyword" required>
                                            <span class="meta_keyword_error" style="color:red;"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom03">Meta Description</label>
                                            <textarea name="meta_description" class="form-control meta_description" id="meta_description"></textarea>
                                            <span class="meta_description_error" style="color:red;"></span>
                                        </div>

                                    </div>
                                </div>
                                <button class="btn btn-primary">
                                <a href="product_listing.php" style="color:white;">Back</a>
                                </button>
                                <button class="btn btn-success" onclick="productSubmit();" name="button" type="button">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>
<script>
   var editor1 = CKEDITOR.replace( 'editor1' );
   CKFinder.setupCKEditor( editor1 );
</script>  


<script type="text/javascript">
    // Get Category to sub category
    function get_sub_cat(){
        var main_category_id = jQuery('.main_category_id').val();
        if(main_category_id){
            jQuery('.loader-container').show();
            jQuery.ajax({
                url : 'get_sub_category_drop.php',
                type : 'POST',
                data : 'main_category_id='+main_category_id,
                success: function(result){
                    jQuery('.loader-container').hide();
                    jQuery('.sub_category_id').html(result);    
                }
            });   
        }   
    }


    function isConfigureProduct(){
        var is_configure_product = jQuery('.is_configure_product').val();
        if(is_configure_product){
            if(is_configure_product==1){
                jQuery('.is_configure_product_div').show();
                jQuery('#mrp_price_div').hide();
                jQuery('#special_price_div').hide();
                jQuery('#qty_div').hide();
            }else{
                jQuery('.is_configure_product_div').hide();
                jQuery('#mrp_price_div').show();
                jQuery('#special_price_div').show();
                jQuery('#qty_div').show();
            }
        }
    }

    var totalProductImage = 0;
    function addMoreProductImage(){
        totalProductImage++;

        var addProductImagesHtml = '<div class="row" id = "add_product_image_box_'+totalProductImage+'" style="margin-top: 10px;"> <div class="col-md-6"> <input type="file" class="form-control" name="product_multiple_image[]" id = "product_image_'+totalProductImage+'"> </div> <div class="col-md-6"> <button type="button" class="form-control btn btn-danger waves-effect btn-label waves-light" onclick="removeProductImage('+totalProductImage+')"><i class="bx bx-minus-circle label-icon"></i>Remove Image</button> </div> </div>';

        jQuery('#product_images_add_div').append(addProductImagesHtml);
    }

    function removeProductImage(id){
       jQuery('#add_product_image_box_'+id).remove();
    }


    var totalWeight = 1;
    function addMoreWeight(){
        totalWeight++;

        var weightHtmlValues = jQuery('#product_weight_box #weight_values_1').html();

        var addTotalWeightHtml = '<div class="row" id="weight_box_div_'+totalWeight+'"> <div class="col-md-3"> <div class="mb-2"> <label class="form-label" for="validationCustom03">Select Weight</label> <select class="form-control" name="weight_values[]" placeholder="Select Weight" required="">'+weightHtmlValues+'</select> <span class="weight_values_error" style="color:red;"></span> </div> </div> <div class="col-md-2"> <div class="mb-3"> <label class="form-label" for="validationCustom03">MRP Price</label> <input type="text" class="form-control" id="validationCustom03" placeholder="Enter MRP Price" name="configure_mrp_price[]" required=""> <span class="configure_mrp_price_error" style="color:red;"></span> </div> </div> <div class="col-md-2"> <div class="mb-3"> <label class="form-label" for="validationCustom03">Special Price</label> <input type="text" class="form-control" id="validationCustom03" placeholder="Enter Special Price" name="configure_special_price[]" required=""> <span class="configure_special_price_error" style="color:red;"></span> </div> </div> <div class="col-md-2"> <div class="mb-3"> <label class="form-label" for="validationCustom03">Qty</label> <input type="text" class="form-control" id="validationCustom03" placeholder="Enter Qty" name="configure_qty[]" required=""> <span class="configure_qty_error" style="color:red;"></span> </div> </div> <div class="col-md-3" style="margin-top:7px;"> <label class="form-label" for="validationCustom03"></label> <div class="mb-3"> <button style="margin-left: 18px;" class="form-control btn btn-danger waves-effect btn-label waves-light" id="validationCustom03" name="button" type="button" onclick="removeWeight('+totalWeight+');"><i class="bx bx-minus-circle label-icon"></i>Remove</button> </div> </div> </div>';

        jQuery('#product_weight_box').append(addTotalWeightHtml);
    }

    function removeWeight(id){
       jQuery('#weight_box_div_'+id).remove();
    }


    function productSubmit(){
        var main_category_id = jQuery('.main_category_id').val();
        var sub_category_id = jQuery('.sub_category_id').val();
        var product_name = jQuery('.product_name').val();
        var sku = jQuery('.sku').val();
        var is_configure_product = jQuery('.is_configure_product').val();
        var mrp_price = jQuery('.mrp_price').val();
        var special_price = jQuery('.special_price').val();
        var qty = jQuery('.qty').val();
        var product_available_status = jQuery('.product_available_status').val();
        var related_product_ids = jQuery('.related_product_ids').val();
        var is_home_display = jQuery('.is_home_display').is(':checked') ? 1 : 0;
        var meta_title = jQuery('.meta_title').val();
        var meta_keyword = jQuery('.meta_keyword').val();
        var meta_description = jQuery('.meta_description').val();
        var editor1 = CKEDITOR.instances.editor1.getData();
        var product_main_image = jQuery('#product_main_image')[0].files.length;

        var isValid = true;

        if(main_category_id == ''){
            jQuery('.main_category_id_error').html('Please Select Main Category');
            jQuery('.main_category_id').css({'border-color': '#fa6374'});
            isValid = false;
        } else {
            jQuery('.main_category_id_error').html('');
            jQuery('.main_category_id').css({'border-color': ''});
        }

        if(sub_category_id == ''){
            jQuery('.sub_category_id_error').html('Please Select Sub Category');
            jQuery('.sub_category_id').css({'border-color': '#fa6374'});
            isValid = false;
        } else {
            jQuery('.sub_category_id_error').html('');
            jQuery('.sub_category_id').css({'border-color': ''});
        }

        if(product_name == ''){
            jQuery('.product_name_error').html('Please Enter Product Name');
            jQuery('.product_name').css({'border-color': '#fa6374'});
            isValid = false;
        } else {
            jQuery('.product_name_error').html('');
            jQuery('.product_name').css({'border-color': ''});
        }

        if(sku == ''){
            jQuery('.sku_error').html('Please Enter Product SKU');
            jQuery('.sku').css({'border-color': '#fa6374'});
            isValid = false;
        } else {
            jQuery('.sku_error').html('');
            jQuery('.sku').css({'border-color': ''});
        }

        if (CKEDITOR.instances['editor1'].getData() === '') {
            $('.editor1_error').html('Please enter a product description');
            valid = false;
        } else {
            $('.editor1_error').html('');
        }



        if(is_configure_product == '0'){
            if(mrp_price == ''){
                jQuery('.mrp_price_error').html('Please Enter Product MRP Price');
                jQuery('.mrp_price').css({'border-color': '#fa6374'});
                isValid = false;
            } else {
                jQuery('.mrp_price_error').html('');
                jQuery('.mrp_price').css({'border-color': ''});
            }

            if(special_price == ''){
                jQuery('.special_price_error').html('Please Enter Product Special Price');
                jQuery('.special_price').css({'border-color': '#fa6374'});
                isValid = false;
            } else {
                jQuery('.special_price_error').html('');
                jQuery('.special_price').css({'border-color': ''});
            }

            if(qty == ''){
                jQuery('.qty_error').html('Please Enter QTY');
                jQuery('.qty').css({'border-color': '#fa6374'});
                isValid = false;
            } else {
                jQuery('.qty_error').html('');
                jQuery('.qty').css({'border-color': ''});
            }
        }

        if(is_configure_product == '1'){
            var weightValues = jQuery('select[name="weight_values[]"]').map(function(){ return this.value; }).get();
            var configureMrpPrices = jQuery('input[name="configure_mrp_price[]"]').map(function(){ return this.value; }).get();
            var configureSpecialPrices = jQuery('input[name="configure_special_price[]"]').map(function(){ return this.value; }).get();
            var configureQtys = jQuery('input[name="configure_qty[]"]').map(function(){ return this.value; }).get();

            weightValues.forEach(function(value, index){
                if(value == ''){
                    jQuery('.weight_values_error').eq(index).html('Please Select Weight');
                    isValid = false;
                } else {
                    jQuery('.weight_values_error').eq(index).html('');
                }
            });

            configureMrpPrices.forEach(function(value, index){
                if(value == ''){
                    jQuery('.configure_mrp_price_error').eq(index).html('Please Enter MRP Price');
                    isValid = false;
                } else {
                    jQuery('.configure_mrp_price_error').eq(index).html('');
                }
            });

            configureSpecialPrices.forEach(function(value, index){
                if(value == ''){
                    jQuery('.configure_special_price_error').eq(index).html('Please Enter Special Price');
                    isValid = false;
                } else {
                    jQuery('.configure_special_price_error').eq(index).html('');
                }
            });

            configureQtys.forEach(function(value, index){
                if(value == ''){
                    jQuery('.configure_qty_error').eq(index).html('Please Enter Qty');
                    isValid = false;
                } else {
                    jQuery('.configure_qty_error').eq(index).html('');
                }
            });
        }

        if(product_available_status == ''){
            jQuery('.product_available_status_error').html('Please Select Availability Status');
            jQuery('.product_available_status').css({'border-color': '#fa6374'});
            isValid = false;
        } else {
            jQuery('.product_available_status_error').html('');
            jQuery('.product_available_status').css({'border-color': ''});
        }

        if(meta_keyword == ''){
            jQuery('.meta_keyword_error').html('Please Enter Meta Keyword');
            jQuery('.meta_keyword').css({'border-color': '#fa6374'});
            isValid = false;
        } else {
            jQuery('.meta_keyword_error').html('');
            jQuery('.meta_keyword').css({'border-color': ''});
        }

        if(meta_title == ''){
            jQuery('.meta_title_error').html('Please Enter Meta Title');
            jQuery('.meta_title').css({'border-color': '#fa6374'});
            isValid = false;
        } else {
            jQuery('.meta_title_error').html('');
            jQuery('.meta_title').css({'border-color': ''});
        }

        if(meta_description == ''){
            jQuery('.meta_description_error').html('Please Enter Meta Description');
            jQuery('.meta_description').css({'border-color': '#fa6374'});
            isValid = false;
        } else {
            jQuery('.meta_description_error').html('');
            jQuery('.meta_description').css({'border-color': ''});
        }

        if(product_main_image == 0){
            jQuery('.product_main_image_error').html('Please Insert Product Image');
            jQuery('.product_main_image').css({'border-color': '#fa6374'});
            isValid = false;
        } else {
            jQuery('.product_main_image_error').html('');
            jQuery('.product_main_image').css({'border-color': ''});
        }

        if(isValid){
            var formData = new FormData();
            formData.append('main_category_id', main_category_id);
            formData.append('sub_category_id', sub_category_id);
            formData.append('product_name', product_name);
            formData.append('sku', sku);
            formData.append('is_configure_product', is_configure_product);
            formData.append('mrp_price', mrp_price);
            formData.append('special_price', special_price);
            formData.append('qty', qty);
            formData.append('product_available_status', product_available_status);
            formData.append('related_product_ids', related_product_ids);
            formData.append('is_home_display', is_home_display);
            formData.append('meta_title', meta_title);
            formData.append('meta_keyword', meta_keyword);
            formData.append('meta_description', meta_description);
            formData.append('editor1', editor1);
            
            if(is_configure_product == '1'){
                weightValues.forEach(function(value, index){
                    formData.append('weight_values[]', value);
                    formData.append('configure_mrp_price[]', configureMrpPrices[index]);
                    formData.append('configure_special_price[]', configureSpecialPrices[index]);
                    formData.append('configure_qty[]', configureQtys[index]);
                });
            }

            if(product_main_image > 0){
                formData.append('product_main_image', jQuery('#product_main_image')[0].files[0]);
            }

            var additionalImages = jQuery('input[name="product_multiple_image[]"]');
            additionalImages.each(function(){
                formData.append('product_multiple_image[]', jQuery(this)[0].files[0]);
            });

            jQuery.ajax({
                url: 'product_submit_data.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    var statusRes = JSON.parse(response);
                    if(statusRes.status =='true'){
                       Swal.fire({
                            title: "Success",
                            text: statusRes.msg,
                            icon: "success",
                            button: "Okay", 
                        }).then(function() {
                            window.location = "product_listing.php";
                        }); 
                    }

                    if(statusRes.status =='false'){
                        Swal.fire({
                            title: "Warning",
                            text: statusRes.msg,
                            icon: "error",
                            button: "Okay",
                        });
                    }
                },
                error: function(xhr, status, error){
                    // handle error response
                    console.log(error);
                }
            });
        }
    }
</script>

<?php include "footer.php"; ?>