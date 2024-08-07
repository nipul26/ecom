<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login | Symox - Codeigniter Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body data-layout="horizontal" data-topbar="dark">
    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="text-center mb-4">
                            <a href="index.html">
                                <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">Symox</span>
                            </a>
                        </div>
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to Symox.</p>
                                </div>
                                <div class="p-2 mt-4">
<form method="post" action="auth-login.php">
    <div class="mb-3">
        <label class="form-label" for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="userpassword">Password</label>
        <input type="password" class="form-control" id="userpassword" name="userpassword" placeholder="Enter password" required>
    </div>
    <div class="mt-3 text-end">
        <button class="btn btn-primary w-sm waves-effect waves-light" type="submit" name="login">Log In</button>
    </div>
</form>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center text-muted p-4">
                            <p class="text-white-50">© <script>document.write(new Date().getFullYear())</script> Symox. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end container -->
    </div>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenujs/metismenujs.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>

    <!-- Include SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    session_start(); 
    include "config.inc.php";

    if (isset($_POST["login"])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = md5(mysqli_real_escape_string($conn, $_POST['userpassword']));

        $checkUserLogin = mysqli_query($conn, "SELECT * FROM user_login WHERE email = '$email' AND password = '$password'");

        if ($checkUserLogin) {
            if (mysqli_num_rows($checkUserLogin) > 0) {
                $_SESSION['Logindata'] = mysqli_fetch_assoc($checkUserLogin); 
                header("Location: index.php");
                exit();
            } else { ?>
                <script type='text/javascript'>
                        Swal.fire({
                            title: 'Error',
                            text: 'Incorrect email or password. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'Okay'
                        }).then(function() {
                            window.location = 'auth-login.php';
                        });
                      </script>
                      <?php
            }
        } else {
            // Handle query execution error
            echo "Error: " . mysqli_error($conn);
        }
    }
    ?>
</body>
</html>
