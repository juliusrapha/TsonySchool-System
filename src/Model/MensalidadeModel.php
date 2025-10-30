<?php

namespace src\Model;

use src\Core\Conexao;
use PDO;
use PDOException;

class MensalidadeModel {

    public function busca(): array|bool
    {
        try {
            $comandoSQL = "SELECT * FROM mensalidades";
            $stmt = Conexao::getInstance()->query($comandoSQL);
            $resultado = $stmt->fetchAll();
            return $resultado;    
        } catch (PDOException $e) {
            die('ERROR: '. $e->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function buscaPorId(int $id): array|bool 
    {
        try {
            $comandoSQL = "SELECT * FROM mensalidades WHERE id=?";
            $stmt = Conexao::getInstance()->prepare($comandoSQL);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $err) {
            die("ERRO: " . $err->getMessage());
        } finally {
            $stmt = null;
        }
        
    }

    public function atualizarMensalidade(array $dados, int $id): void 
    {
        $comandoSQL = "UPDATE mensalidades SET valor=?, mes=?, data_pagamento=?, id_estudante=? WHERE id=?";
        $stmt = Conexao::getInstance()->prepare($comandoSQL);
        $stmt->bindValue(1, $dados['valor']);
        $stmt->bindValue(2, $dados['mes']);
        $stmt->bindValue(3, $dados['data_pagamento']);
        $stmt->bindValue(4, $dados['id_estudante']);
        $stmt->bindValue(5, $id);
        
        $stmt->execute();
    }

    public function cadastrar(array $dados): void
    {
        $comandoSQL = "INSERT INTO mensalidades (valor, mes, data_pagamento, id_estudante) VALUES (?,?,?,?)";
        $stmt = Conexao::getInstance()->prepare($comandoSQL);
        $stmt->bindValue(1, $dados['valor']);
        $stmt->bindValue(2, $dados['mes']);
        $stmt->bindValue(3, $dados['data_pagamento']);
        $stmt->bindValue(4, $dados['id_estudante']);
        
        $stmt->execute();
    }

    public function deletar(int $id): void 
    {
        $comandoSQL = "DELETE FROM mensalidades WHERE id=?";
        $stmt = Conexao::getInstance()->prepare($comandoSQL);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}