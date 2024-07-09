<?php
   include "config.inc.php";
   
   if (isset($_SESSION['Logindata']['email']) && $_SESSION['Logindata']['email'] != '') {
       $loginUserEmail = $_SESSION['Logindata']['email'];
   } else {
       echo "<script type='text/javascript'>
               window.location.href = 'auth-login.php';
             </script>";
       exit();
   }
   ?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>CRM Admin Dashboard</title>
      <meta name="googlebot" content="noindex, nofollow">
      <meta name="robots" content="noindex, nofollow">
      <meta name="robots" content="noimageindex">
      <!-- App favicon -->
      <link rel="shortcut icon" href="assets/images/favicon.ico">
      <!-- Sweet Alert-->
      <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
      <!-- gridjs css -->
      <link rel="stylesheet" href="assets/libs/gridjs/theme/mermaid.min.css">
      <!-- Bootstrap Css -->
      <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
      <!-- Icons Css -->
      <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
      <!-- Sweet Alert-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
      <!-- Switch Css-->
      <link href="assets/switchery/dist/switchery.min.css" rel="stylesheet">
      <!-- App Css-->
      <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
      <link href="assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />
      <!-- choices css -->
      <link href="assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
      <!-- alertifyjs default themes  Css -->
      <link href="assets/libs/alertifyjs/build/css/themes/default.min.css" rel="stylesheet" type="text/css" />
      <script src="assets/js/setting.js"></script>
      <!-- choices js -->
      <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>    
      <!-- init js -->
      <script src="assets/js/pages/form-advanced.init.js"></script>
      <style type="text/css">
         .wrapper {
         margin-top: 5vh;
         }
         .dataTables_filter {
         float: right;
         }
         .table-hover > tbody > tr:hover {
         background-color: #ccffff;
         }
         @media only screen and (min-width: 768px) {
         .table {
         table-layout: fixed;
         max-width: 100% !important;
         }
         }
         thead {
         background: #ddd;
         }
         .table td:nth-child(2) {
         overflow: hidden;
         text-overflow: ellipsis;
         }
         .highlight {
         background: #ffff99;
         }
         @media only screen and (max-width: 767px) {
         /* Force table to not be like tables anymore */
         table,
         thead,
         tbody,
         th,
         td,
         tr {
         display: block;
         }
         /* Hide table headers (but not display: none;, for accessibility) */
         thead tr,
         tfoot tr {
         position: absolute;
         top: -9999px;
         left: -9999px;
         }
         td {
         /* Behave  like a "row" */
         border: none;
         border-bottom: 0.5px solid #eee;
         position: relative;
         padding-left: 50% !important;
         }
         td:before {
         /* Now like a table header */
         position: absolute;
         /* Top/left values mimic padding */
         top: 6px;
         left: 6px;
         width: 45%;
         padding-right: 10px;
         white-space: nowrap;
         }
         .table td:nth-child(1) {
         background: #ccc;
         height: 100%;
         top: 0;
         left: 0;
         font-weight: bold;
         }
         /*
         Label the data
         */
         .dataTables_length {
         display: none;
         }
         .dataTables_length label {
         display: flex;
         justify-content: space-between;
         align-items: center;
         }
         }
      </style>
      <!-- Bootstrap 5 CSS -->
      <!-- Data Table JS -->
      <script src='https://code.jquery.com/jquery-3.7.0.js'></script>
      <script src='https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js'></script>
      <script src='https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js'></script>
      <script src='https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js'></script>
      <script src='https://cdn.datatables.net/plug-ins/1.10.25/api/fnFilterClear.js'></script>
      <script type="text/javascript">
         $(document).ready(function () {
             var table = $('#example').DataTable({
                 // disable sorting on last column
                 "columnDefs": [
                     { "orderable": false, "targets": 1 }
                 ],
                 // add vertical and horizontal scrollbar
                 "scrollY": "100%", // adjust the height as needed
                 "scrollX": true,
                 "scrollCollapse": true,
                 language: {
                     // customize pagination prev and next buttons: use arrows instead of words
                     'paginate': {
                         'previous': '<span class="fa fa-chevron-left"></span>',
                         'next': '<span class="fa fa-chevron-right"></span>'
                     },
                     // customize number of elements to be displayed
                     "lengthMenu": 'Display <select class="form-control input-sm">' +
                         '<option value="10">10</option>' +
                         '<option value="20">20</option>' +
                         '<option value="30">30</option>' +
                         '<option value="40">40</option>' +
                         '<option value="50">50</option>' +
                         '<option value="-1">All</option>' +
                         '</select> results'
                 }
             });
         
             // Create a row for search inputs above the table
             var searchRow = $('<tr id="search-row"></tr>');
             $('#example thead th').each(function () {
                 searchRow.append('<th><input type="text" class="form-control column-search" placeholder="Search ' + $(this).text() + '" /></th>');
             });
             $('#example thead').before(searchRow);
         
             // Apply the search
             $('.column-search').on('keyup change', function () {
                 var index = $(this).closest('th').index();
                 table.column(index).search(this.value).draw();
             });
         });
      </script>
   </head>
   <body data-layout="vertical" data-topbar="light" data-new-gr-c-s-check-loaded="14.1148.0" data-gr-ext-installed=""  data-sidebar="dark" data-layout-mode='light' class="sidebar-enable">
      <!-- Begin page -->
      <div id="layout-wrapper">
      <header id="page-topbar" class="isvertical-topbar">
         <div class="navbar-header">
            <div class="d-flex">
               <!-- LOGO -->
               <div class="navbar-brand-box">
                  <a href="index.php" class="logo logo-dark">
                  <span class="logo-sm">
                  <img src="assets/images/logo-sm.svg" alt="" height="22">
                  </span>
                  <span class="logo-lg">
                  <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">CRM</span>
                  </span>
                  </a>
                  <a href="index.php" class="logo logo-light">
                  <span class="logo-sm">
                  <img src="assets/images/logo-sm.svg" alt="" height="22">
                  </span>
                  <span class="logo-lg">
                  <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">CRM</span>
                  </span>
                  </a>
               </div>
               <button type="button"  class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
               <i class="fa fa-fw fa-bars"></i>
               </button>
            </div>
            <div class="d-flex">
               <div class="dropdown d-inline-block">
                  <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                     data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                     alt="Header Avatar">
                  </button>
                  <div class="dropdown-menu dropdown-menu-end pt-0">
                     <a class="dropdown-item" href="logout.php"><i class='bx bx-log-out text-muted font-size-18 align-middle me-1'></i> <span class="align-middle">Logout</span></a>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- ========== Left Sidebar Start ========== -->
      <div class="vertical-menu">
         <!-- LOGO -->
         <div class="navbar-brand-box">
            <a href="index.php" class="logo logo-dark">
            <span class="logo-sm">
            <img src="assets/images/logo-sm.svg" alt="" height="22"> 
            </span>
            <span class="logo-lg">
            <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">CRM</span>
            </span>
            </a>
            <a href="index.php" class="logo logo-light">
            <span class="logo-lg">
            <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">CRM</span>
            </span>
            <span class="logo-sm">
            <img src="assets/images/logo-sm.svg" alt="" height="22">
            </span>
            </a>
         </div>
         <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
         <i class="fa fa-fw fa-bars"></i>
         </button>
         <div data-simplebar class="sidebar-menu-scroll">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
               <!-- Left Menu Start -->
               <ul class="metismenu list-unstyled" id="side-menu">
                  <li>
                     <a href="index.php">
                     <i class="bx bx-tachometer icon nav-icon"></i>
                     <span class="menu-item" data-key="t-dashboards">Dashboard</span>
                     </a>
                  </li>
                  <li class="menu-title" data-key="t-catalog">Catalog</li>
                  <li>
                     <a href="javascript: void(0);" class="has-arrow">
                     <i class="bx bx-file icon nav-icon"></i>
                     <span class="menu-item" data-key="t-catalog">Catalog</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li><a href="categories.php" data-key="t-inbox">Category</a></li>
                        <li><a href="SidemenuSubcategories.php" data-key="t-read-email">Sub Category</a></li>
                        <li><a href="product_listing.php" data-key="t-read-email">Products</a></li>
                     </ul>
                  </li>
                

                  <li class="menu-title" data-key="t-banner">Manage Banner</li>
                  <li>
                     <a href="javascript: void(0);" class="has-arrow">
                     <i class="bx bx-file icon nav-icon"></i>
                     <span class="menu-item" data-key="t-banner">Manage Banners</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li><a href="banner.php" data-key="t-banner">Banners</a></li>
                     </ul>
                  </li>

                  <li class="menu-title" data-key="t-banner">Manage Site Settings</li>
                  <li>
                     <a href="javascript: void(0);" class="has-arrow">
                     <i class="bx bx-file icon nav-icon"></i>
                     <span class="menu-item" data-key="t-banner">Manage Site Settings</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li><a href="sitesetting.php" data-key="t-banner">Site Settings</a></li>
                     </ul>
                  </li>

                  <li class="menu-title" data-key="t-banner">Manage About us</li>
                  <li>
                     <a href="javascript: void(0);" class="has-arrow">
                     <i class="bx bx-file icon nav-icon"></i>
                     <span class="menu-item" data-key="t-banner">Manage About us</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li><a href="aboutus.php" data-key="t-banner">About us</a></li>
                     </ul>
                  </li>
                
               </ul>
            </div>
            <!-- Sidebar -->
         </div>
      </div>