<?php

namespace src\Model;

use src\Core\Conexao;
use PDO;
use PDOException;

class EstudanteModel {


    public function busca(): array 
    {
        try {
            $comandoSQL = "SELECT * FROM estudantes";
            $stmt = Conexao::getInstance()->query($comandoSQL);
            $resultado = $stmt->fetchAll();
    
            return $resultado;
        } catch (PDOException $th) {
            die("ERRO: ". $th->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function buscaPorId(int $id): bool|array
    {
        try {
            $comandoSQL = "SELECT * FROM estudantes WHERE id={$id}";
            $stmt = Conexao::getInstance()->query($comandoSQL);
            $resultado = $stmt->fetch();
    
            return $resultado;
        } catch (PDOException $th) {
            die("ERRO: ". $th->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function atualizarEstudante(array $dados, int $id): void 
    {
        try {
            $comandoSQL = "UPDATE estudantes SET nome=?, sexo=?, classe=?, mensalidade=?, data_inicio=?, encarregado=?, telefone=?, celular=? WHERE id=?";
            $stmt = Conexao::getInstance()->prepare($comandoSQL);
            $stmt->bindValue(1, $dados['nome']);
            $stmt->bindValue(2, $dados['sexo']);
            $stmt->bindValue(3, $dados['classe']);
            $stmt->bindValue(4, $dados['mensalidade']);
            $stmt->bindValue(5, $dados['data_inicio']);
            $stmt->bindValue(6, $dados['encarregado']);
            $stmt->bindValue(7, $dados['telefone']);
            $stmt->bindValue(8, $dados['celular']);
            $stmt->bindValue(9, $id);
            
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
            $comandoSQL = "INSERT INTO estudantes (nome, sexo, classe, mensalidade, data_inicio, encarregado, telefone, celular) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = Conexao::getInstance()->prepare($comandoSQL);
            $stmt->bindValue(1, $dados['nome']);
            $stmt->bindValue(2, $dados['sexo']);
            $stmt->bindValue(3, $dados['classe']);
            $stmt->bindValue(4, $dados['mensalidade']);
            $stmt->bindValue(5, $dados['data_inicio']);
            $stmt->bindValue(6, $dados['encarregado']);
            $stmt->bindValue(7, $dados['telefone']);
            $stmt->bindValue(8, $dados['celular']);
            
            $stmt->execute();
        } catch (PDOException $er) {
            die('ERRO: '. $er->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function deletar(int $id): void 
    {
        $comandoSQL = "DELETE FROM estudantes WHERE id=?";
        $stmt = Conexao::getInstance()->prepare($comandoSQL);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }

}