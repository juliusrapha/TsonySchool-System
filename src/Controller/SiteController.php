<?php

namespace src\Controller;

use src\Core\TemplateController;
use src\Model\ProfessorModel;
use src\Core\Helpers;



class SiteController extends TemplateController {

    public function __construct() 
    {
        parent::__construct('templates/site/views');
    }

    public function index(): void
    {
        $teachers = (new ProfessorModel())->busca();

        echo $this->template->renderizar('index.html', [
            'profs' => $teachers,
        ]);
    }

    public function sobre(): void
    {
        echo $this->template->renderizar('sobre.html', []);
    }

    /**
     * 
     */
    public function register(): void
    {
        echo $this->template->renderizar('register.html', []);
    }

    
}