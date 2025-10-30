<?php

namespace src\Controller\Admin;

use src\Model\ProfessorModel;
use src\Core\TemplateController;
use src\Core\Helpers;
use src\Model\CursoModel;

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

class CursoController extends TemplateController {


    public function __construct() 
    {
        parent::__construct('templates/admin');
    }

    /**
     * 
     */
    public function listar(): void 
    {
        $cursos = (new CursoModel())->busca();

        echo $this->template->renderizar('listaCursos.html',[
            'cursos' => $cursos,
            'user' => $GLOBALS["user"]
        ]);
    }

    /**
     * 
     */
    public function cadastrar(): void 
    {

        $profs = (new ProfessorModel())->busca();
        $curso = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($curso)) {
            (new CursoModel())->cadastrar($curso);
            Helpers::redirecionar('admin/cursos/listar');
        } else {
            echo $this->template->renderizar('cadastroCurso.html',[
                'profs' => $profs, 
                'user' => $GLOBALS["user"]
            ]);
        }

        
    }

    /**
     * 
     */
    public function editar(int $id): void 
    {
        $profs = (new ProfessorModel())->busca();
        $curso = (new CursoModel())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if(isset($dados)) {
            (new CursoModel())->atualizarCurso($dados, $id);
            Helpers::redirecionar('admin/cursos/listar');
        }

        echo $this->template->renderizar('editarCurso.html',[
            'curso' => $curso,
            'profs' => $profs,
            'user' => $GLOBALS["user"]
        ]);
    }
    
    public function deletar(int $id): void
    {
        
        if (isset($id)) {
            (new CursoModel())->deletar($id);
            Helpers::redirecionar('admin/cursos/listar');
        }
    }
    
}
