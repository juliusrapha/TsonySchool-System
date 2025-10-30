<?php

namespace src\Controller\Admin;

use src\Core\Helpers;
use src\Core\TemplateController;
use src\Model\UsuarioModel;

session_start();

class ControllerAdmin extends TemplateController {

    
    public function __construct() 
    {
        parent::__construct('templates/admin');
    }

    public function admin() {

        if (isset($_SESSION["usuario"])) {
            $user = [
                "nome" => $_SESSION["usuario"]["nome"],
                "email" => $_SESSION["usuario"]["email"],
                "tipo" => $_SESSION["usuario"]["tipo"]
            ];
    
            echo $this->template->renderizar('index.html', [
                'user' => $user
            ]);
        } else {
            Helpers::redirecionar('');
        }
    }

    
}