<?php
class Perfil extends Controller //heredamos controller
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
        $this->views->getView($this, "index"); //Cargamois la vista de Usuarios
    }

    public function change_password() //CHange password 
    {
        if (empty($_POST['password_actual']) || empty($_POST['password_nueva']) || empty($_POST['password_confirmar'])) { //conpruebas que los campos existan
            $msg = "Los campos estan vacios";
        } else {
            $password_actual = $_POST['password_actual']; //almacenas la variable usuario
            $password_confirmar = $_POST['password_confirmar']; //almacenas la variable clave
            $password_nueva = $_POST['password_nueva']; //almacenas la variable clave
            $id_usuario = $_SESSION['id_user_control_usuarios'];
            $password_actual_hash = hash("SHA256", $password_actual); //Crear passowrd Encriptada
            $password_nueva_hash = hash("SHA256", $password_nueva); //Crear passowrd Encriptada


            if ($password_nueva != $password_confirmar) { //Evaluamos que las contraseñas sean iguales
                $msg = "Las contraseñas no coinciden";
            } else {

                $data_info = $this->model->getPasswordActual($id_usuario, $password_actual_hash); //almacenas la variable all data Usuarios

                if ($data_info) {

                    $longitud_new_password = strlen($password_nueva);

                    if ($longitud_new_password < 7) { //Validacion de longitud de password en password 
                        $msg = "Requerimiento: longitud 7 caracteres";
                    } else if (
                        strpos($password_nueva, "!") === false && strpos($password_nueva, "@") === false && strpos($password_nueva, "#") === false &&
                        strpos($password_nueva, "$") === false && strpos($password_nueva, "%") === false && strpos($password_nueva, "^") === false && 
                        strpos($password_nueva, "&") === false && strpos($password_nueva, "*") === false && strpos($password_nueva, "(") === false && 
                        strpos($password_nueva, ")") === false && strpos($password_nueva, "-") === false && strpos($password_nueva, "_") === false &&
                        strpos($password_nueva, "=") === false && strpos($password_nueva, "+") === false && strpos($password_nueva, "[") === false &&
                        strpos($password_nueva, "]") === false && strpos($password_nueva, "{") === false && strpos($password_nueva, "}") === false &&
                        strpos($password_nueva, ";") === false && strpos($password_nueva, ":") === false && strpos($password_nueva, "'") === false && 
                        strpos($password_nueva, '"') === false && strpos($password_nueva, ",") === false && strpos($password_nueva, "<") === false &&
                        strpos($password_nueva, ".") === false && strpos($password_nueva, ">") === false && strpos($password_nueva, "/") === false &&
                        strpos($password_nueva, "?") === false

                    ) { //Validacion de caracter especial en password 
                        $msg = "Requerimiento: Caracter Especial";
                    } else if (
                        strpos($password_nueva, "1") == false && strpos($password_nueva, "2") == false && strpos($password_nueva, "2") == false
                        && strpos($password_nueva, "3") == false && strpos($password_nueva, "4") == false && strpos($password_nueva, "5") == false
                        && strpos($password_nueva, "6") == false && strpos($password_nueva, "7") == false && strpos($password_nueva, "8") == false
                        && strpos($password_nueva, "9") == false && strpos($password_nueva, "0") == false
                    ) { //Validacion de caracter numerico en password 
                        $msg = "Requerimiento Valor numerico (0-9)";
                    } else if(preg_match_all("/[A-Z]/", $password_nueva) == "" || preg_match_all("/[a-z]/", $password_nueva) == ""){
                        $msg = "Requerimiento: mayuscula y minuscula";
                    }else if($password_actual_hash == $password_nueva_hash){
                        $msg = "Error: password igual a la anterior";
                    }else{

                        $fechaActual = date('Y-m-d'); //Obtenemos Fecha Actual

                        $data_info = $this->model->getChangePassword($id_usuario, $password_nueva_hash, $fechaActual); //almacenas la variable all data Usuarios

                        if ($data_info == "ok") { //Evaluamos si la peticion se ejecuto correctamente
                            $_SESSION['cambio_password'] = false;
                            $msg = "ok"; //Mandamos mensaje de usuario modificado
                        } else {
                            $msg = "Error al Modificar Password"; //Error
                        }
                    }
                } else {
                    $msg = "Contraseña actual incorracta";
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mostrar mensaje por medio de la consola con Ñ incluida(UNICODE)
        die();
    }
}
