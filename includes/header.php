
<?php
// Verificar si la sesión ya está activa antes de iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('includes/dbconnection.php');

// Obtener el ID del administrador desde la sesión
$adminid = $_SESSION['sturecmsaid'];

// Obtener el rol del administrador
$sql = "SELECT RoleID FROM tbladmin WHERE ID=:adminid";
$query = $dbh->prepare($sql);
$query->bindParam(':adminid', $adminid, PDO::PARAM_INT);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

// Verifica si el rol del administrador es "supervisor"
$isSupervisor = ($result && $result->RoleID == 2);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Oficina Municipal de La Mujer</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="assets/vendors/chartist/chartist.min.css">
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
   
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
        <script type="text/javascript">
function checkpass()
{
if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
{
alert('New Password and Confirm Password field does not match');
document.changepassword.confirmpassword.focus();
return false;
}
return true;
}   

</script>
  </head>
  <body>
    <div id="page"></div>
<div id="loading"></div>
    <div class="container-scroller">
 <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex align-items-center">
          <a class="navbar-brand brand-logo ml-auto text-right" href="dashboard.php">
          <img src="assets/images/logoOficina.png">
          </a>
          <a class="navbar-brand brand-logo-mini" href="dashboard.php"><img src="assets/images/logonormal.png" alt="logo" /></a>
        </div><?php
         $aid= $_SESSION['sturecmsaid'];
$sql="SELECT * from tbladmin where ID=:aid";

$query = $dbh -> prepare($sql);
$query->bindParam(':aid',$aid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
        <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
          <h5 class="mb-0 font-weight-medium d-none d-lg-flex mx-auto"><?php  echo htmlentities($row->AdminName);?> BIENVENIDO AL SISTEMA DE REGISTROS DE LA OFICINA MUNICIPAL DE LA MUJER, MALACATÁN, SAN MARCOS.</h5>
          <div id="google_translate_element" class="ml-auto"></div>

          <ul class="navbar-nav navbar-nav-right ml-auto">
            <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle ml-2" src="assets/images/faces/face9.png" alt="Profile image"> <span class="font-weight-normal"> <?php  echo htmlentities($row->AdminName);?> </span></a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header d-flex">
                  <img class="img-md rounded-circle" src="assets/images/faces/face9.png" width="60px" alt="Profile image">
                  <div><p class="mb-1 mt-3"><?php  echo htmlentities($row->AdminName);?></p>
                  <p class="font-weight-light text-muted mb-0"><?php  echo htmlentities($row->Email);?></p> </div>
                  
                </div><?php $cnt=$cnt+1;}} ?>
                <a class="dropdown-item" href="profile.php"><i class="dropdown-item-icon icon-user text-primary"></i> Mi Perfil</a>

                <?php if (!$isSupervisor) { ?>
                <a class="dropdown-item" href="new-admin.php"><i class="dropdown-item-icon icon-energy text-primary"></i>Nuevo Administrador</a>
                <?php } ?>
                <a class="dropdown-item" href="logout.php"><i class="dropdown-item-icon icon-power text-primary"></i>Cerrar Sesión</a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
          </button>
        </div>
      </nav>