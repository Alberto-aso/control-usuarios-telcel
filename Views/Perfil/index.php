<?php include "Views/Templates/header.php"; ?>
<!--Incluimos la Vista Header-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Perfil</strong></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><strong>Home</strong></a></li>
                    <li class="breadcrumb-item active"><strong>Perfil</strong></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5 d-flex flex-column h-100">
                                <div class="card" style="min-height: 410px;">
                                    <div class="card-header" style="background: #030215;">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="card-title" style="color: white;">Informacion General</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label><strong>Nombre:</strong> <?php echo $_SESSION['nombre_control_usuarios'] ?> </label>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Numero de Empleado:</strong> <?php echo $_SESSION['num_empleado_control_usuarios'] ?> </label>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Region:</strong> <?php echo $_SESSION['region_control_usuarios'] ?> </label>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Puesto:</strong> <?php echo $_SESSION['puesto_control_usuarios'] ?> </label>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Rol de Usuario:</strong> <?php echo $_SESSION['rol'] ?> </label>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Mail:</strong> <?php echo $_SESSION['mail_control_usuarios'] ?> </label>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Localidad:</strong> <?php echo $_SESSION['localidad_control_usuarios'] ?> </label>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Gerencia:</strong> <?php echo $_SESSION['gerencia_control_usuarios'] ?> </label>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Departamento:</strong> <?php echo $_SESSION['departamento_control_usuarios'] ?> </label>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Numero empleado jefe:</strong> <?php echo $_SESSION['num_emp_jefe_control_usuarios'] ?> </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="card" style="min-height: 410px;">
                                    <div class="card-header" style="background: #030215;">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="card-title" style="color: white;">Cambiar Contraseña</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form id="frmChangePassword">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="password_nueva" class="form-label">Contraseña nueva</label>
                                                        <input type="password" class="form-control" id="password_nueva" name="password_nueva" placeholder="...">
                                                        <small id="emailHelp" class="form-text text-muted">Por favor ingresa tu nueva contraseña</small>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password_confirmar" class="form-label">Confirmar</label>
                                                        <input type="password" class="form-control" id="password_confirmar" name="password_confirmar" placeholder="...">
                                                        <small id="emailHelp" class="form-text text-muted">Repite tu contraseña nueva por favor</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">

                                                    <div class="form-group">
                                                        <label for="password_actual" class="form-label">Contraseña actual</label>
                                                        <input type="password" class="form-control" id="password_actual" name="password_actual" placeholder="...">
                                                        <small id="emailHelp" class="form-text text-muted">Por favor ingresa tu contraseña actual</small>
                                                    </div>

                                                    <div class="form-group" style="margin-top: 40px;">
                                                        <button class="btn btn-primary" id="btn_changePassword" type="button" onclick="registrarChangePassword(event)">Cambiar</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="text-center">
                                        <?php if ($_SESSION['cambio_password'] == false) { ?>
                                            <small id="password">Tu contraseña sigue vigente</small>
                                        <?php } else { ?>
                                            <small id="password" style="color: #F9413B;" class="form-text">Tu contraseña ya venciò</small>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>

<!-- /.modal -->
<?php include "Views/Templates/footer.php"; ?>
<!--Incluimos la Vista Footer-->