<?php
//Las variables de DB se encuentran en Config.php
class Conexion
{
    private $conect; //Variable Conexion al servidor de control de veivulos para la tabla de usuarios 192.3.202.100
    public function __construct()
    {
        $pdo = "mysql:host=" . host . ";dbname=" . db . ";charset=utf8"; // Conexion a base de datos
        try {
            $this->conect = new PDO($pdo, user, password); //Enviar Credenciales a la conexion
            $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Atributos
        } catch (PDOException $err) {
            echo "Error en la conexion DB" . $err->getMessage();
        }
    }
    public function conect()
    {
        return $this->conect; //Retornamos la conexion
    }
}
