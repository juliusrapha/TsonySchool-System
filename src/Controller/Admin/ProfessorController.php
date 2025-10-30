<?php

namespace src\Controller\Admin;

use src\Core\TemplateController;
use src\Model\ProfessorModel;
use src\Core\Helpers;

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

class ProfessorController extends TemplateController {

    public function __construct() 
    {
        parent::__construct('templates/admin');
    }

    public function listar(): void 
    {
        $profs = (new ProfessorModel())->busca();

        echo $this->template->renderizar('listaProfessores.html',[
            'profs' => $profs,
            'user' => $GLOBALS["user"]
        ]);
    }

    public function cadastrar(): void 
    {

        $professor = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($professor)) {
            (new ProfessorModel())->cadastrar($professor);
            Helpers::redirecionar('admin/professores/listar');
        } else {
            echo $this->template->renderizar('cadastroProfessor.html',[
                'user' => $GLOBALS["user"]
            ]);
        }

        
    }

    /**
     * 
     */
    public function editar(int $id): void 
    {
        
        $prof = (new ProfessorModel())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if(isset($dados)) {
            (new ProfessorModel())->atualizarProfessor($dados, $id);
            Helpers::redirecionar('admin/professores/listar');
        }

        echo $this->template->renderizar('editarProfessor.html',[
            'prof' => $prof,
            'user' => $GLOBALS["user"]
        ]);
    }
    
    public function deletar(int $id): void
    {
        
        if (isset($id)) {
            (new ProfessorModel())->deletar($id);
            Helpers::redirecionar('admin/professores/listar');
        }
    }

}