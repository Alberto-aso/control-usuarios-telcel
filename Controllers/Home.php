<?php
class Home extends Controller
{
    public function __construct()
    {
        session_start();
        if (!empty($_SESSION['activo_control_usuarios'])) {
            header("location: ". base_url . "Usuarios");
        }
        parent::__construct();
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
}
