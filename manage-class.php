<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit;
}

// Código para eliminación
if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = "DELETE FROM tblclass WHERE ID=:rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_INT);
    if ($query->execute()) {
        echo "<script>alert('Datos eliminados exitosamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar los datos');</script>";
    }
    echo "<script>window.location.href = 'manage-class.php';</script>";
}
?>

<!-- partial:partials/_navbar.html -->
<?php include_once('includes/header.php'); ?>
<div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <?php include_once('includes/sidebar.php'); ?>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Administrar Curso </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Oficina de La Mujer</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Administrar Curso</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex align-items-center mb-4">
                                <h4 class="card-title mb-sm-0">Cursos</h4>
                            </div>
                            <div class="table-responsive border rounded p-1">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="font-weight-bold">No.</th>
                                            <th class="font-weight-bold">Nombre del Curso</th>
                                            <th class="font-weight-bold">Sección</th>
                                            <th class="font-weight-bold">Fecha de Registro</th>
                                            <th class="font-weight-bold">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Manejo de paginación
                                        $pageno = isset($_GET['pageno']) ? intval($_GET['pageno']) : 1;
                                        $no_of_records_per_page = 15;
                                        $offset = ($pageno - 1) * $no_of_records_per_page;

                                        $ret = "SELECT COUNT(*) AS total FROM tblclass";
                                        $query1 = $dbh->prepare($ret);
                                        $query1->execute();
                                        $row = $query1->fetch(PDO::FETCH_ASSOC);
                                        $total_rows = $row['total'];
                                        $total_pages = ceil($total_rows / $no_of_records_per_page);

                                        $sql = "SELECT * FROM tblclass LIMIT :offset, :limit";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
                                        $query->bindParam(':limit', $no_of_records_per_page, PDO::PARAM_INT);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt = 1 + $offset;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $row) {
                                        ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($row->ClassName); ?></td>
                                                    <td><?php echo htmlentities($row->Section); ?></td>
                                                    <td><?php echo htmlentities($row->CreationDate); ?></td>
                                                    <td>
                                                        <a href="edit-class-detail.php?editid=<?php echo htmlentities($row->ID); ?>" class="btn btn-primary btn-sm"><i class="icon-eye"></i></a>
                                                        <a href="manage-class.php?delid=<?php echo htmlentities($row->ID); ?>" onclick="return confirm('¿Realmente deseas eliminar este registro?');" class="btn btn-danger btn-sm"><i class="icon-trash"></i></a>
                                                    </td>
                                                </tr>
                                        <?php
                                                $cnt++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>No se encontraron registros</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div align="left">
                                <ul class="pagination">
                                    <li><a href="?pageno=1"><strong>Primero</strong></a></li>
                                    <li class="<?php if ($pageno <= 1) echo 'disabled'; ?>">
                                        <a href="<?php if ($pageno > 1) echo "?pageno=" . ($pageno - 1); ?>"><strong>Anterior</strong></a>
                                    </li>
                                    <li class="<?php if ($pageno >= $total_pages) echo 'disabled'; ?>">
                                        <a href="<?php if ($pageno < $total_pages) echo "?pageno=" . ($pageno + 1); ?>"><strong>Siguiente</strong></a>
                                    </li>
                                    <li><a href="?pageno=<?php echo $total_pages; ?>"><strong>Último</strong></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('includes/footer.php'); ?>
    </div>
</div>
