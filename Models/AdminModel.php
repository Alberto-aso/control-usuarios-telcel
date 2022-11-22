<?php
class AdminModel extends Query //Heredamos la clase Query
{
    private $num_empleado, $rol_id, $id; //Variables para registro del usuario

    public function __construct()
    {
        parent::__construct(); //Obtenemos el contructor de Query para el metodo
    }


    /*****************************************************************************************************************************************************************************************************/
    /********************************************************************************CONTROL USUSUARIOS****************************************************************************************************/
    public function getRoles_Control_Usuarios() //Obtener lista de roles en aplicacion de control de usuarios
    {
        $sql = "SELECT * FROM roles_control_usuarios WHERE activo = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function editarUser_control_usuarios(int $id) //Mandamos a traer los datos del usuario a actualizar
    {
        $sql = "SELECT * FROM users_control_usuarios WHERE id = '$id'"; //Creamos la consulta SQL
        $data = $this->select($sql); //Mandamos llamar el metodo select
        return $data; //Retornamos la data
    }

    public function registrarUsuario_control_usuarios(int $numero_emp, int $rol_id) //Funcion Registrar Usuario
    {
        $this->num_empleado = $numero_emp; //Guardamos la variable
        $this->rol_id = $rol_id; //Guardamos la variable

        $existeUsuario = "SELECT * FROM personal WHERE num_empleado = '$this->num_empleado'"; //Creamos el Query para verificar si existe ya un usuario registrado
        $NoExiste = $this->select($existeUsuario);

        if (empty($NoExiste)) {
            $res = "No existe";
        } else {
            $verificar = "SELECT * FROM users_control_usuarios WHERE num_empleado = '$this->num_empleado'"; //Creamos el Query para verificar si existe ya un usuario registrado
            $existe = $this->select($verificar);

            if (empty($existe)) { //Aqui validamos si el usuario existe

                $sql = "INSERT INTO users_control_usuarios(num_empleado, rol_id) VALUES (?, ?)"; //Creamos el Query para guardar el nuevo Empleado
                $datos = array($this->num_empleado, $this->rol_id); //Mandamos los datos que se guardaran

                $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

                if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
                    $res = "ok";
                } else {
                    $res = "Error";
                }
            } else {
                $res = "existe";
            }
        }

        return $res;
    }

    public function modificarUsuario_control_usuarios(int $numero_emp, int $rol_id, int $id) //Funcion Modificar Usuario
    {
        $this->num_empleado = $numero_emp; //Guardamos la variable
        $this->rol_id = $rol_id; //Guardamos la variable

        $this->id = $id; //Guardamos la variable

        $sql = "UPDATE users_control_usuarios SET rol_id = ? WHERE id = ?"; //Creamos el Query para guardar el nuevo Empleado
        $datos = array($this->rol_id, $this->id); //Mandamos los datos que se guardaran

        $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

        if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
            $res = "modificado";
        } else {
            $res = "Error";
        }

        return $res;
    }

    public function getUsuarios_Control_Usuarios() //Obtener Lista de todos los Usuarios registrados enla aplicacion de Control de Usuarios
    {
        $sql = "SELECT ucu.*, p.nombre, r.id as id_rol, r.rol FROM users_control_usuarios ucu INNER JOIN personal p ON p.num_empleado = ucu.num_empleado INNER JOIN roles_control_usuarios r ON r.id = ucu.rol_id"; //Cremaos Query de consulta
        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }
    
   
    public function accionUser_control_usuarios(int $estado, int $id) //Eliminar o Reingresar usuario
    {
        $this->id = $id; //Guardamos Id del usuario
        $this->estado = $estado; //Guardamos Id del usuario
        $sql = "UPDATE users_control_usuarios SET activo = ? WHERE id = ?"; //Creamos consulta sql
        $datos = array($this->estado, $this->id); //Creamos el arreglo con el Id
        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }
    /********************************************************************************CONTROL USUSUARIOS****************************************************************************************************/
    /*****************************************************************************************************************************************************************************************************/

    /*****************************************************************************************************************************************************************************************************/
    /********************************************************************************CONTROL USUSUARIOS****************************************************************************************************/
    public function getRoles_Control_Plantas_Fijas() //Obtener lista de roles en aplicacion de Plantas Fijas
    {
        $sql = "SELECT * FROM roles_plantas_fijas WHERE activo = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getUsuarios_Control_Plantas_Fijas() //Obtener Lista de todos los Usuarios registrados enla aplicacion de Control de Usuarios
    {
        $sql = "SELECT ucu.*, p.nombre, r.id as id_rol, r.rol FROM users_plantas_fijas ucu INNER JOIN personal p ON p.num_empleado = ucu.num_empleado INNER JOIN roles_plantas_fijas r ON r.id = ucu.rol_id"; //Cremaos Query de consulta
        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function editarUser_control_plantas_fijas(int $id) //Mandamos a traer los datos del usuario a actualizar
    {
        $sql = "SELECT * FROM users_plantas_fijas WHERE id = '$id'"; //Creamos la consulta SQL
        $data = $this->select($sql); //Mandamos llamar el metodo select
        return $data; //Retornamos la data
    }

    public function registrarUsuario_control_plantas_fijas(int $numero_emp, int $rol_id) //Funcion Registrar Usuario
    {
        $this->num_empleado = $numero_emp; //Guardamos la variable
        $this->rol_id = $rol_id; //Guardamos la variable

        $existeUsuario = "SELECT * FROM personal WHERE num_empleado = '$this->num_empleado'"; //Creamos el Query para verificar si existe ya un usuario registrado
        $NoExiste = $this->select($existeUsuario);

        if (empty($NoExiste)) {
            $res = "No existe";
        } else {
            $verificar = "SELECT * FROM users_plantas_fijas WHERE num_empleado = '$this->num_empleado'"; //Creamos el Query para verificar si existe ya un usuario registrado
            $existe = $this->select($verificar);

            if (empty($existe)) { //Aqui validamos si el usuario existe

                $sql = "INSERT INTO users_plantas_fijas(num_empleado, rol_id) VALUES (?, ?)"; //Creamos el Query para guardar el nuevo Empleado
                $datos = array($this->num_empleado, $this->rol_id); //Mandamos los datos que se guardaran

                $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

                if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
                    $res = "ok";
                } else {
                    $res = "Error";
                }
            } else {
                $res = "existe";
            }
        }

        return $res;
    }

    public function modificarUsuario_control_plantas_fijas(int $numero_emp, int $rol_id, int $id) //Funcion Modificar Usuario
    {
        $this->num_empleado = $numero_emp; //Guardamos la variable
        $this->rol_id = $rol_id; //Guardamos la variable

        $this->id = $id; //Guardamos la variable

        $sql = "UPDATE users_plantas_fijas SET rol_id = ? WHERE id = ?"; //Creamos el Query para guardar el nuevo Empleado
        $datos = array($this->rol_id, $this->id); //Mandamos los datos que se guardaran

        $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

        if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
            $res = "modificado";
        } else {
            $res = "Error";
        }

        return $res;
    }
    public function accionUser_control_plantas_fijas(int $estado, int $id) //Eliminar o Reingresar usuario
    {
        $this->id = $id; //Guardamos Id del usuario
        $this->estado = $estado; //Guardamos Id del usuario
        $sql = "UPDATE users_plantas_fijas SET activo = ? WHERE id = ?"; //Creamos consulta sql
        $datos = array($this->estado, $this->id); //Creamos el arreglo con el Id
        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }
    /********************************************************************************CONTROL USUSUARIOS****************************************************************************************************/
    /*****************************************************************************************************************************************************************************************************/
}