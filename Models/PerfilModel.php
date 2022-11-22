<?php
class PerfilModel extends Query //Heredamos la clase Query
{
    private $id;//Variables para registro del usuario

    public function __construct()
    {
        parent::__construct(); //Obtenemos el contructor de Query para el metodo
    }

    public function getPasswordActual(int $id_usuario, string $clave) //Obtener info from control de Usuarios
    {
        $sql = "SELECT * FROM personal WHERE id='$id_usuario' AND password='$clave'"; //Cremaos Query de consulta
                
        $data = $this->select($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo
        return $data; // Retornamos la respuesta
    }

    public function getChangePassword(int $id_usuario, string $clave, string $fecha_password) //Obtener info from control de Usuarios
    {
        $this->clave = $clave; //Guardamos la variable
        $this->id = $id_usuario; //Guardamos la variable
        $this->fecha_password = $fecha_password; //Guardamos la variable

        $sql = "UPDATE personal SET password = ?, fecha_password = ? WHERE id = ?"; //Cremaos Query de consulta
        $datos = array($this->clave, $this->fecha_password, $this->id); //Mandamos los datos que se guardaran

        $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

        if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
            $res = "ok";
        } else {
            $res = "Error";
        }

        return $res;
    }
    
}
