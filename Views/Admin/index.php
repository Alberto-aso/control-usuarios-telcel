<?php include "Views/Templates/header.php"; ?>
<!--Incluimos la Vista Header-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Administrador</strong></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><strong>Home</strong></a></li>
                    <li class="breadcrumb-item active"><strong>Admin</strong></li>
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

                    <div class="row">
                        <div class="col-md-4">
                            <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------>
                            <!------------------------------------------------------------------------- FORMULARIO CONTROL_USUARIOS ------------------------------------------------------------------->
                            <div class="card border-primary mb-3" style="width: 100%;">
                                <div class="card-header" style="background-color: #030215; color:white">
                                    <strong>CONTROL USUARIOS</strong>

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label><strong>Nombre:</strong> <?php echo $_SESSION['nombre_control_usuarios'] ?> </label>
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Num.Empleado:</strong> <?php echo $_SESSION['num_empleado_control_usuarios'] ?> </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label><strong>Rol de Usuario:</strong> <?php echo $_SESSION['rol'] ?> </label>
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Puesto:</strong> <?php echo $_SESSION['puesto_control_usuarios'] ?> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="database">Selecciona aplicacion</label>
                                        <select name="database" id="database" class="form-control">
                                            <option value="users_control_usuarios">Control Usuarios</option>
                                            <option value="users_control_plantas_fijas">Control Plantas Fijas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------>
                            <!------------------------------------------------------------------------- TABLA CONTROL_USUARIOS USUARIOS CONTROL ------------------------------------------------------------------->
                            <div class="test" id="tab_control_usuarios" style="display: block;">
                                <div class="card border-primary mb-3" style="width: 100%;">
                                    <div class="card-header" style="background-color: #030215; color:white">
                                        <div class="row">
                                            <div class="col-8">
                                                <strong>APLICACION CONTROL USUARIOS</strong>
                                            </div>
                                            <div class="col-4">
                                                <button class="btn btn-light btn-sm" style="float: right;" type="button" onclick="frmAdd_control_usuario();"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="card border-primary mb-3" style="width: 100%;">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered" id="tblAdmin_Usuarios" style="width: 100%;margin-top: 5px;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 35%">Nombre</th>
                                                                <th style="width: 15%;">No.Empleado</th>
                                                                <th>Rol</th>
                                                                <th style="width: 10%;">Activo</th>
                                                                <th style="min-width: 90px;">Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="font-size: 10px;">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------>
                            <!------------------------------------------------------------------------- FORMULARIO PLANTAS FIJAS ------------------------------------------------------------------->
                            <div id="tab_control_plantas_fijas" style="display: none;">
                                <div class="card border-primary mb-3" style="width: 100%;">
                                    <div class="card-header" style="background-color: #030215; color:white">
                                        <div class="row">
                                            <div class="col-8">
                                                <strong>APLICACION PLANTAS FIJAS</strong>
                                            </div>
                                            <div class="col-4">
                                                <button class="btn btn-light btn-sm" style="float: right;" type="button" onclick="frmAdd_control_plantas_fijas();"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="card border-primary mb-3" style="width: 100%;">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered" id="tblAdmin_Plantas_Fijas" style="width: 100%;margin-top: 5px;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 35%">Nombre</th>
                                                                <th style="width: 15%;">No.Empleado</th>
                                                                <th>Rol</th>
                                                                <th style="width: 10%;">Activo</th>
                                                                <th style="min-width: 90px;">Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="font-size: 10px;">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
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

<!----------------------------------------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------- MODAL CONTROL_USUARIOS ------------------------------------------------------------------->
<div id="nuevo_usuario_control_usuarios" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #030215;">
                <h5 class="modal-title" id="title_control_usuario" id="my-modal-title" style="color: white;">Control de Usuarios - Agregar</h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white" aria-label="close" onclick="cerrarModalAdd_Control_Usuarios();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmControl_usuario">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div id="info-general">
                                <div class="form-group m-2">
                                    <input type="hidden" id="id_control_usuario" name="id_control_usuario">
                                    <label for="empleado_c_empleado">Numero de Empleado </label>
                                    <input id="empleado_c_empleado" name="empleado_c_empleado" class="form-control" type="number" placeholder="Numero de empleado">
                                </div>
                                <div class="form-group m-2">
                                    <label for="rol_id">Rol</label>
                                    <select id="rol_id" class="form-control" name="rol_id">
                                        <option value="" selected>No</option>
                                        <?php foreach ($data['roles_control_usuarios'] as $row) { ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['rol'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary" style="margin-right: 10px;" id="btnAccion_Add_control_usuario" type="button" onclick="registrarControl_Usuarios(event)">Registrar</button>
                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close" type="button" onclick="cerrarModalAdd_Control_Usuarios();">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------- MODAL CONTROL_USUARIOS ------------------------------------------------------------------->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------->

<!----------------------------------------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------- MODAL CONTROL_PLANTAS_FIJAS ------------------------------------------------------------------->
<div id="nuevo_usuario_control_plantas_fijas" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #030215;">
                <h5 class="modal-title" id="title_control_plantas_fijas" id="my-modal-title" style="color: white;">Control de Usuarios Plantas - Agregar</h5>
                <button type="button" class="close" data-dismiss="modal" style="color:white;" aria-label="Close" onclick="cerrarModalAdd_Control_Plantas_fijas();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmControl_plantas_fijas">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div id="info-general">
                                <div class="form-group m-2">
                                    <input type="hidden" id="id_control_plantas_fijas" name="id_control_plantas_fijas">
                                    <label for="empleado_c_plantas_fijas">Numero de Empleado </label>
                                    <input id="empleado_c_plantas_fijas" name="empleado_c_plantas_fijas" class="form-control" type="number" placeholder="Numero de empleado">
                                </div>
                                <div class="form-group m-2">
                                    <label for="rol_id_plantas_fijas">Rol</label>
                                    <select id="rol_id_plantas_fijas" class="form-control" name="rol_id_plantas_fijas">
                                        <option value="" selected>No</option>
                                        <?php foreach ($data['roles_control_plantas_fijas'] as $row) { ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['rol'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary" style="margin-right: 10px;" id="btnAccion_Add_control_plantas_fijas" type="button" onclick="registrarControl_Plantas_Fijas(event)">Registrar</button>
                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close" type="button" onclick="cerrarModalAdd_Control_Plantas_fijas();">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------- MODAL CONTROL_USUARIOS ------------------------------------------------------------------->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------->

<?php include "Views/Templates/footer.php"; ?>
<!--Incluimos la Vista Footer-->