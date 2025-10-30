<?php

namespace src\Controller;

use src\Model\UsuarioModel;
use src\Core\Helpers;
use src\Core\Conexao;
use PDOException;
use PDO;

class LoginController {
    
    
    public function validar(): void
    {
        session_start();

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $email = $dados["email"];
        $senha = $dados["password"];

        header('Content-Type: application/json');
        try {
            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = Conexao::getInstance()->prepare($sql);
            $stmt->bindValue(1, $email);
            $stmt->execute();

            // Verificar se o email existe no banco
            if ($stmt->rowCount() > 0) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($senha == $usuario['senha']) {
                    $_SESSION["usuario"] = $usuario;
                    echo json_encode(["success" => true, "message" => "logado com sucesso!"]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Senha incorreta!']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Email incorreto']);
            }
            exit; //impede que o codigo execute uma segunda vez 
        } catch (PDOException $e) {
            die('ERRO: ' . $e->getMessage());
        }
        exit; //impede que o codigo execute uma segunda vez 
    }
}


// Verifique se o método foi chamado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crie uma instância do controlador e chame o método
    $controller = new LoginController();
    $controller->validar();
}