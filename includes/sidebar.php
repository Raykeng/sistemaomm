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

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
                <i class="icon-home menu-icon"></i>
                <span class="menu-title">INICIO</span>
            </a>
        </li>

        <?php if (!$isSupervisor) { ?>
        
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layers menu-icon"></i>
                <span class="menu-title">CURSOS</span>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="add-class.php">Agregar Curso</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage-class.php">Administrar Curso</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
                <i class="icon-people menu-icon"></i>
                <span class="menu-title">MUJERES</span>
            </a>
            <div class="collapse" id="ui-basic1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="add-students.php">Agregar Mujer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage-students.php">Administrar Mujer</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="icon-doc menu-icon"></i>
                <span class="menu-title">NOTICIAS CURSO</span>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="add-notice.php">Agregar Noticia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage-notice.php">Administrar Noticia</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth1" aria-expanded="false" aria-controls="auth1">
                <i class="icon-doc menu-icon"></i>
                <span class="menu-title">NOTICIAS ACTIVIDADES</span>
            </a>
            <div class="collapse" id="auth1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="add-public-notice.php">Agregar Noticia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage-public-notice.php">Administrar Noticias</a>
                    </li>
                </ul>
            </div>
        </li>
        
        <?php } ?>

        <li class="nav-item">
            <a class="nav-link" href="search.php">
                <i class="icon-magnifier menu-icon"></i>
                <span class="menu-title">BUSCAR MUJER</span>
            </a>
        
            <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth2" aria-expanded="false" aria-controls="auth2">
                <i class="icon-doc menu-icon"></i>
                <span class="menu-title">Reportes</span>
            </a>
            <div class="collapse" id="auth2">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="reportlistmujer.php">Reportes mujer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reportlistcurso.php">Reportes cursos</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
