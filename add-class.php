<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Verifica si la sesión es válida
if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit();
} else {
    // Obtener el ID del administrador desde la sesión
    $adminid = $_SESSION['sturecmsaid'];

    // Obtener el rol del administrador
    $sql = "SELECT RoleID FROM tbladmin WHERE ID=:adminid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':adminid', $adminid, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    // Verifica si el rol del administrador es "supervisor"
    if ($result && $result->RoleID == 2) {
        header('location:accesodenegado.php');
        exit();
    }

    // Si se ha enviado el formulario
    if (isset($_POST['submit'])) {
        $cname = $_POST['cname'];
        $section = $_POST['section'];

        $sql = "INSERT INTO tblclass(ClassName, Section) VALUES (:cname, :section)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cname', $cname, PDO::PARAM_STR);
        $query->bindParam(':section', $section, PDO::PARAM_STR);

        // Ejecuta la consulta
        if ($query->execute()) {
            echo '<script>alert("Class has been added.")</script>';
            echo "<script>window.location.href ='add-class.php'</script>";
        } else {
            echo '<script>alert("Something went wrong. Please try again.")</script>';
        }
    }
}
?>

<?php include_once('includes/header.php'); ?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <?php include_once('includes/sidebar.php'); ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Agregar Curso programado</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Oficina de la Mujer</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Agregar Curso</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form class="forms-sample" method="post">
                                <div class="form-group">
                                    <label for="exampleInputName1">Nombre del curso</label>
                                    <input type="text" name="cname" value="" class="form-control" required="true">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Sección</label>
                                    <select name="section" class="form-control" required="true">
                                        <option value="">Choose Section</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2" name="submit">Agregar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php include_once('includes/footer.php'); ?>
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
