<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    // Código para eliminación
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "DELETE FROM tblnotice WHERE ID = :rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Datos eliminados');</script>";
        echo "<script>window.location.href = 'manage-notice.php'</script>";
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
                <h3 class="page-title">Gestionar Noticia</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Tablero</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gestionar Noticia</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex align-items-center mb-4">
                                <h4 class="card-title mb-sm-0">Gestionar Noticia</h4>
                                <a href="#" class="text-dark ml-auto mb-3 mb-sm-0">Ver todos las noticias</a>
                            </div>
                            <div class="table-responsive border rounded p-1">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="font-weight-bold">N.º</th>
                                            <th class="font-weight-bold">Título de la noticia</th>
                                            <th class="font-weight-bold">Clase</th>
                                            <th class="font-weight-bold">Sección</th>
                                            <th class="font-weight-bold">Fecha de la noticia</th>
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
                                        // Fórmula para paginación
                                        $no_of_records_per_page = 15;
                                        $offset = ($pageno - 1) * $no_of_records_per_page;
                                        $ret = "SELECT ID FROM tblnotice";
                                        $query1 = $dbh->prepare($ret);
                                        $query1->execute();
                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                        $total_rows = $query1->rowCount();
                                        $total_pages = ceil($total_rows / $no_of_records_per_page);
                                        $sql = "SELECT tblclass.ID, tblclass.ClassName, tblclass.Section, tblnotice.NoticeTitle, tblnotice.CreationDate, tblnotice.ClassId, tblnotice.ID as nid FROM tblnotice JOIN tblclass ON tblclass.ID = tblnotice.ClassId LIMIT $offset, $no_of_records_per_page";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $row) {
                                        ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($row->NoticeTitle); ?></td>
                                                    <td><?php echo htmlentities($row->ClassName); ?></td>
                                                    <td><?php echo htmlentities($row->Section); ?></td>
                                                    <td><?php echo htmlentities($row->CreationDate); ?></td>
                                                    <td>
                                                        <a href="edit-notice-detail.php?editid=<?php echo htmlentities($row->ID); ?>" class="btn btn-primary btn-sm"><i class="icon-eye"></i></a>
                                                        <a href="manage-notice.php?delid=<?php echo ($row->ID); ?>" onclick="return confirm('¿Realmente deseas eliminar?');" class="btn btn-danger btn-sm"><i class="icon-trash"></i></a>
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
                                    <li><a href="?pageno=1"><strong>Primero</strong></a></li>
                                    <li class="<?php if ($pageno <= 1) {
                                                    echo 'disabled';
                                                } ?>">
                                        <a href="<?php if ($pageno <= 1) {
                                                        echo '#';
                                                    } else {
                                                        echo "?pageno=" . ($pageno - 1);
                                                    } ?>"><strong style="padding-left: 10px">Anterior</strong></a>
                                    </li>
                                    <li class="<?php if ($pageno >= $total_pages) {
                                                    echo 'disabled';
                                                } ?>">
                                        <a href="<?php if ($pageno >= $total_pages) {
                                                        echo '#';
                                                    } else {
                                                        echo "?pageno=" . ($pageno + 1);
                                                    } ?>"><strong style="padding-left: 10px">Siguiente</strong></a>
                                    </li>
                                    <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Último</strong></a></li>
                                </ul>
                            </div>
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
