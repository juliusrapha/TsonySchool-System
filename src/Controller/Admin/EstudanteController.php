<?php

namespace src\Controller\Admin;

use src\Core\Helpers;
use src\Core\TemplateController;
use src\Model\EstudanteModel;

session_start();

global $user;

if (isset($_SESSION["usuario"])) {
    $user = [
        "nome" => $_SESSION["usuario"]["nome"],
        "email" => $_SESSION["usuario"]["email"],
        "tipo" => $_SESSION["usuario"]["tipo"]
    ];
} else {
    Helpers::redirecionar('');
}

class EstudanteController extends TemplateController {
    
    public function __construct() 
    {
        parent::__construct('templates/admin');
    }

    /**
     * Metodo listar Estudantes
     */
    public function listar(): void
    {
        $estudantes = (new EstudanteModel())->busca();

        echo $this->template->renderizar('listaEstudantes.html',[
            'estudantes' => $estudantes,
            'user' => $GLOBALS["user"]
        ]);
    }

    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($dados)) {
            (new EstudanteModel())->cadastrar($dados);
            Helpers::redirecionar('admin/estudantes/listar');
        }

        echo $this->template->renderizar('cadastroEstudante.html',[
            'user' => $GLOBALS["user"]
        ]);
    }

    public function editar(int $id): void
    {
        $estudante = (new EstudanteModel())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($dados)) {
            (new EstudanteModel())->atualizarEstudante($dados, $id);
            Helpers::redirecionar('admin/estudantes/listar');
        }

        echo $this->template->renderizar('editarEstudante.html',[
            'estudante' => $estudante,
            'user' => $GLOBALS["user"]
        ]);
    }
    
    public function deletar(int $id) {
        if (isset($id)) {
            (new EstudanteModel())->deletar($id);
            Helpers::redirecionar('admin/estudantes/listar');
        }
    }

}