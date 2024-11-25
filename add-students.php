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
    if (isset($_POST['submit'])) {
        $stuname = $_POST['stuname'];
        $stuemail = $_POST['stuemail'];
        $stuclass = $_POST['stuclass'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $stuid = $_POST['stuid'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $connum = $_POST['connum'];
        $altconnum = $_POST['altconnum'];
        $address = $_POST['address'];
        $image = $_FILES["image"]["name"];
        
        $ret = "SELECT StuID FROM tblstudent WHERE StuID=:stuid";
        $query = $dbh->prepare($ret);
        $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        
        if ($query->rowCount() == 0) {
            $extension = substr($image, strlen($image) - 4, strlen($image));
            $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");
            if (!in_array($extension, $allowed_extensions)) {
                echo "<script>alert('La imagen tiene un formato inválido. Solo se permiten los formatos jpg / jpeg / png / gif');</script>";
            } else {
                $image = md5($image) . time() . $extension;
                move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $image);
                $sql = "INSERT INTO tblstudent(StudentName, StudentEmail, StudentClass, Gender, DOB, StuID, FatherName, MotherName, ContactNumber, AltenateNumber, Address, Image) 
                        VALUES (:stuname, :stuemail, :stuclass, :gender, :dob, :stuid, :fname, :mname, :connum, :altconnum, :address, :image)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':stuname', $stuname, PDO::PARAM_STR);
                $query->bindParam(':stuemail', $stuemail, PDO::PARAM_STR);
                $query->bindParam(':stuclass', $stuclass, PDO::PARAM_STR);
                $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                $query->bindParam(':dob', $dob, PDO::PARAM_STR);
                $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
                $query->bindParam(':fname', $fname, PDO::PARAM_STR);
                $query->bindParam(':mname', $mname, PDO::PARAM_STR);
                $query->bindParam(':connum', $connum, PDO::PARAM_STR);
                $query->bindParam(':altconnum', $altconnum, PDO::PARAM_STR);
                $query->bindParam(':address', $address, PDO::PARAM_STR);
                $query->bindParam(':image', $image, PDO::PARAM_STR);
                $query->execute();
                $LastInsertId = $dbh->lastInsertId();
                if ($LastInsertId > 0) {
                    echo '<script>alert("El Registro ha sido agregado.")</script>';
                    echo "<script>window.location.href ='add-students.php'</script>";
                } else {
                    echo '<script>alert("Algo salió mal. Por favor, inténtalo de nuevo")</script>';
                }
            }
        } else {
            echo "<script>alert('El DPI de la mujer ya existe. Por favor, inténtalo de nuevo');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Estudiantes</title>
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
</head>
<body>
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php'); ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">Agregar Mujer</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Oficina de La Mujer</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Agregar Mujer</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form class="forms-sample row" method="post" enctype="multipart/form-data">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Nombre </label>
                                        <input type="text" name="stuname" class="form-control" required='true' pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Correo Electrónico </label>
                                        <input type="email" name="stuemail" class="form-control" required='true'>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail3">Asignar el Curso a seguir</label>
                                        <select name="stuclass" class="form-control" required='true'>
                                            <option value="">Seleccionar curso</option>
                                            <?php 
                                            $sql2 = "SELECT * from tblclass";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($result2 as $row1) {          
                                            ?>  
                                            <option value="<?php echo htmlentities($row1->ID);?>">
                                                <?php echo htmlentities($row1->ClassName);?> <?php echo htmlentities($row1->Section);?>
                                            </option>
                                            <?php } ?> 
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Género</label>
                                        <select name="gender" class="form-control" required='true'>
                                            <option value="">Elegir Género</option>
                                            <option value="Male">Masculino</option>
                                            <option value="Female">Femenino</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Fecha de Nacimiento</label>
                                        <input type="date" name="dob" class="form-control" required='true'>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">DPI</label>
                                        <input type="text" name="stuid" class="form-control" required='true' pattern="[A-Za-z0-9]+">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Foto de La Mujer</label>
                                        <input type="file" name="image" class="form-control" required='true'>
                                    </div>
                                    <h3 class="col-md-12">Detalles del Tutor</h3>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Nombre</label>
                                        <input type="text" name="fname" class="form-control" required='true' pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Apellidos</label>
                                        <input type="text" name="mname" class="form-control" required='true' pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Número de Contacto</label>
                                        <input type="text" name="connum" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Número de Contacto Alternativo</label>
                                        <input type="text" name="altconnum" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputName1">Dirección</label>
                                        <textarea name="address" class="form-control"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Agregar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
</body>
</html>
<?php } ?>
