<?php

namespace src\Model;

use Error;
use src\Core\Conexao;
use PDO;
use PDOException;

class UsuarioModel {



    public function validarUsuario(string $email, $senha): array 
    {
        $user = [
            "nome" => null,
            "email" => false,
            "password" => false,
            "tipo" => null
        ];

        try {
            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = Conexao::getInstance()->prepare($sql);
            $stmt->bindValue(1, $email);
            $stmt->execute();

            // Verificar se o email existe no banco
            if ($stmt->rowCount() > 0) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                var_dump($usuario); 

                // Comparar a senha (lembrando de usar password_verify se a senha estiver hashada)
                if ($senha == $usuario['senha']) {
                    $user["email"] = true;
                    $user["password"] = true;
                    $user["nome"] = $usuario["nome"];
                    $user["tipo"] = $usuario["tipo"];
                } else {
                    $user["email"] = true;
                    $user["password"] = false;
                }
            } else {
                $user["email"] = false;
                $user["password"] = false;
            }
        } catch (PDOException $e) {
            die('ERRO: ' . $e->getMessage());
        }
        return $user;
    }

    /**
     * 
     */
    public function busca(): array 
    {
        try {
            $comandoSQL = "SELECT * FROM usuarios";
            $stmt = Conexao::getInstance()->query($comandoSQL);
            $resultado = $stmt->fetchAll();

            return $resultado;

        } catch (PDOException $e) {
            die('ERRO: '. $e->getMessage());
        } finally {
            if (isset($stmt)) {
                $stmt = null;
            }
        }
        
    }

    /**
     * 
     */
    public function buscaPorId(int $id): array 
    {
        try {
            $comandoSQL = "SELECT * FROM usuarios WHERE id=?";
            $stmt = Conexao::getInstance()->prepare($comandoSQL);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $err) {
            die('ERRO: ' . $err->getMessage());
        }
    }

    public function atualizarUsuario(array $dados, int $id): void 
    {
        $comandoSQL = "UPDATE usuarios SET nome=?, email=?, senha=?, tipo=? WHERE id=?";
        $stmt = Conexao::getInstance()->prepare($comandoSQL);
        
        $stmt->bindValue(1, $dados['nome']);
        $stmt->bindValue(2, $dados['email']);
        $stmt->bindValue(3, $dados['senha']);
        $stmt->bindValue(4, $dados['tipo']);
        $stmt->bindValue(5, $id);
        
        $stmt->execute();
    }

    public function cadastrar(array $dados): void
    {
        $comandoSQL = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?,?,?,?)";
        $stmt = Conexao::getInstance()->prepare($comandoSQL);
        $stmt->bindValue(1, $dados['nome']);
        $stmt->bindValue(2, $dados['email']);
        $stmt->bindValue(3, $dados['senha']);
        $stmt->bindValue(4, $dados['tipo']);
        
        $stmt->execute();
    }

    public function deletar(int $id): void 
    {
        $comandoSQL = "DELETE FROM usuarios WHERE id=?";
        $stmt = Conexao::getInstance()->prepare($comandoSQL);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}


