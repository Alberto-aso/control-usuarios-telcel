<?php
class UsuariosModel extends Query //Heredamos la clase Query
{
    private $numero_emp, $mail, $departamento, $localidad, $puesto, $nombre_emp, $clave, $region, $gerencia, $telefono, $num_emp_jefe, $fecha_password, $id; //Variables para registro del usuario

    public function __construct()
    {
        parent::__construct(); //Obtenemos el contructor de Query para el metodo
    }

    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
    /*====================================================================== CATALOGOS =========================================================================*/
    public function getCopiarUsuario() //Obtener lista de usuarios para copiar datos de la anterior base de datos
    {
        $sql = "SELECT * FROM personal_oym WHERE activo = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getLocalidades() //Obtener catalogo de Localidades
    {
        $sql = "SELECT * FROM localidad WHERE activo = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getGerencia() //Obtener catalogo de Gerencias
    {
        $sql = "SELECT * FROM gerencia WHERE activo = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getDepartamentos() //Obtener catalogo de Departamentos
    {
        $sql = "SELECT * FROM departamentos WHERE activo = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    /*====================================================================== CATALOGOS =========================================================================*
    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/

    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
    /*====================================================================== FUNCIONES =========================================================================*/
    public function getUsuario(string $usuario) //Obtener usuario en aplicacion PARA LOGIN
    {
        $sql = "SELECT u.*, r.id as id_rol, r.rol FROM users_control_usuarios u INNER JOIN roles_control_usuarios r ON u.rol_id = r.id WHERE num_empleado = '$usuario'"; //Cremaos Query de consulta
        $data = $this->select($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo
        return $data; // Retornamos la respuesta
    }

    public function getUsuario_info(string $usuario, string $clave) //Obtener info from control de Usuarios PARA LOGIN
    {
        $sql = "SELECT p.*, l.id as id_localidad, l.localidad, g.id as id_gerencia, g.gerencia, d.id as id_departamento, d.departamento FROM 
                personal p INNER JOIN localidad l ON p.localidad_id = l.id INNER JOIN gerencia g ON p.gerencia_id = g.id INNER JOIN 
                departamentos d ON p.departamento_id = d.id WHERE num_empleado='$usuario' AND password='$clave'"; //Cremaos Query de consulta

        $data = $this->select($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo
        return $data; // Retornamos la respuesta
    }

    public function num_emp_unico(int $id, int $numero_emp) //Verificacmos si el numero de empleado a actualizar no corresponde al id del empleado y si existe evitamos la actualizacion para no tene duplicados
    {
        $sql = "SELECT * FROM personal WHERE id != '$id' AND num_empleado = '$numero_emp'"; //Cremaos Query de consulta
        $data = $this->select($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo
        return $data; // Retornamos la respuesta
    }

    public function getUsuarios() //Obtener Lista de todos los usuarios
    {
        $sql = "SELECT p.*, l.id as id_localidad, l.localidad, g.id as id_gerencia, g.gerencia, d.id as id_departamento, d.departamento FROM 
        personal p INNER JOIN localidad l ON p.localidad_id = l.id INNER JOIN gerencia g ON p.gerencia_id = g.id INNER JOIN 
        departamentos d ON p.departamento_id = d.id"; //Cremaos Query de consulta
        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function modificar_usuario_out_password(int $id, string $password) //Verificar si el usuario tiene el mismo password que el de la modificacion
    {
        $sql = "SELECT * FROM personal WHERE id = '$id' AND password = '$password'"; //Cremaos Query de consulta
        $data = $this->select($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo
        return $data; // Retornamos la respuesta
    }

    public function getOneUsuario(int $num) //Obtener toda la informacion del usuario Seleccionado
    {
        $sql = "SELECT * FROM personal WHERE id = '$num'"; //Cremaos Query de consulta
        $data = $this->select($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo
        return $data; // Retornamos la respuesta
    }

    public function registrarUsuario(int $numero_emp, string $mail, string $departamento, string $localidad, string $puesto, string $nombre_emp, string $clave, int $region, int $gerencia, string $telefono, int $num_emp_jefe) //Funcion Registrar Usuario
    {
        $this->numero_emp = $numero_emp; //Guardamos la variable
        $this->mail = $mail; //Guardamos la variable
        $this->departamento = ($departamento); //Guardamos la variable
        $this->localidad = ($localidad); //Guardamos la variable
        $this->puesto = strtoupper($puesto); //Guardamos la variable
        $this->nombre_emp = strtoupper($nombre_emp); //Guardamos la variable
        $this->clave = $clave; //Guardamos la variable
        $this->region = ($region); //Guardamos la variable
        $this->gerencia = ($gerencia); //Guardamos la variable
        $this->telefono = $telefono; //Guardamos la variable
        $this->num_emp_jefe = $num_emp_jefe; //Guardamos la variable

        $fechaActual = date('Y-m-d', strtotime(' - 80 days')); //Obtenemos Fecha Actual y le restamos 80 dias para forzar cambio de password d einiciio se session
        $this->fecha_password = $fechaActual; //Guardamos la variable

        $verificar = "SELECT * FROM personal WHERE num_empleado = '$this->numero_emp'"; //Creamos el Query para verificar si existe ya un usuario registrado
        $existe = $this->select($verificar);
        if (empty($existe)) { //Aqui validamos si el usuario existe

            $sql_jefe = "SELECT * FROM personal WHERE num_empleado = '$num_emp_jefe'"; //Cremaos Query de consulta
            $data_jefe = $this->select($sql_jefe); //Mandamos la consulta al Select y la duardamos en una variable al metodo
            if (empty($data_jefe)) {
                $res = "NoJefe";
            } else {
                $sql = "INSERT INTO personal(num_empleado, mail, departamento_id, localidad_id, puesto, nombre, password, region, gerencia_id, telefono, num_emp_jefe, fecha_password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)"; //Creamos el Query para guardar el nuevo Empleado
                $datos = array($this->numero_emp, $this->mail, $this->departamento, $this->localidad, $this->puesto, $this->nombre_emp, $this->clave, $this->region, $this->gerencia, $this->telefono, $this->num_emp_jefe, $this->fecha_password); //Mandamos los datos que se guardaran
                $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save
                if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
                    $res = "ok";
                } else {
                    $res = "Error";
                }
            }
        } else {
            $res = "existe";
        }

        return $res;
    }

    public function modificarUsuario(int $numero_emp, string $mail, string $departamento, string $localidad, string $puesto, string $nombre_emp, $clave, $region, $gerencia, $telefono, $num_emp_jefe, $id) //Funcion Modificar Usuario
    {
        $this->numero_emp = $numero_emp; //Guardamos la variable
        $this->mail = $mail; //Guardamos la variable
        $this->departamento = ($departamento); //Guardamos la variable
        $this->localidad = ($localidad); //Guardamos la variable
        $this->puesto = strtoupper($puesto); //Guardamos la variable
        $this->nombre_emp = strtoupper($nombre_emp); //Guardamos la variable
        $this->clave = $clave; //Guardamos la variable
        $this->region = ($region); //Guardamos la variable
        $this->gerencia = ($gerencia); //Guardamos la variable
        $this->telefono = $telefono; //Guardamos la variable
        $this->num_emp_jefe = $num_emp_jefe; //Guardamos la variable
        $fechaActual = date('Y-m-d', strtotime(' - 80 days')); //Obtenemos Fecha Actual y le restamos 80 dias para forzar cambio de password d einiciio se session
        $this->fecha_password = $fechaActual; //Guardamos la variable
        $this->id = $id; //Guardamos la variable

        $sql_jefe = "SELECT * FROM personal WHERE num_empleado = '$num_emp_jefe'"; //Cremaos Query de consulta
        $data_jefe = $this->select($sql_jefe); //Mandamos la consulta al Select y la duardamos en una variable al metodo
        if (empty($data_jefe)) {
            $res = "NoJefe";
        } else {
            $sql = "UPDATE personal SET num_empleado = ?, mail = ?, departamento_id = ?, localidad_id = ?, puesto = ?, nombre = ?, password = ?, region = ?, gerencia_id = ?, telefono = ?, num_emp_jefe = ?, fecha_password = ? WHERE id = ?"; //Creamos el Query para guardar el nuevo Empleado
            $datos = array($this->numero_emp, $this->mail, $this->departamento, $this->localidad, $this->puesto, $this->nombre_emp, $this->clave, $this->region, $this->gerencia, $this->telefono, $this->num_emp_jefe, $this->fecha_password, $this->id); //Mandamos los datos que se guardaran
            $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save
            if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
                $res = "modificado";
            } else {
                $res = "Error";
            }
        }

        return $res;
    }

    public function modificarUsuario_Out_Password(int $numero_emp, string $mail, string $departamento, string $localidad, string $puesto, string $nombre_emp, $region, $gerencia, $telefono, $num_emp_jefe, $id) //Funcion Modificar Usuario
    {
        $this->numero_emp = $numero_emp; //Guardamos la variable
        $this->mail = $mail; //Guardamos la variable
        $this->departamento = ($departamento); //Guardamos la variable
        $this->localidad = ($localidad); //Guardamos la variable
        $this->puesto = strtoupper($puesto); //Guardamos la variable
        $this->nombre_emp = strtoupper($nombre_emp); //Guardamos la variable
        $this->region = ($region); //Guardamos la variable
        $this->gerencia = ($gerencia); //Guardamos la variable
        $this->telefono = $telefono; //Guardamos la variable
        $this->num_emp_jefe = $num_emp_jefe; //Guardamos la variable
        $this->id = $id; //Guardamos la variable

        $sql_jefe = "SELECT * FROM personal WHERE num_empleado = '$num_emp_jefe'"; //Cremaos Query de consulta
        $data_jefe = $this->select($sql_jefe); //Mandamos la consulta al Select y la duardamos en una variable al metodo
        if (empty($data_jefe)) {
            $res = "NoJefe";
        } else {
            $sql = "UPDATE personal SET num_empleado = ?, mail = ?, departamento_id = ?, localidad_id = ?, puesto = ?, nombre = ?, region = ?, gerencia_id = ?, telefono = ?, num_emp_jefe = ? WHERE id = ?"; //Creamos el Query para guardar el nuevo Empleado
            $datos = array($this->numero_emp, $this->mail, $this->departamento, $this->localidad, $this->puesto, $this->nombre_emp, $this->region, $this->gerencia, $this->telefono, $this->num_emp_jefe, $this->id); //Mandamos los datos que se guardaran
            $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save
            if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
                $res = "modificado";
            } else {
                $res = "Error";
            }
        }

        return $res;
    }

    public function editarUser(int $id) //Mandamos a traer los datos del usuario a actualizar
    {
        $sql = "SELECT * FROM personal WHERE id = '$id'"; //Creamos la consulta SQL
        $data = $this->select($sql); //Mandamos llamar el metodo select
        return $data; //Retornamos la data
    }

    public function duplicarUsuario(int $id) //Mandamos a traer los datos del usuario a duplicar
    {
        $sql = "SELECT * FROM personal_oym WHERE numero_emp = '$id'"; //Creamos la consulta SQL
        $data = $this->select($sql); //Mandamos llamar el metodo select
        return $data; //Retornamos la data
    }

    public function accionUser(int $estado, int $id) //Eliminar o Reingresar usuario
    {
        $this->id = $id; //Guardamos Id del usuario
        $this->estado = $estado; //Guardamos Id del usuario
        $sql = "UPDATE personal SET activo = ? WHERE id = ?"; //Creamos consulta sql
        $datos = array($this->estado, $this->id); //Creamos el arreglo con el Id
        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }

    /*====================================================================== FUNCIONES =========================================================================*/
    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
}
