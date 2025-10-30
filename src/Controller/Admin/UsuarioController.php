<?php

namespace src\Controller\Admin;

use src\Core\TemplateController;
use src\Model\UsuarioModel;
use src\Core\Helpers;

session_start();

global $userLogged;

if (isset($_SESSION["usuario"])) {
    $userLogged = [
        "nome" => $_SESSION["usuario"]["nome"],
        "email" => $_SESSION["usuario"]["email"],
        "tipo" => $_SESSION["usuario"]["tipo"]
    ];
} else {
    Helpers::redirecionar('');
}

class UsuarioController extends TemplateController {

    public function __construct() 
    {
        parent::__construct('templates/admin');
    }

    public function listar(): void 
    {
        $usuarios = (new UsuarioModel())->busca();

        echo $this->template->renderizar('listaUsuarios.html',[
            'usuarios' => $usuarios,
            'user' => $GLOBALS["userLogged"]
        ]);
    }

    public function cadastrar(): void 
    {

        $usuario = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($usuario)) {
            (new UsuarioModel())->cadastrar($usuario);
            Helpers::redirecionar('admin/usuarios/listar');
        } else {
            echo $this->template->renderizar('cadastroUsuario.html',[
                'user' => $GLOBALS["userLogged"]
            ]);
        }

        
    }

    /**
     * 
     */
    public function editar(int $id): void 
    {
        
        $user = (new UsuarioModel())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if(isset($dados)) {
            (new UsuarioModel())->atualizarUsuario($dados, $id);
            Helpers::redirecionar('admin/usuarios/listar');
        }

        echo $this->template->renderizar('editarUsuario.html',[
            'user' => $user,
            'userLogged' => $GLOBALS["userLogged"]
        ]);
    }
    
    public function deletar(int $id): void
    {
        
        if (isset($id)) {
            (new UsuarioModel())->deletar($id);
            Helpers::redirecionar('admin/usuarios/listar');
        }
    }
    
}
