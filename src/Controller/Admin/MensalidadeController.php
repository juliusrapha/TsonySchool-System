<?php

namespace src\Controller\Admin;

use src\Core\Helpers;
use src\Core\TemplateController;
use src\Model\MensalidadeModel;
use src\Controller\Admin\EstudanteController;
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

class MensalidadeController extends TemplateController {
    

    public function __construct() 
    {
        parent::__construct('templates/admin');
    }

    public function listar(): void
    {
        $mensalidades = (new MensalidadeModel())->busca();

        echo $this->template->renderizar('listaMensalidades.html',[
            'mensalidades' => $mensalidades,
            'user' => $GLOBALS["user"]
        ]);
    }

    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $estudantes = (new EstudanteModel())->busca();

        if (isset($dados)) {
            (new MensalidadeModel())->cadastrar($dados);
            Helpers::redirecionar('admin/mensalidades/listar');
        } else {
            echo $this->template->renderizar('cadastroMensalidade.html',[
                'estudantes' => $estudantes,
                'user' => $GLOBALS["user"]
            ]);
        }
    }

    public function editar(int $id): void
    {
        $mensalidade = (new MensalidadeModel())->buscaPorId($id);
        $estudantes = (new EstudanteModel())->busca();

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (isset($dados)) {
            (new MensalidadeModel())->atualizarMensalidade($dados, $id);
            Helpers::redirecionar('admin/mensalidades/listar');
        }
        echo $this->template->renderizar('editarMensalidade.html',[
            'mensal' => $mensalidade,
            'estudantes' => $estudantes,
            'user' => $GLOBALS["user"]
        ]);
    }
    
    public function deletar(int $id) {
        if (isset($id)) {
            (new MensalidadeModel())->deletar($id);
            Helpers::redirecionar('admin/mensalidades/listar');
        }
    }
    
}