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

    // Manejar la adición de un nuevo administrador
    if (isset($_POST['submit'])) {
        $AName = $_POST['adminname'];
        $mobno = $_POST['mobilenumber'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = hash('sha512', $_POST['password']); // Encriptar la contraseña con SHA-512
        $roleid = $_POST['role']; // Obtener el rol seleccionado
        
        $sql = "INSERT INTO tbladmin (AdminName, UserName, MobileNumber, Email, Password, RoleID) VALUES (:adminname, :username, :mobilenumber, :email, :password, :roleid)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':adminname', $AName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobilenumber', $mobno, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':roleid', $roleid, PDO::PARAM_INT);
        $query->execute();

        echo '<script>alert("New admin has been added successfully")</script>';
        echo "<script>window.location.href ='new-admin.php'</script>";
    }

    // Obtener roles para el dropdown
    $rolesQuery = "SELECT * FROM tblroles";
    $rolesStmt = $dbh->prepare($rolesQuery);
    $rolesStmt->execute();
    $roles = $rolesStmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Admin</title>
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
</head>
<body>
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php'); ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">Nuevo Administrador</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"></a>Formulario de Registro</li>
                            <li class="breadcrumb-item active" aria-current="page">Nuevo Administrador</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center;">Agregar Nuevo Administrador</h4>
                                <form class="forms-sample" method="post">
                                    <div class="form-group">
                                        <label for="adminname">Nombre Administrador</label>
                                        <input type="text" name="adminname" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Nombre de Usuario</label>
                                        <input type="text" name="username" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobilenumber">Numero de Contacto</label>
                                        <input type="text" name="mobilenumber" class="form-control" maxlength="10" required pattern="[0-9]+">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Correo Electronico</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Contraseña</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Rol</label>
                                        <select name="role" class="form-control" required>
                                            <?php foreach ($roles as $role) { ?>
                                                <option value="<?php echo htmlentities($role->RoleID); ?>"><?php echo htmlentities($role->RoleName); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Agregar Administrador</button>
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
</body>
</html>
<?php } ?>
