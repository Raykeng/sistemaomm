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
        $sql = "DELETE FROM tblstudent WHERE ID=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Datos eliminados');</script>";
        echo "<script>window.location.href = 'manage-students.php'</script>";
    }
?>

<?php include_once('includes/header.php');?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_sidebar.html -->
  <?php include_once('includes/sidebar.php');?>
  <!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Buscar Mujer </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Tablero</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Buscar Mujer</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form method="post">
                <div class="form-group">
                  <strong>Buscar Mujer:</strong>
                  <input id="searchdata" type="text" name="searchdata" required="true" class="form-control" placeholder="Buscar por DPI o Nombre ">
                </div>
                <button type="submit" class="btn btn-primary" name="search" id="submit">Buscar</button>
              </form>
              <div class="d-sm-flex align-items-center mb-4">
                <?php
                if(isset($_POST['search'])) { 
                  $sdata=$_POST['searchdata'];
                  ?>
                  <h4 align="center">Infromación encontrada de  "<?php echo $sdata;?>" en la tabla de registros</h4>
              </div>
              <div class="table-responsive border rounded p-1">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="font-weight-bold">Nº</th>
                      <th class="font-weight-bold">DPI </th>
                      <th class="font-weight-bold">Curso</th>
                      <th class="font-weight-bold">Nombre</th>
                      <th class="font-weight-bold">Correo</th>
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
                    $no_of_records_per_page = 5;
                    $offset = ($pageno-1) * $no_of_records_per_page;
                    $ret = "SELECT ID FROM tblstudent";
                    $query1 = $dbh -> prepare($ret);
                    $query1->execute();
                    $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                    $total_rows=$query1->rowCount();
                    $total_pages = ceil($total_rows / $no_of_records_per_page);
                    $sql="SELECT tblstudent.StuID,tblstudent.ID as sid,tblstudent.StudentName,tblstudent.StudentEmail,tblstudent.DateofAdmission,tblclass.ClassName,tblclass.Section 
                          FROM tblstudent 
                          JOIN tblclass ON tblclass.ID=tblstudent.StudentClass 
                          WHERE tblstudent.StuID LIKE :sdata OR tblstudent.StudentName LIKE :sdata 
                          LIMIT $offset, $no_of_records_per_page";
                    $query = $dbh -> prepare($sql);
                    $query->bindValue(':sdata', "%$sdata%", PDO::PARAM_STR);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);

                    $cnt=1;
                    if($query->rowCount() > 0) {
                      foreach($results as $row) {
                    ?>   
                    <tr>
                      <td><?php echo htmlentities($cnt);?></td>
                      <td><?php echo htmlentities($row->StuID);?></td>
                      <td><?php echo htmlentities($row->ClassName);?> <?php echo htmlentities($row->Section);?></td>
                      <td><?php echo htmlentities($row->StudentName);?></td>
                      <td><?php echo htmlentities($row->StudentEmail);?></td>
                      <td><?php echo htmlentities($row->DateofAdmission);?></td>
                      <td>
                        <div><a href="edit-student-detail.php?editid=<?php echo htmlentities ($row->sid);?>" class="btn btn-primary btn-sm"><i class="icon-eye"></i></a>
                          <a href="manage-students.php?delid=<?php echo ($row->sid);?>" onclick="return confirm('¿Realmente quieres eliminarlo?');"class="btn btn-danger btn-sm"> <i class="icon-trash"></i></a></div>
                      </td> 
                    </tr>
                    <?php 
                        $cnt=$cnt+1;
                      }
                    } else { 
                    ?>
                    <tr>
                      <td colspan="8"> No se encontraron registros contra esta búsqueda</td>
                    </tr>
                    <?php } }?>
                  </tbody>
                </table>
              </div>
              <div align="left">
                <ul class="pagination">
                  <li><a href="?pageno=1"><strong>Primero></strong></a></li>
                  <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                    <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><strong style="padding-left: 10px">Anterior></strong></a>
                  </li>
                  <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                    <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><strong style="padding-left: 10px">Siguiente></strong></a>
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
    <?php include_once('includes/footer.php');?>
    <!-- partial -->
  </div>
  <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<?php } ?>
