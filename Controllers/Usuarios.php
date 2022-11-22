<?php
class Usuarios extends Controller //heredamos controller
{
    public function __construct() //Constructor iniciar session
    {
        session_start(); //Inicias la session
        parent::__construct(); //cargar el constructor de la instancia del modelo
    }

    public function index()
    {
        if (empty($_SESSION['activo_control_usuarios'])) { //Evaluamos si el usuairo ya esta autenticado
            header("location: " . base_url);
        }

        if ($_SESSION['cambio_password'] == true) { //Evaluamos si el usuairo ya esta autenticado
            header("location: " . base_url . 'Perfil');
        }

        if ($_SESSION['rol'] == 'user') { //Evaluamos si el usuairo ya esta autenticado
            header("location: " . base_url . 'Perfil');
        }

        $data['copiar_usuario'] = $this->model->getCopiarUsuario(); //Guardar Lista de Usuarios activos para copiar datos
        $data['localidades_lista'] = $this->model->getLocalidades(); //Guardar Lista Localidades
        $data['gerencias_lista'] = $this->model->getGerencia(); //Guardar Lista Localidades
        $data['departamentos_lista'] = $this->model->getDepartamentos(); //Guardar Lista Localidades

        $this->views->getView($this, "index", $data); //Cargamois la vista de Usuarios
    }

    public function listar() //Listar Usuarios en Tabla
    {
        $data = $this->model->getUsuarios(); //Obtener todos los usuarios para la tabla de Usuarios Data table
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros
            if ($data[$i]['activo'] == 1) { //Evaluamos si el usuario esta activo
                $data[$i]['activo'] = '<span style="color: green;">Activo</span>';
                $data[$i]['acciones'] = '<div>
            <button type="button" class="btn btn-primary btn-sm" onclick="btnEditarUser(' . $data[$i]['id'] . ');" title="Editar""><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-sm" onclick="btnEliminarUser(' . $data[$i]['id'] . ');" title="Eliminar""><i class="fas fa-trash-alt"></i></button>
            </div>'; //Añadimos los button a cada uno de los registros
            } else {
                $data[$i]['activo'] = '<span style="color: red;">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
            <button type="button" class="btn btn-info btn-sm" onclick="btnReingresarUser(' . $data[$i]['id'] . ');" title="Reingresar""><i class="fas fa-sign-in-alt"></i></i></button>
            </div>'; //Añadimos los button a cada uno de los registros
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }

    public function registrar() //Creamos funcion resistrar por el metodo POST
    {
        $numero_emp = $_POST['num_empleado']; //Guardamos datos
        $mail = $_POST['mail']; //Guardamos datos
        $departamento = $_POST['departamento_id']; //Guardamos datos
        $localidad = $_POST['localidad_id']; //Guardamos datos
        $puesto = $_POST['puesto']; //Guardamos datos
        $nombre_emp = $_POST['nombre_emp']; //Guardamos datos
        $clave = $_POST['clave']; //Guardamos datos
        $confirmar = $_POST['confirmar']; //Guardamos datos
        $region = $_POST['region']; //Guardamos datos
        $gerencia = $_POST['gerencia_id']; //Guardamos datos
        $telefono = $_POST['telefono']; //Guardamos datos
        $num_emp_jefe = $_POST['num_emp_jefe']; //Guardamos datos
        $id = $_POST['id']; //Guardamos datos del ID en el caso de que sea actualizacion
        $hash = hash("SHA256", $clave); //Encriptar PASSWORD Mejora requerida para los sistemas de OYM

        if (
            empty($numero_emp) | empty($mail) | empty($departamento) | empty($localidad) | empty($puesto) | empty($nombre_emp) | empty($hash) | empty($confirmar) |
            empty($region) | empty($gerencia) | empty($telefono) | empty($num_emp_jefe)
        ) { //Evaluamos que los campos esten 
            $msg = "Todos los campos son obligatorios";
        } else {

            if ($id == "") {

                if ($clave != $confirmar) { //Evaluamos que las contraseñas sean iguales

                    $msg = "Las contraseñas no coinciden";
                } else {

                    $data = $this->model->registrarUsuario($numero_emp, $mail, $departamento, $localidad, $puesto, $nombre_emp, $hash, $region, $gerencia, $telefono, $num_emp_jefe); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo usuario
                    switch ($data) { //Evaluamos que tipo de respuesta tenemos
                        case 'ok':
                            $msg = "si";
                            break;
                        case 'existe':
                            $msg = "Usuario ya Registrado"; //Mandamos mensaje de usuario registrado
                            break;
                        case 'NoJefe':
                            $msg = "Jefe no valido"; //Mandamos mensaje de usuario modificado
                            break;
                        default:
                            $msg = "Error al Ingresar Usuario"; //Error
                            break;
                    }
                }
            } else {

                if ($clave != $confirmar) { //Evaluamos que las contraseñas sean iguales
                    $msg = "Las contraseñas no coinciden";
                } else {

                    $data_num_emp_unico = $this->model->num_emp_unico($id, $numero_emp); //Verificamos si el numero de empleado ya existe y no pertenece al id del usuario actual para evitar duplicados

                    if ($data_num_emp_unico) { //Si el usuario a modificar se le actualizo el numero de empleado y ya esta registrado para otro no se permite realizar el cambio
                        $msg = "Numero de empleado ya asignado";
                    } else {

                        $data_info = $this->model->modificar_usuario_out_password($id, $clave); //almacenas la variable all data Usuarios

                        if ($data_info) { //Modificar usuario sin alterar password ya que no fue cambiado

                            $data = $this->model->modificarUsuario_Out_Password($numero_emp, $mail, $departamento, $localidad, $puesto, $nombre_emp, $region, $gerencia, $telefono, $num_emp_jefe, $id); // Mandmaos a llamar al modelo y le mandamos datos si se va a actualizar usuario
                            switch ($data) { //Evaluamos que tipo de respuesta tenemos
                                case 'modificado':
                                    $msg = "modificado"; //Mandamos mensaje de usuario modificado
                                    break;
                                case 'NoJefe':
                                    $msg = "Jefe no Valido"; //Mandamos mensaje de usuario modificado
                                    break;
                                default:
                                    $msg = "Error al Modificar Usuario"; //Error
                                    break;
                            }
                        } else {

                            $data = $this->model->modificarUsuario($numero_emp, $mail, $departamento, $localidad, $puesto, $nombre_emp, $hash, $region, $gerencia, $telefono, $num_emp_jefe, $id); // Mandmaos a llamar al modelo y le mandamos datos si se va a actualizar usuario
                            switch ($data) { //Evaluamos que tipo de respuesta tenemos
                                case 'modificado':
                                    $msg = "modificado"; //Mandamos mensaje de usuario modificado
                                    break;
                                case 'NoJefe':
                                    $msg = "Jefe no Valido"; //Mandamos mensaje de usuario modificado
                                    break;
                                default:
                                    $msg = "Error al Modificar Usuario"; //Error
                                    break;
                            }
                        }
                    }
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mandamos la respuesta
        die();
    }

    public function editar(int $id) //La funcion  recibe el id que es el numero de empleado ya que esa es la PRIMARY KEY
    {
        $data = $this->model->editarUser($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function duplicar_usuario(int $id) //La funcion  resibe el num_empleado a buscar para duplicar
    {
        $data = $this->model->duplicarUsuario($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id) //Funcion Eliminar Usuario
    {

        if ($id ==  $_SESSION['id_user_control_usuarios']) {
            $msg = "No puedes eliminarte a ti mismo";
        } else {
            $data = $this->model->accionUser(0, $id);

            if ($data == 1) {
                $msg = "ok";
            } else {
                $msg = "Error al Eliminar Usuario";
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar(int $id) //Funcion Reingresar Usuario
    {
        $data = $this->model->accionUser(1, $id);

        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al Reingresar Usuario";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function salir() //Funcion Salid e la aplicacion
    {
        //session_destroy(); Elimina todas las variables de la session incluyendo las de las demas aplicaciones 
        unset($_SESSION['activo_control_usuarios']);
        header("location: " . base_url);
    }
    public function validar() //validad LOGIN usuario
    {
        if (empty($_POST['usuario']) || empty($_POST['clave'])) { //conpruebas que los campos existan
            $msg = "Los campos estan vacios";
        } else {
            $usuario = $_POST['usuario']; //almacenas la variable usuario
            $clave = $_POST['clave']; //almacenas la variable clave

            $hash = hash("SHA256", $clave); //Crear passowrd Encriptada

            $data_user = $this->model->getUsuario($usuario); //almacenas la variable de los usuarios reistrados en la aplicacion

            if ($data_user) {

                $_SESSION['rol'] = $data_user['rol'];

                $data_info = $this->model->getUsuario_info($usuario, $hash); //almacenas la variable all data Usuarios
                if ($data_info) {
                    if (
                        $data_info['activo'] == 1 //Evaluar si el usuario esta Activo en las aplicaciones
                    ) {
                        $fechaActual = date('Y-m-d'); //Obtenemos Fecha Actual
                        $fechaUsuarioPsw = $data_info['fecha_password']; //Guardamos la fecha en que el usuario cambio por ultima vez su password

                        $date = strtotime($fechaActual); //Convertimos la fecha en formato Unix
                        $your_date = strtotime($fechaUsuarioPsw); //Convertimos la fecha en formato Unix
                        $datediff = $date - $your_date; //Sacamos la diferencia entre las dos fechas

                        $dias = $datediff / (60 * 60 * 24); //Obtenemos los dias

                        $_SESSION['id_user_control_usuarios'] = $data_info['id']; //guardas informacion en la session
                        $_SESSION['num_empleado_control_usuarios'] = $data_info['num_empleado']; //guardas informacion en la session
                        $_SESSION['nombre_control_usuarios'] = $data_info['nombre']; //guardas informacion en la session
                        $_SESSION['region_control_usuarios'] = $data_info['region']; //guardas informacion en la session
                        $_SESSION['puesto_control_usuarios'] = $data_info['puesto']; //guardas informacion en la session
                        $_SESSION['mail_control_usuarios'] = $data_info['mail']; //guardas informacion en la session
                        $_SESSION['telefono_control_usuarios'] = $data_info['telefono']; //guardas informacion en la session
                        $_SESSION['localidad_control_usuarios'] = $data_info['localidad']; //guardas informacion en la session
                        $_SESSION['gerencia_control_usuarios'] = $data_info['gerencia']; //guardas informacion en la session
                        $_SESSION['departamento_control_usuarios'] = $data_info['departamento']; //guardas informacion en la session
                        $_SESSION['num_emp_jefe_control_usuarios'] = $data_info['num_emp_jefe']; //guardas informacion en la session
                        $_SESSION['activo_control_usuarios'] = true; //guardas informacion en la session

                        $_SESSION['dias'] = $dias; //guardas informacion en la session

                        if ($dias > 60) {
                            $msg = "cambio"; // Mensaje confirmando el login del usuario    
                            $_SESSION['cambio_password'] = true; //EL usuario requiere ambio de password
                        } else {
                            $msg = "ok"; // Mensaje confirmando el login del usuario
                            $_SESSION['cambio_password'] = false; //El usuario no requiere cambio de password
                        }
                    } else {
                        $msg = "Usuario Bloqueado"; // Mensaje usuario bloqueado 
                    }
                } else {
                    $msg = "Usuario o contraseña Incorrecta"; //Mensaje los datos del usuario son incorrectos
                }
            } else {
                $msg = "Usuario no registrado en la aplicacion"; //EL usuario no esta registrado en la aplicacion
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mostrar mensaje por medio de la consola con Ñ incluida(UNICODE)
        die();
    }
}
