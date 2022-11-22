<?php include "Views/Templates/header.php"; ?>
<!--Incluimos la Vista Header-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Usuarios</strong></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><strong>Home</strong></a></li>
                    <li class="breadcrumb-item active"><strong>Usuarios</strong></li>
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
                    <div class="card-header" style="background: #030215;">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title" style="color: white;">Tabla de Usuarios</h3>
                            <button class="btn btn-light btn-sm float-end" type="button" onclick="frmUsuario();" title="Nuevo Registro">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tblUsuarios" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.Emp</th>
                                    <th>Nombre</th>
                                    <th>Departamento</th>
                                    <th>Puesto</th>
                                    <th>Localidad</th>
                                    <th>Activo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 11px;">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>

<!-- /.modal Para Registrar o Actualizar Usuario-->
<div class="modal fade" id="nuevo_usuario">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #030215">
                <h4 class="modal-title" style="color:white" id="title">Nuevo Usuario</h4>
                <button type="button" class="close" data-dismiss="modal" style="color: white" aria-label="close" onclick="cerrarmodalusuario();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmUsuario">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group m-2">
                                <input type="hidden" id="id" name="id">
                                <label for="num_empleado">Numero de Empleado</label>
                                <br>
                                <!--Label del usuario a Actualizar-->
                                <input id="num_empleado" class="form-control" type="number" readonly="readonly" name="num_empleado" placeholder="Numero de Empleado">
                            </div>
                            <div class="form-group m-2">
                                <label for="mail">Mail</label>
                                <input id="mail" class="form-control" type="text" name="mail" placeholder="Mail">
                            </div>
                            <div class="form-group m-2">
                                <label for="departamento_id">Departamento</label>
                                <select id="departamento_id" class="form-control" name="departamento_id">
                                    <option value="" selected>No</option>
                                    <?php foreach ($data['departamentos_lista'] as $row) { ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['departamento'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group m-2">
                                <label for="localidad_id">Localidad</label>
                                <select id="localidad_id" class="form-control" name="localidad_id">
                                    <option value="" selected>No</option>
                                    <?php foreach ($data['localidades_lista'] as $row) { ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['localidad'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group m-2">
                                <label for="puesto">Puesto</label>
                                <input id="puesto" class="form-control" type="text" name="puesto" placeholder="Puesto">
                            </div>
                            <div class="form-group m-2">
                                <label for="num_emp_jefe">Numero de emplado Jefe</label>
                                <input id="num_emp_jefe" class="form-control" type="number" name="num_emp_jefe" placeholder="Numero de empleado Jefe">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group m-2">
                                <label for="nombre_emp">Nombre</label>
                                <input id="nombre_emp" class="form-control" type="text" name="nombre_emp" placeholder="Nombre del Usuario">
                            </div>
                            <div class="row" id="claves">
                                <div class="col-md-6">
                                    <div class="form-group mr-2">
                                        <label for="clave">Clave</label>
                                        <input id="clave" class="form-control" type="password" name="clave" placeholder="Clave">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="confirmar">Confirmar</label>
                                        <input id="confirmar" class="form-control" type="password" name="confirmar" placeholder="Confirmar">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <label for="region">Region</label>
                                <input id="region" class="form-control" type="number" name="region" placeholder="Region">
                            </div>
                            <div class="form-group m-2">
                                <label for="gerencia_id">Gerencia</label>
                                <select id="gerencia_id" class="form-control" name="gerencia_id">
                                    <option value="" selected>No</option>
                                    <?php foreach ($data['gerencias_lista'] as $row) { ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['gerencia'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group m-2">
                                <label for="telefono">Telefono</label>
                                <input id="telefono" class="form-control" type="number" name="telefono" placeholder="Telefono">
                            </div>
                            <div class="form-group m-2">
                                <label for="d_p_1">Duplicar Usuario</label>
                                <select id="copiar_datos_usuario" class="form-control" name="copiar_datos_usuario">
                                    <option value="" selected>No</option>
                                    <?php foreach ($data['copiar_usuario'] as $row) { ?>
                                        <option value="<?php echo $row['numero_emp'] ?>"><?php echo $row['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarModalUsuario();">Close</button>
                <button type="button" class="btn btn-primary" style="background: #030215" id="btn_nuevo_usuario" onclick="registrarUser(event)">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php include "Views/Templates/footer.php"; ?>
<!--Incluimos la Vista Footer-->