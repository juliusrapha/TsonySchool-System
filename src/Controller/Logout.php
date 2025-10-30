<?php

class Logout { 

    public function realizarLogout() {
        // Definindo o header como application/json
        header("Content-Type: application/json");

        // Certifica-se de que a sessão está ativa antes de realizar qualquer operação com os dados de sessão.
        session_start(); 

        // Limpa todas as variáveis de sessão
        session_unset();
        
        // Destroi completamente a sessão atual no servidor.
        session_destroy(); 

        // mandando os dados para javascript
        echo json_encode(["success" => true]); 

        // fechando...
        exit;
    }

}


// Chama a função ao receber o pedido de logout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $logout = new Logout();
    $logout->realizarLogout();
}