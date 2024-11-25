<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if(isset($_POST['login'])) 
{
    $username = $_POST['username'];
    $entered_password = hash('sha512', $_POST['password']); // Encriptar la contraseña ingresada con SHA-512
    
    // Corregir: Seleccionar también RoleID
    $sql = "SELECT ID, RoleID FROM tbladmin WHERE UserName=:username AND Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $entered_password, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    
    if($result) {
        $_SESSION['sturecmsaid'] = $result->ID;
        $_SESSION['RoleID'] = $row->RoleID; // Asumiendo que $row contiene los datos del usuario

        if(!empty($_POST["remember"])) {
            // COOKIES para el nombre de usuario
            setcookie("user_login", $username, time() + (10 * 365 * 24 * 60 * 60));
            // COOKIES para la contraseña
            setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
        } else {
            if(isset($_COOKIE["user_login"])) {
                setcookie("user_login", "", time() - 3600); // Expirar la cookie
            }
            if(isset($_COOKIE["userpassword"])) {
                setcookie("userpassword", "", time() - 3600); // Expirar la cookie
            }
        }
        $_SESSION['login'] = $username;
        echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Oficina de la Mujer</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
   <style>
       .content-wrapper{
            background-image: url('assets/images/fondo.jpg');
            background-size: cover;
        }
        .brand-logo img {
            width: auto;
            height: auto;
        }
   </style>
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-center p-5">
                            <div class="brand-logo">
                                <img src="assets/images/logoOficina.png">
                            </div>
                            <h4>Hola! Bienvenido</h4>
                            <h6 class="font-weight-light">Inicie sesión para continuar.</h6>
                            <form class="pt-3" id="login" method="post" name="login">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" placeholder="Ingrese su usuario" required="true" name="username" value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>" >
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" placeholder="Ingrese su contraseña" name="password" required="true" value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>">
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-success btn-block loginbtn" name="login" type="submit">Iniciar sesión</button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" id="remember" class="form-check-input" name="remember" <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?> /> Mantener sesión</label>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- endinject -->
</body>
</html>
