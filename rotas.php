<?php

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use src\Core\Helpers;

try {
    
    SimpleRouter::setDefaultNamespace('src\Controller');

    // URL's para o SITE
    SimpleRouter::get('/tsony', 'SiteController@index');
    SimpleRouter::post('tsony/contacte/', 'Contato@contacte');
    SimpleRouter::get("tsony/sobre/", 'SiteController@sobre');
    SimpleRouter::get('tsony/register/', 'SiteController@register');
    
    // Login para Dashboard e logout do dashboard
    SimpleRouter::post("tsony/auth/", 'LoginController@validar');
    SimpleRouter::post("tsony/logout/", 'Logout@realizarLogout');

    
    // URL's PARA O DASHBOARD
    SimpleRouter::group(['namespace' => 'Admin'], function () {

        // ADMIN dashboards
        SimpleRouter::match(['get','post'],'tsony/admin/','ControllerAdmin@admin');

        // ADMIN ESTUDANTES
        SimpleRouter::get('tsony/admin/estudantes/listar', 'EstudanteController@listar');
        SimpleRouter::match(['get','post'],'tsony/admin/estudantes/cadastrar', 'EstudanteController@cadastrar');
        SimpleRouter::match(['get','post'],'tsony/admin/estudantes/editar/{id}', 'EstudanteController@editar');
        SimpleRouter::get('tsony/admin/estudantes/deletar/{id}', 'EstudanteController@deletar');

        // ADMIN MENSALIDADES
        SimpleRouter::get('tsony/admin/mensalidades/listar', 'MensalidadeController@listar');
        SimpleRouter::match(['get','post'],'tsony/admin/mensalidades/cadastrar', 'MensalidadeController@cadastrar');
        SimpleRouter::match(['get','post'],'tsony/admin/mensalidades/editar/{id}', 'MensalidadeController@editar');
        SimpleRouter::get('tsony/admin/mensalidades/deletar/{id}', 'MensalidadeController@deletar');

        // ADMIN USUARIOS
        SimpleRouter::get('tsony/admin/usuarios/listar', 'UsuarioController@listar');
        SimpleRouter::match(['get','post'],'tsony/admin/usuarios/cadastrar', 'UsuarioController@cadastrar');
        SimpleRouter::match(['get','post'],'tsony/admin/usuarios/editar/{id}', 'UsuarioController@editar');
        SimpleRouter::get('tsony/admin/usuarios/deletar/{id}', 'UsuarioController@deletar');

        // ADMIN PROFESSORES
        SimpleRouter::get('tsony/admin/professores/listar', 'ProfessorController@listar');
        SimpleRouter::match(['get','post'],'tsony/admin/professores/cadastrar', 'ProfessorController@cadastrar');
        SimpleRouter::match(['get','post'],'tsony/admin/professores/editar/{id}', 'ProfessorController@editar');
        SimpleRouter::get('tsony/admin/professores/deletar/{id}', 'ProfessorController@deletar');

        // ADMIN USUARIOS
        SimpleRouter::get('tsony/admin/cursos/listar', 'CursoController@listar');
        SimpleRouter::match(['get','post'],'tsony/admin/cursos/cadastrar', 'CursoController@cadastrar');
        SimpleRouter::match(['get','post'],'tsony/admin/cursos/editar/{id}', 'CursoController@editar');
        SimpleRouter::get('tsony/admin/cursos/deletar/{id}', 'CursoController@deletar');
    });

    SimpleRouter::start();

} catch (NotFoundHttpException $e) {
    if (!Helpers::localhost()) {
        Helpers::redirecionar('404');
    } else {
        echo $e->getMessage();
    }
}