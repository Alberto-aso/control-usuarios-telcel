<?php
class Admin extends Controller //heredamos controller
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

        if ($_SESSION['cambio_password'] == true) { //Evaluamos si el usuairo tiene vigente el password
            header("location: " . base_url . 'Perfil');
        }

        if ($_SESSION['rol'] != 'developer') { //Evaluamos si el usuairo ya es DELEVOPER
            header("location: " . base_url . 'Perfil');
        }

        $data['roles_control_usuarios'] = $this->model->getRoles_Control_Usuarios(); //Guardar Lista de ROLES Control Usuarios
        $data['roles_control_plantas_fijas'] = $this->model->getRoles_Control_Plantas_Fijas(); //Guardar Lista de ROLES Control Plantas Fijas
        

        $this->views->getView($this, "index", $data); //Cargamois la vista de Usuarios CON LAS VARIABLES DATA
    }

    /*****************************************************************************************************************************************************************************************************/
    /********************************************************************************CONTROL USUSUARIOS****************************************************************************************************/
    public function listarUsuarios_Control_usuarios() //Listar Localidades en Tabla
    {
        $data = $this->model->getUsuarios_Control_Usuarios(); //Obtener todos los usuarios para la tabla de Usuarios Data table
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros
            if ($data[$i]['activo'] == 1) { //Evaluamos si el usuario esta activo
                $data[$i]['activo'] = '<span style="color: green;">Activo</span>';
                $data[$i]['acciones'] = '<div>
            <button type="button" class="btn btn-primary btn-sm" onclick="btnEditarUser_Control_Usuarios(' . $data[$i]['id'] . ');" title="Editar""><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-sm" onclick="btnEliminarUser_Control_Usuarios(' . $data[$i]['id'] . ');" title="Eliminar""><i class="fas fa-trash-alt"></i></button>
            </div>'; //Añadimos los button a cada uno de los registros
            } else {
                $data[$i]['activo'] = '<span style="color: red;">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
            <button type="button" class="btn btn-info btn-sm" onclick="btnReingresarUser_Control_Usuarios(' . $data[$i]['id'] . ');" title="Reingresar""><i class="fas fa-sign-in-alt"></i></i></button>
            </div>'; //Añadimos los button a cada uno de los registros
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }

    public function registrar_control_usuarios() //Creamos funcion resistrar por el metodo POST
    {
        $numero_emp = $_POST['empleado_c_empleado']; //Guardamos datos
        $rol_id = $_POST['rol_id']; //Guardamos datos
        $id = $_POST['id_control_usuario']; //Guardamos datos del ID en el caso de que sea actualizacion

        if (
            empty($numero_emp) | empty($rol_id)
        ) { //Evaluamos que los campos esten 
            $msg = "Todos los campos son obligatorios";
        } else {
            if ($id == "") {

                $data = $this->model->registrarUsuario_control_usuarios($numero_emp, $rol_id); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo usuario

                if ($data == "ok") { //Evaluamos si la peticion se ejecuto correctamente
                    $msg = "si";
                } else if ($data == "existe") {
                    $msg = "Usuario ya Registrado"; //Mandamos mensaje de usuario registrado
                } else if ($data == "No existe") {
                    $msg = "No.Empleado no registrado en DB"; //Mandamos mensaje de usuario No registrado en la base de datos
                } else {
                    $msg = "Error al Ingresar Usuario"; //Error
                }
            } else {

                $data = $this->model->modificarUsuario_control_usuarios($numero_emp, $rol_id, $id); // Mandmaos a llamar al modelo y le mandamos datos si se va a actualizar usuario

                if ($data == "modificado") { //Evaluamos si la peticion se ejecuto correctamente
                    $msg = "modificado"; //Mandamos mensaje de usuario modificado
                } else {
                    $msg = "Error al Modificar Usuario"; //Error
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mandamos la respuesta
        die();
    }

    public function editar_control_usuarios(int $id) //La funcion  recibe el id que es el numero de empleado ya que esa es la PRIMARY KEY
    {
        $data = $this->model->editarUser_control_usuarios($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar_control_usuarios(int $id) //Funcion Eliminar Usuario
    {
        $data = $this->model->accionUser_control_usuarios(0, $id);

        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al Eliminar Usuario";
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar_control_usuarios(int $id) //Funcion Reingresar Usuario
    {
        $data = $this->model->accionUser_control_usuarios(1, $id);

        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al Reingresar Usuario";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    /********************************************************************************CONTROL USUSUARIOS****************************************************************************************************/
    /*****************************************************************************************************************************************************************************************************/

    /*****************************************************************************************************************************************************************************************************/
    /********************************************************************************CONTROL PLANTAS FIJAS****************************************************************************************************/
    public function listarUsuarios_Control_plantas_fijas() //Listar Localidades en Tabla
    {
        $data = $this->model->getUsuarios_Control_Plantas_Fijas(); //Obtener todos los usuarios para la tabla de Usuarios Data table
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros
            if ($data[$i]['activo'] == 1) { //Evaluamos si el usuario esta activo
                $data[$i]['activo'] = '<span style="color: green;">Activo</span>';
                $data[$i]['acciones'] = '<div>
            <button type="button" class="btn btn-primary btn-sm" onclick="btnEditarUser_Control_Plantas_Fijas(' . $data[$i]['id'] . ');" title="Editar""><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-sm" onclick="btnEliminarUser_Control_Plantas_Fijas(' . $data[$i]['id'] . ');" title="Eliminar""><i class="fas fa-trash-alt"></i></button>
            </div>'; //Añadimos los button a cada uno de los registros
            } else {
                $data[$i]['activo'] = '<span style="color: red;">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
            <button type="button" class="btn btn-info btn-sm" onclick="btnReingresarUser_Control_Plantas_Fijas(' . $data[$i]['id'] . ');" title="Reingresar""><i class="fas fa-sign-in-alt"></i></i></button>
            </div>'; //Añadimos los button a cada uno de los registros
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data 
        die();
    }

    public function registrar_control_plantas_fijas() //Creamos funcion resistrar por el metodo POST
    {
        $numero_emp = $_POST['empleado_c_plantas_fijas']; //Guardamos datos
        $rol_id = $_POST['rol_id_plantas_fijas']; //Guardamos datos
        $id = $_POST['id_control_plantas_fijas']; //Guardamos datos del ID en el caso de que sea actualizacion

        if (
            empty($numero_emp) | empty($rol_id)
        ) { //Evaluamos que los campos esten 
            $msg = "Todos los campos son obligatorios";
        } else {
            if ($id == "") {

                $data = $this->model->registrarUsuario_control_plantas_fijas($numero_emp, $rol_id); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo usuario

                if ($data == "ok") { //Evaluamos si la peticion se ejecuto correctamente
                    $msg = "si";
                } else if ($data == "existe") {
                    $msg = "Usuario ya Registrado"; //Mandamos mensaje de usuario registrado
                } else if ($data == "No existe") {
                    $msg = "No.Empleado no registrado en DB"; //Mandamos mensaje de usuario No registrado en la base de datos
                } else {
                    $msg = "Error al Ingresar Usuario"; //Error
                }
            } else {

                $data = $this->model->modificarUsuario_control_plantas_fijas($numero_emp, $rol_id, $id); // Mandmaos a llamar al modelo y le mandamos datos si se va a actualizar usuario

                if ($data == "modificado") { //Evaluamos si la peticion se ejecuto correctamente
                    $msg = "modificado"; //Mandamos mensaje de usuario modificado
                } else {
                    $msg = "Error al Modificar Usuario"; //Error
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mandamos la respuesta
        die();
    }

    public function eliminar_control_plantas_fijas(int $id) //Funcion Eliminar Usuario
    {
        $data = $this->model->accionUser_control_plantas_fijas(0, $id);

        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al Eliminar Usuario";
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar_control_plantas_fijas(int $id) //Funcion Reingresar Usuario
    {
        $data = $this->model->accionUser_control_plantas_fijas(1, $id);

        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al Reingresar Usuario";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar_control_plantas_fijas(int $id) //La funcion  recibe el id que es el numero de empleado ya que esa es la PRIMARY KEY
    {
        $data = $this->model->editarUser_control_plantas_fijas($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    /********************************************************************************CONTROL PLANTAS FIJAS****************************************************************************************************/
    /*****************************************************************************************************************************************************************************************************/
}
