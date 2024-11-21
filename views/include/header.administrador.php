<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['login']) || $_SESSION['login']['rol'] !== 'administrador') {
    header('Location: index.php');
    exit();
}
$host = "http://localhost/AlquilerCampoDeportivo";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sistema de Alquiler</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?= $host ?>/css/estilo.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
</head>

<body class="sb-nav-fixed">

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="<?= $host ?>/views/include/dashboard.administrador.php">Alquiler de Campos</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Buscar..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i><?= $_SESSION['login']['nombre'] ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Configuración</a></li>
                    <li><a class="dropdown-item" href="#!">Cambiar Contraseña</a></li>
                    <li><a class="dropdown-item" href="#!">Historial</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="<?= $host ?>/controllers/usuario.controller.php?operation=destroy">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Inicio</div>
                        <a class="nav-link" href="<?= $host ?>/views/include/dashboard.administrador.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-igloo"></i></div>
                            Panel de Control
                        </a>

                        <div class="sb-sidenav-menu-heading">Opciones</div>
                        <a class="nav-link" href="<?= $host ?>/views/administradorReserva/">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-check"></i></div>
                            Alquiler / Reserva
                        </a>
                        <a class="nav-link" href="<?= $host ?>/views/Persona/">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                            Lista de Persona
                        </a>
                        <a class="nav-link" href="<?= $host ?>/views/Complejo_Campo/">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                            Lista de Campo
                        </a>
                        <a class="nav-link" href="<?= $host ?>/views/Producto/">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                            Lista de Producto
                        </a>
                        <a class="nav-link" href="<?= $host ?>/views/Servicio/">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                            Lista de Servicio
                        </a>
                        <a class="nav-link" href="<?= $host ?>/views/AccesoSistema/">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Acceso al Sistema
                        </a>
                    </div>
                </div>

            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>