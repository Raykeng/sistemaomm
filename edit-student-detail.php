<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
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
        $eid = $_GET['editid'];

        $sql = "UPDATE tblstudent SET StudentName=:stuname, StudentEmail=:stuemail, StudentClass=:stuclass, Gender=:gender, DOB=:dob, StuID=:stuid, FatherName=:fname, MotherName=:mname, ContactNumber=:connum, AltenateNumber=:altconnum, Address=:address WHERE ID=:eid";
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
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("El estudiante ha sido actualizado")</script>';
    }
?>

<!-- partial:partials/_navbar.html -->
<?php include_once('includes/header.php'); ?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <?php include_once('includes/sidebar.php'); ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Registro de la Mujer </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Tablero</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Informacion de la Mujer</li>
                    </ol>
                </nav>
            </div>
            <div class="row">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title" style="text-align: center;">Informacion de la Mujer</h4>

                            <form class="forms-sample" method="post" enctype="multipart/form-data">
                                <?php
                                $eid = $_GET['editid'];
                                $sql = "SELECT tblstudent.StudentName, tblstudent.StudentEmail, tblstudent.StudentClass, tblstudent.Gender, tblstudent.DOB, tblstudent.StuID, tblstudent.FatherName, tblstudent.MotherName, tblstudent.ContactNumber, tblstudent.AltenateNumber, tblstudent.Address, tblstudent.Image, tblclass.ClassName, tblclass.Section FROM tblstudent JOIN tblclass ON tblclass.ID = tblstudent.StudentClass WHERE tblstudent.ID = :eid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) {
                                ?>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Nombre </label>
                                            <input type="text" name="stuname" value="<?php echo htmlentities($row->StudentName); ?>" class="form-control" required='true' pattern="[a-zA-Z\s]+">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Correo Electrónico </label>
                                            <input type="email" name="stuemail" value="<?php echo htmlentities($row->StudentEmail); ?>" class="form-control" required='true'>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail3">Curso</label>
                                            <select name="stuclass" class="form-control" required='true'>
                                                <option value="<?php echo htmlentities($row->StudentClass); ?>"><?php echo htmlentities($row->ClassName); ?> <?php echo htmlentities($row->Section); ?></option>
                                                <?php
                                                $sql2 = "SELECT * from tblclass";
                                                $query2 = $dbh->prepare($sql2);
                                                $query2->execute();
                                                $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                foreach ($result2 as $row1) {
                                                ?>
                                                    <option value="<?php echo htmlentities($row1->ID); ?>"><?php echo htmlentities($row1->ClassName); ?> <?php echo htmlentities($row1->Section); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Género</label>
                                            <select name="gender" class="form-control" required='true'>
                                                <option value="<?php echo htmlentities($row->Gender); ?>"><?php echo htmlentities($row->Gender); ?></option>
                                                <option value="Male">Masculino</option>
                                                <option value="Female">Femenino</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Fecha de Nacimiento</label>
                                            <input type="date" name="dob" value="<?php echo htmlentities($row->DOB); ?>" class="form-control" required='true'>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">DPI</label>
                                            <input type="text" name="stuid" value="<?php echo htmlentities($row->StuID); ?>" class="form-control" required='true' pattern="[a-zA-Z0-9]+">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Foto </label>
                                            <img src="assets/images/dulcefoto.jpg" width="100" height="100">
                                        </div>
                                        <h3>Detalles del tutor</h3>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Nombre del Tutor</label>
                                            <input type="text" name="fname" value="<?php echo htmlentities($row->FatherName); ?>" class="form-control" required='true' pattern="[a-zA-Z\s]+">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Apellidos del Tutor</label>
                                            <input type="text" name="mname" value="<?php echo htmlentities($row->MotherName); ?>" class="form-control" required='true' pattern="[a-zA-Z\s]+">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Número de Contacto</label>
                                            <input type="text" name="connum" value="<?php echo htmlentities($row->ContactNumber); ?>" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Número de Contacto Alternativo</label>
                                            <input type="text" name="altconnum" value="<?php echo htmlentities($row->AltenateNumber); ?>" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Dirección</label>
                                            <textarea name="address" class="form-control" required='true' pattern="[a-zA-Z0-9\s,.]+"><?php echo htmlentities($row->Address); ?></textarea>
                                        </div>
                                        <?php if (!$isSupervisor) { ?>
                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Actualizar</button> <?php } ?>
                                <?php }
                                } ?>
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
</div>
<!-- container-scroller -->
<?php } ?>
