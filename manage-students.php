<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    // Código para eliminar
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "DELETE FROM tblstudent WHERE ID = :rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Datos eliminados');</script>";
        echo "<script>window.location.href = 'manage-students.php'</script>";
    }
?>
    <!--  Nombre del autor original: CompuBinario.K. 
     para cualquier trabajo en PHP, Codeignitor, Laravel O Python contáctame en mdkhairnar92@gmail.com  
     Visita el sitio web : https://CompuBinariok.com --> 

    <!-- parcial:partials/_navbar.html -->
    <?php include_once('includes/header.php'); ?>
    <!-- parcial -->
     
    <div class="container-fluid page-body-wrapper">
        <!-- parcial:partials/_sidebar.html -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- parcial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title"> Administrar Mujer </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Oficina de La Mujer</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Administrar Mujer</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex align-items-center mb-4">
                                    <h4 class="card-title mb-sm-0">Administrar Mujer</h4>
                                    <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> Ver todas las Mujeres</a>
                                </div>
                                <div class="table-responsive border rounded p-1">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="font-weight-bold">Nro</th>
                                                <th class="font-weight-bold">DPI </th>
                                                <th class="font-weight-bold">Curso</th>
                                                <th class="font-weight-bold">Nombre</th>
                                                <th class="font-weight-bold">Email</th>
                                                <th class="font-weight-bold">Fecha de Admisión</th>
                                                <th class="font-weight-bold">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_GET['pageno'])) {
                                                $pageno = $_GET['pageno'];
                                            } else {
                                                $pageno = 1;
                                            }
                                            // Fórmula para la paginación
                                            $no_of_records_per_page = 15;
                                            $offset = ($pageno - 1) * $no_of_records_per_page;
                                            $ret = "SELECT ID FROM tblstudent";
                                            $query1 = $dbh->prepare($ret);
                                            $query1->execute();
                                            $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                            $total_rows = $query1->rowCount();
                                            $total_pages = ceil($total_rows / $no_of_records_per_page);
                                            $sql = "SELECT tblstudent.StuID, tblstudent.ID as sid, tblstudent.StudentName, tblstudent.StudentEmail, tblstudent.DateofAdmission, tblclass.ClassName, tblclass.Section FROM tblstudent JOIN tblclass ON tblclass.ID = tblstudent.StudentClass LIMIT $offset, $no_of_records_per_page";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $row) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($row->StuID); ?></td>
                                                        <td><?php echo htmlentities($row->ClassName); ?> <?php echo htmlentities($row->Section); ?></td>
                                                        <td><?php echo htmlentities($row->StudentName); ?></td>
                                                        <td><?php echo htmlentities($row->StudentEmail); ?></td>
                                                        <td><?php echo htmlentities($row->DateofAdmission); ?></td>
                                                        <td>
                                                            <a href="edit-student-detail.php?editid=<?php echo htmlentities($row->sid); ?>" class="btn btn-primary btn-sm"><i class="icon-eye"></i></a>
                                                            <a href="manage-students.php?delid=<?php echo ($row->sid); ?>" onclick="return confirm('¿Realmente quieres eliminar?');" class="btn btn-danger btn-sm"> <i class="icon-trash"></i></a>
                                                        </td>
                                                    </tr>
                                            <?php $cnt = $cnt + 1;
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div align="left">
                                    <ul class="pagination">
                                        <li><a href="?pageno=1"><strong>Primero></strong></a></li>
                                        <li class="<?php if ($pageno <= 1) {
                                                        echo 'disabled';
                                                    } ?>">
                                            <a href="<?php if ($pageno <= 1) {
                                                            echo '#';
                                                        } else {
                                                            echo "?pageno=" . ($pageno - 1);
                                                        } ?>"><strong style="padding-left: 10px">Anterior></strong></a>
                                        </li>
                                        <li class="<?php if ($pageno >= $total_pages) {
                                                        echo 'disabled';
                                                    } ?>">
                                            <a href="<?php if ($pageno >= $total_pages) {
                                                            echo '#';
                                                        } else {
                                                            echo "?pageno=" . ($pageno + 1);
                                                        } ?>"><strong style="padding-left: 10px">Siguiente></strong></a>
                                        </li>
                                        <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Último</strong></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
            <?php include_once('includes/footer.php'); ?>
            <!-- parcial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
<?php } ?>
