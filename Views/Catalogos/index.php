<?php include "Views/Templates/header.php"; ?>
<!--Incluimos la Vista Header-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Control de Catalogos</strong></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><strong>Home</strong></a></li>
                    <li class="breadcrumb-item active"><strong>Catalogos</strong></li>
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
                            <!----------------------------------------------------------------------------------------------------------------------------------------------------------------->
                            <!-------------------------------------------------------------------------- TABLA LOCALIDADES -------------------------------------------------------------------->
                            <div class="col-md-4">
                                <div class="card border-primary mb-3" style="width: 100%;">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>LOCALIDADES</strong>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-outline-primary btn-sm" style="float: right;" type="button" onclick="frmLocalidad();"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">Tabla de Localidades.</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="tblLocalidades" style="width: 100%;margin-top: 5px;">
                                        <thead style="background: #18212A; color: white;">
                                            <tr>
                                                <th style="width: 80%">Localidad</th>
                                                <th>Activo</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 10px;">
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-------------------------------------------------------------------------- TABLA LOCALIDADES -------------------------------------------------------------------->
                            <!----------------------------------------------------------------------------------------------------------------------------------------------------------------->

                            <!----------------------------------------------------------------------------------------------------------------------------------------------------------------->
                            <!-------------------------------------------------------------------------- TABLA DEPARTAMENTOS ------------------------------------------------------------------>
                            <div class="col-md-4">
                                <div class="card border-primary mb-3" style="width: 100%;">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>DEPARTAMENTOS</strong>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-outline-primary btn-sm" style="float: right;" type="button" onclick="frmDepartamento();"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">Tabla de Departamentos</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="tblDepartamentos" style="width: 100%;margin-top: 5px;">
                                        <thead style="background: #18212A; color: white;">
                                            <tr>
                                                <th style="width: 80%">Departamento</th>
                                                <th>Activo</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 10px;">
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-------------------------------------------------------------------------- TABLA DEPARTAMENTOS -------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------------------------------------------------------>


                            <!------------------------------------------------------------------------------------------------------------------------------------------------------------------>
                            <!---------------------------------------------------------------------------- TABLA GERENCIAS --------------------------------------------------------------------->
                            <div class="col-md-4">
                                <div class="card border-primary mb-3" style="width: 100%;">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>GERENCIAS</strong>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-outline-primary btn-sm" style="float: right;" type="button" onclick="frmGerencia();"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">Tabla de Gerancias</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="tblGerencias" style="width: 100%;margin-top: 5px;">
                                        <thead style="background: #18212A; color: white;">
                                            <tr>
                                                <th style="width: 80%">Gerencia</th>
                                                <th>Activo</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 10px;">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!---------------------------------------------------------------------------- TABLA GERENCIAS -------------------------------------------------------------------->
                            <!----------------------------------------------------------------------------------------------------------------------------------------------------------------->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>

<!----------------------------------------------------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------- modal localidad --------------------------------------------------------------------->
<div id="nuevo_localidad" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #18212a;">
                <h5 class="modal-title" id="title_localidad" id="my-modal-title" style="color: white;">nueva localidad</h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white" aria-label="close" onclick="cerrarModalLocalidad();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmLocalidad">
                    <div class="tab-content" id="pills-tabcontent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div id="info-general">
                                <div class="form-group m-2">
                                    <input type="hidden" id="id_localidad" name="id">
                                    <label for="localidad">nombre localidad</label>
                                    <input id="localidad" class="form-control" type="text" name="localidad" placeholder="nombre localidad">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary" style="margin-right: 10px;" id="btnAccion_localidad" type="button" onclick="registrarLocalidad(event)">registrar</button>
                        <button class="btn btn-danger" data-dismiss="modal" aria-label="close" type="button" onclick="cerrarModalLocalidad();">cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--------------------------------------------------------------------------- modal localidad --------------------------------------------------------------------->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------->

<!----------------------------------------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------- MODAL DEPARTAMENTOS ------------------------------------------------------------------->
<div id="nuevo_departamento" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #18212A;">
                <h5 class="modal-title" id="title_departamento" id="my-modal-title" style="color: white;">Nuevo Departamento</h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white" aria-label="close" onclick="cerrarModalDepartamento();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmDepartamento">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div id="info-general">
                                <div class="form-group m-2">
                                    <input type="hidden" id="id_departamento" name="id">
                                    <label for="departamento">Nombre Departamento</label>
                                    <input id="departamento" class="form-control" type="text" name="departamento" placeholder="Nombre Departamento">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary" style="margin-right: 10px;" id="btnAccion_departamento" type="button" onclick="registrarDepartamento(event)">Registrar</button>
                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close" type="button" onclick="cerrarModalDepartamento();">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------- MODAL DEPARTAMENTOS ------------------------------------------------------------------->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------->


<!----------------------------------------------------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------- MODAL GERENCIAS --------------------------------------------------------------------->
<div id="nuevo_gerencia" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #18212A;">
                <h5 class="modal-title" id="title_gerencia" id="my-modal-title" style="color: white;">Nueva Gerencia</h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white" aria-label="close" onclick="cerrarModalGerencia();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmGerencia">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div id="info-general">
                                <div class="form-group m-2">
                                    <input type="hidden" id="id_gerencia" name="id_gerencia">
                                    <label for="gerencia">Nombre Gerencia</label>
                                    <input id="gerencia" class="form-control" type="text" name="gerencia" placeholder="Nombre Gerencia">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary" style="margin-right: 10px;" id="btnAccion_gerencia" type="button" onclick="registrarGerencia(event)">Registrar</button>
                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close" type="button" onclick="cerrarModalGerencia();">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--------------------------------------------------------------------------  MODAL GERENCIAS --------------------------------------------------------------------->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------->


<?php include "Views/Templates/footer.php"; ?>
<!--Incluimos la Vista Footer-->