<?php
class CatalogosModel extends Query //Heredamos la clase Query
{
    private $localidad, $id_localidad, $departamento, $id_departamento, $gerencia, $id_gerencia;//Variables para registro del usuario

    public function __construct()
    {
        parent::__construct(); //Obtenemos el contructor de Query para el metodo
    }

    //======================================================================================//
    //===================================== MODEL LOCALIDAD ================================//
    public function getLocalidades() //Obtener Lista de todos las Localidades
    {
        $sql = "SELECT * FROM localidad"; //Cremaos Query de consulta
        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function registrarLocalidad(string $localidad) //Funcion Registrar Localidad
    {
        $this->localidad = strtoupper($localidad); //Guardamos la variable

        $verificar = "SELECT * FROM localidad WHERE localidad = '$this->localidad'"; //Creamos el Query para verificar si existe la localidad registrado
        $existe = $this->select($verificar);

        if (empty($existe)) { //Aqui validamos si la localidad existe

            $sql = "INSERT INTO localidad(localidad) VALUES (?)"; //Creamos el Query para guardar la nueva localidad
            $datos = array($this->localidad); //Mandamos los datos que se guardaran

            $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

            if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
                $res = "ok";
            } else {
                $res = "Error";
            }
        } else {
            $res = "existe";
        }

        return $res;
    }

    public function modificarLocalidad(string $localidad, int $id) //Funcion Modificar Localidad
    {
        $this->localidad = strtoupper($localidad); //Guardamos la variable

        $this->id_localidad = $id; //Guardamos la variable

        $sql = "UPDATE localidad SET localidad = ? WHERE id = ?"; //Creamos el Query para guardar la nueva Localidad
        $datos = array($this->localidad, $this->id_localidad); //Mandamos los datos que se guardaran

        $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

        if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
            $res = "modificado";
        } else {
            $res = "Error";
        }

        return $res;
    }

    public function editarLocalidad(int $id) //Mandamos a traer los datos de la Localidad a actualizar
    {
        $sql = "SELECT * FROM localidad WHERE id = '$id'"; //Creamos la consulta SQL
        $data = $this->select($sql); //Mandamos llamar el metodo select
        return $data; //Retornamos la data
    }
    //===================================== MODEL LOCALIDAD ================================//
    //======================================================================================//





    //======================================================================================//
    //=================================== MODEL DEPARTAMENTOS ==============================//
    public function getDepartamentos() //Obtener Lista de todos los Departamentos
    {
        $sql = "SELECT * FROM departamentos"; //Cremaos Query de consulta
        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function registrarDepartamento(string $departamento) //Funcion Registrar Departamento
    {
        $this->departamento = strtoupper($departamento); //Guardamos la variable

        $verificar = "SELECT * FROM departamentos WHERE departamento = '$this->departamento'"; //Creamos el Query para verificar si existe el departamento registrado
        $existe = $this->select($verificar);

        if (empty($existe)) { //Aqui validamos si la localidad existe

            $sql = "INSERT INTO departamentos(departamento) VALUES (?)"; //Creamos el Query para guardar el nuevo departamento
            $datos = array($this->departamento); //Mandamos los datos que se guardaran

            $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

            if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
                $res = "ok";
            } else {
                $res = "Error";
            }
        } else {
            $res = "existe";
        }

        return $res;
    }

    public function modificarDepartamento(string $departamento, int $id) //Funcion Modificar Localidad
    {
        $this->departamento = strtoupper($departamento); //Guardamos la variable

        $this->id_departamento = $id; //Guardamos la variable

        $sql = "UPDATE departamentos SET departamento = ? WHERE id = ?"; //Creamos el Query para guardar la Modificacion del Departamento
        $datos = array($this->departamento, $this->id_departamento); //Mandamos los datos que se guardaran

        $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

        if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
            $res = "modificado";
        } else {
            $res = "Error";
        }

        return $res;
    }

    public function editarDepartamento(int $id) //Mandamos a traer los datos de la Departamento a actualizar
    {
        $sql = "SELECT * FROM departamentos WHERE id = '$id'"; //Creamos la consulta SQL
        $data = $this->select($sql); //Mandamos llamar el metodo select
        return $data; //Retornamos la data
    }
    //=================================== MODEL DEPARTAMENTOS ==============================//
    //======================================================================================//




    
    //======================================================================================//
    //===================================== MODEL GERENCIA ================================//
    public function getGerencias() //Obtener Lista de todos los Departamentos
    {
        $sql = "SELECT * FROM gerencia"; //Cremaos Query de consulta
        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function registrarGerencia(string $gerencia) //Funcion Registrar Gerencia
    {
        $this->gerencia = strtoupper($gerencia); //Guardamos la variable

        $verificar = "SELECT * FROM gerencia WHERE gerencia = '$this->gerencia'"; //Creamos el Query para verificar si existe el gerencia registrada
        $existe = $this->select($verificar);

        if (empty($existe)) { //Aqui validamos si la gerencia existe

            $sql = "INSERT INTO gerencia(gerencia) VALUES (?)"; //Creamos el Query para guardar el nuevo gerencia
            $datos = array($this->gerencia); //Mandamos los datos que se guardaran

            $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

            if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
                $res = "ok";
            } else {
                $res = "Error";
            }
        } else {
            $res = "existe";
        }

        return $res;
    }

    public function modificarGerencia(string $gerencia, int $id) //Funcion Modificar Gerencia
    {
        $this->gerencia = strtoupper($gerencia); //Guardamos la variable

        $this->id_gerencia = $id; //Guardamos la variable

        $sql = "UPDATE gerencia SET gerencia = ? WHERE id = ?"; //Creamos el Query para guardar la Modificacion del Gerencia
        $datos = array($this->gerencia, $this->id_gerencia); //Mandamos los datos que se guardaran

        $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

        if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
            $res = "modificado";
        } else {
            $res = "Error";
        }

        return $res;
    }

    public function editarGerencis(int $id) //Mandamos a traer los datos de la Gerencia a actualizar
    {
        $sql = "SELECT * FROM gerencia WHERE id = '$id'"; //Creamos la consulta SQL
        $data = $this->select($sql); //Mandamos llamar el metodo select
        return $data; //Retornamos la data
    }
    //===================================== MODEL GERENCIA ================================//
    //======================================================================================//
}
