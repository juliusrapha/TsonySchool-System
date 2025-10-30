<?php

namespace src\Model;

use src\Core\Conexao;
use PDO;
use PDOException;

class ProfessorModel {
    
    public function busca(): array|bool 
    {
        try {
            $comandoSQL = "SELECT * FROM professores";
            $stmt = Conexao::getInstance()->query($comandoSQL);
            $resultado = $stmt->fetchAll();
    
            return $resultado;
        } catch (PDOException $th) {
            die("ERRO: " . $th->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function buscaPorId(int $id): bool|array 
    {
        try {
            $comandoSQL = "SELECT * FROM professores WHERE id=?";
            $stmt = Conexao::getInstance()->prepare($comandoSQL);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $resultado;
        } catch (PDOException $th) {
            die("ERRO: " . $th->getMessage());
        } finally {
            $stmt = null;
        }
    }

    
    public function atualizarProfessor(array $dados, int $id): void 
    {
        try {
            $comandoSQL = "UPDATE professores SET nome=?, especialidade=?, descricao=? WHERE id=?";
            $stmt = Conexao::getInstance()->prepare($comandoSQL);
            $stmt->bindValue(1, $dados['nome']);
            $stmt->bindValue(2, $dados['especialidade']);
            $stmt->bindValue(3, $dados['descricao']);
            $stmt->bindValue(4, $id);
            
            $stmt->execute();
        } catch (PDOException $th) {
            die("ERRO: ". $th->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function cadastrar(array $dados): void
    {
        try {
            $comandoSQL = "INSERT INTO professores (nome, especialidade, descricao) VALUES (?,?,?)";
            $stmt = Conexao::getInstance()->prepare($comandoSQL);
            $stmt->bindValue(1, $dados['nome']);
            $stmt->bindValue(2, $dados['especialidade']);
            $stmt->bindValue(3, $dados['descricao']);
            
            $stmt->execute();
        } catch (PDOException $th) {
            die("ERRO: " . $th->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function deletar(int $id): void 
    {
        try {
            $comandoSQL = "DELETE FROM professores WHERE id=?";
            $stmt = Conexao::getInstance()->prepare($comandoSQL);
            $stmt->bindValue(1, $id);
            $stmt->execute();
        } catch (PDOException $th) {
            die('ERRO: ' . $th->getMessage());
        } finally {
            $stmt = null;
        }
    }
    
}