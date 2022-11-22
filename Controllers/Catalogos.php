<?php
class Catalogos extends Controller //heredamos controller
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
        $this->views->getView($this, "index"); //Cargamois la vista de Usuarios
    }

    //========================================================================================================//
    //=========================================== Controller Localidades =====================================//
    public function listarLocalidades() //Listar Localidades en Tabla
    {
        $data = $this->model->getLocalidades(); //Obtener todos las localidades para la tabla de Localidades Data table
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros
            if ($data[$i]['activo'] == 1) { //Evaluamos si el registro esta activo
                $data[$i]['activo'] = '<span style="color: green;">Activo</span>';
            } else {
                $data[$i]['activo'] = '<span style="color: red;">Inactivo</span>';
            }
            $data[$i]['acciones'] = '<div>
            <button type="button" class="btn btn-primary btn-sm" onclick="btnEditarLocalidad(' . $data[$i]['id'] . ');" title="Editar""><i class="fas fa-edit"></i></button>
            </div>'; //Añadimos los button a cada uno de los registros
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }

    public function registrarLocalidad() //Creamos funcion resistrar por el metodo POST
    {
        $id = $_POST['id']; //Guardamos datos del ID en el caso de que sea actualizacion
        $localidad = strval($_POST['localidad']); //Guardamos datos

        if (
            empty($localidad)
        ) { //Evaluamos que los campos esten 
            $msg = "Todos los campos son obligatorios";
        } else {
            if ($id == "") {

                    $data = $this->model->registrarLocalidad($localidad); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo localidad

                    if ($data == "ok") { //Evaluamos si la peticion se ejecuto correctamente
                        $msg = "si";
                    } else if ($data == "existe") {
                        $msg = "Localidad ya Registrada"; //Mandamos mensaje de localidad registrado
                    } else {
                        $msg = "Error al Ingresar Localidad"; //Error
                    }


            } else {
                    $data = $this->model->modificarLocalidad($localidad, $id); // Mandmaos a llamar al modelo y le mandamos datos si se va a actualizar Localidad

                    if ($data == "modificado") { //Evaluamos si la peticion se ejecuto correctamente
                        $msg = "modificado"; //Mandamos mensaje de usuario modificado
                    } else {
                        $msg = "Error al Modificar Localidad"; //Error
                    }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mandamos la respuesta
        die();
    }

    public function editarLocalidad(int $id) //La funcion  recibe el id que es el numero de empleado ya que esa es la PRIMARY KEY
    {
        $data = $this->model->editarLocalidad($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //=========================================== Controller Localidades =====================================//
    //========================================================================================================//






    //========================================================================================================//
    //=========================================== Controller Departamentos =====================================//
    public function listarDepartamentos() //Listar Departamentos en Tabla
    {
        $data = $this->model->getDepartamentos(); //Obtener todos los Departamentos para la tabla de Departamentos Data table
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros
            if ($data[$i]['activo'] == 1) { //Evaluamos si el registro esta activo
                $data[$i]['activo'] = '<span style="color: green;">Activo</span>';
            } else {
                $data[$i]['activo'] = '<span style="color: red;">Inactivo</span>';
            }
            $data[$i]['acciones'] = '<div>
            <button type="button" class="btn btn-primary btn-sm" onclick="btnEditarDepartamento(' . $data[$i]['id'] . ');" title="Editar""><i class="fas fa-edit"></i></button>
            </div>'; //Añadimos los button a cada uno de los registros
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }

    public function registrarDepartamento() //Creamos funcion resistrar por el metodo POST
    {
        $id = $_POST['id']; //Guardamos datos del ID en el caso de que sea actualizacion
        $departamento = strval($_POST['departamento']); //Guardamos datos

        if (
            empty($departamento)
        ) { //Evaluamos que los campos esten 
            $msg = "Todos los campos son obligatorios";
        } else {
            if ($id == "") {

                    $data = $this->model->registrarDepartamento($departamento); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo departamento

                    if ($data == "ok") { //Evaluamos si la peticion se ejecuto correctamente
                        $msg = "si";
                    } else if ($data == "existe") {
                        $msg = "Departamento ya Registrado"; //Mandamos mensaje de departamento registrado
                    } else {
                        $msg = "Error al Ingresar Departamento"; //Error
                    }


            } else {
                    $data = $this->model->modificarDepartamento($departamento, $id); // Mandmaos a llamar al modelo y le mandamos datos si se va a actualizar Departamento

                    if ($data == "modificado") { //Evaluamos si la peticion se ejecuto correctamente
                        $msg = "modificado"; //Mandamos mensaje de usuario modificado
                    } else {
                        $msg = "Error al Modificar Departamento"; //Error
                    }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mandamos la respuesta
        die();
    }

    public function editarDepartamento(int $id) //La funcion  recibe el id que es el numero de empleado ya que esa es la PRIMARY KEY
    {
        $data = $this->model->editarDepartamento($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //=========================================== Controller Departamentos =====================================//
    //========================================================================================================//






    //========================================================================================================//
    //=========================================== Controller Gerencias =====================================//
    public function listarGerencias() //Listar Gerencias en Tabla
    {
        $data = $this->model->getGerencias(); //Obtener todos los Gerencias para la tabla de Gerencias Data table
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros
            if ($data[$i]['activo'] == 1) { //Evaluamos si el registro esta activo
                $data[$i]['activo'] = '<span style="color: green;">Activo</span>';
            } else {
                $data[$i]['activo'] = '<span style="color: red;">Inactivo</span>';
            }
            $data[$i]['acciones'] = '<div>
            <button type="button" class="btn btn-primary btn-sm" onclick="btnEditarDepartamento(' . $data[$i]['id'] . ');" title="Editar""><i class="fas fa-edit"></i></button>
            </div>'; //Añadimos los button a cada uno de los registros
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }

    public function registrarGerencia() //Creamos funcion resistrar por el metodo POST
    {
        $id = $_POST['id_gerencia']; //Guardamos datos del ID en el caso de que sea actualizacion
        $gerencia = strval($_POST['gerencia']); //Guardamos datos

        if (
            empty($gerencia)
        ) { //Evaluamos que los campos esten 
            $msg = "Todos los campos son obligatorios";
        } else {
            if ($id == "") {

                    $data = $this->model->registrarGerencia($gerencia); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo departamento

                    if ($data == "ok") { //Evaluamos si la peticion se ejecuto correctamente
                        $msg = "si";
                    } else if ($data == "existe") {
                        $msg = "Gerencia ya Registrada"; //Mandamos mensaje de gerencia registrada
                    } else {
                        $msg = "Error al Ingresar Gerencia"; //Error
                    }


            } else {
                    $data = $this->model->modificarGerencia($gerencia, $id); // Mandmaos a llamar al modelo y le mandamos datos si se va a actualizar Gerencia

                    if ($data == "modificado") { //Evaluamos si la peticion se ejecuto correctamente
                        $msg = "modificado"; //Mandamos mensaje de gerencia modificado
                    } else {
                        $msg = "Error al Modificar Gerencia"; //Error
                    }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mandamos la respuesta
        die();
    }

    public function editarGerencia(int $id) //La funcion  recibe el id que es el id Gerencia ya que esa es la PRIMARY KEY
    {
        $data = $this->model->editarGerencia($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //=========================================== Controller Gerencias =====================================//
    //========================================================================================================//

}
