<?php

namespace src\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Contato {

    /**
     * 
     */
    public function contacte(): void {
        
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Recebendo dados do formulario
        $nome = $dados['nome'];
        $email= $dados['email'];
        $mensagem = $dados['mensagem'];

        header('Content-Type: application/json');

        if (isset($nome) && isset($email) && isset($mensagem)) {

            // true para habilitar o disparo de Exception
            $mail = new PHPMailer(true); 

            try {
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();

                //configs para se autenticar no SMTP
                $mail->Host         = "smtp.gmail.com";
                $mail->SMTPAuth     = true;
                $mail->Username     = "clarkluthor380@gmail.com";
                $mail->Password     = "jagl jubb oypy omtq";
                $mail->SMTPSecure   = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port         = 587;

                // info do remetente
                $mail->setFrom("clarkluthor380@gmail.com", "TSONY SCHOOL");
                $mail->addReplyTo($email, $nome);

                // info do destinario
                $mail->addAddress("juliusrapha@hotmail.com");

                // configs do email
                $mail->isHTML(true); // corpo da mensage aceita html
                $mail->Subject = mb_convert_encoding($nome ." - Site Tsony School", "UTF-8", "auto"); // Converte para UTF-8
                $mail->Body = mb_convert_encoding(
                    "<h3>Nome do Remetente: <em>". $nome . "</em></h3>" .
                    "<p>Mensagem: ". $mensagem . "</p>" . 
                    "<br/>" . 
                    "<p><em> Enviado do site www.tsonyschool.com </em></p>", "UTF-8", "auto"
                ); 
                
                // Define UTF-8 para evitar problemas com acentos
                $mail->CharSet = 'UTF-8';

                // Enviar o e-mail
                if ($mail->send()) {
                    echo json_encode(['success' => true, 'message' => 'E-mail enviado com sucesso!']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao enviar o e-mail. Tente novamente.']);
                }

            } catch (Exception $th) {
                echo json_encode(['message' => 'Erro: ' . $th->getMessage()]);
            }
            
        } else {
            echo json_encode(['message' => 'Por favor, preencha todos os campos.']);
            exit;
        }
        exit;
        
    }

}

// Verifique se o método foi chamado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crie uma instância do controlador e chame o método
    $controller = new Contato();
    $controller->contacte();
}