<?php

namespace src\Model;

use src\Core\Conexao;
use PDO;
use PDOException;

class CursoModel {
    
    public function busca(): array|bool 
    {
        try {
            $comandoSQL = "SELECT * FROM cursos";
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
            $comandoSQL = "SELECT * FROM cursos WHERE id_curso=?";
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

    
    public function atualizarCurso(array $dados, int $id): void 
    {
        try {
            $comandoSQL = "UPDATE cursos SET nome=?, nivel=?, info=?, tipo=?, carga=?, duracao=?, id_professor=? WHERE id_curso=?";
            $stmt = Conexao::getInstance()->prepare($comandoSQL);
            $stmt->bindValue(1, $dados['nome']);
            $stmt->bindValue(2, $dados['nivel']);
            $stmt->bindValue(3, $dados['info']);
            $stmt->bindValue(4, $dados['tipo']);
            $stmt->bindValue(5, $dados['carga']);
            $stmt->bindValue(6, $dados['duracao']);
            $stmt->bindValue(7, $dados['id_professor']);
            $stmt->bindValue(8, $id);
            
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
            $comandoSQL = "INSERT INTO cursos (nome, nivel, info, tipo, carga, duracao, id_professor) VALUES (?,?,?,?,?,?,?)";
            $stmt = Conexao::getInstance()->prepare($comandoSQL);
            $stmt->bindValue(1, $dados['nome']);
            $stmt->bindValue(2, $dados['nivel']);
            $stmt->bindValue(3, $dados['info']);
            $stmt->bindValue(4, $dados['tipo']);
            $stmt->bindValue(5, $dados['carga']);
            $stmt->bindValue(6, $dados['duracao']);
            $stmt->bindValue(7, $dados['id_professor']);
            
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
            $comandoSQL = "DELETE FROM cursos WHERE id_curso=?";
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